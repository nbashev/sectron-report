<?php

namespace App\Http\Controllers;

use App;
use App\Http\Controllers\Controller;
use App\Lista;
use App\Report;
use App\ReportType;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Input;
use PDF;
use Response;
use View;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $monday = Carbon::now()->startOfWeek();
        $friday = Carbon::now()->endOfWeek()->addDays(-1); //including Saturday

        $reports = Report::where('datetime', '>=', $monday->toDateTimeString())
            ->where('datetime', '<=', $friday->toDateTimeString())
            ->where('user_id', Auth::user()->id)
            ->with('type', 'lists')
            ->orderBy('datetime')
            ->get();

        $weekNum = Carbon::now()->weekOfYear;

        $report_types = ReportType::all();

        return view('pages.reports', compact('reports', 'weekNum', 'report_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @rparam  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $report = (isset($_POST["data"]) && !empty($_POST["data"])) ? $_POST["data"] : [];
        $rep['datetime'] = $report['datetime'];

        print_r(Auth::user()->id);

        $rep['user_id'] = Auth::user()->id;
        $rep['type_id'] = $report['type_id'];

        // $r = Report::where('datetime', $rep['datetime'])->where('type_id', $rep['type_id'])->first();
        $r = Report::firstOrCreate(['datetime' => $rep['datetime'], 'type_id' => $rep['type_id'], 'user_id' => $rep['user_id']]);

        print_r($r);

        $list = [];
        foreach ($report['list'] as $rep_list) {
            array_push($list, ['text' => $rep_list, 'report_id' => $r->id]);
            $r->lists()->create(['text' => $rep_list, 'report_id' => $r->id]);
        }

        echo $r->id;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $report = Report::find($id);
        //get array of ajax data
        $update_data = Input::get('data');

        if ($report->type_id != $update_data['type_id']) {
            $report = Report::firstOrNew(['datetime' => $update_data['datetime'],
                'type_id' => $update_data['type_id'],
                'user_id' => Auth::user()->id]);
            $report->save();
            print_r($report);
        }

        print_r($update_data);

        // update the current lists
        $i = 0;
        foreach ($update_data['list'] as $data) {
            $affectedRows = Lista::where('id', $update_data['list_to_update'][$i])->update(array('text' => $data));
            $i++;
        }
        // delete lists if any
        if (isset($update_data['list_to_delete'])) {
            Lista::destroy($update_data['list_to_delete']);
        }
        // instert new lists
        if (isset($update_data['list_new'])) {
            $list = [];
            foreach ($update_data['list_new'] as $data) {
                array_push($list, ['text' => $data, 'report_id' => $report->id]);
                $report->lists()->create(['text' => $data, 'report_id' => $report->id]);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $report = Report::find($id);
        $report->lists()->delete();
        $report->delete();
        // return $id;
    }

    public function pdf()
    {

        $monday = Carbon::now()->startOfWeek();
        $saturday = Carbon::now()->endOfWeek()->addDays(-1);
        $dt = Carbon::now();

        $reports = Report::where('datetime', '>=', $monday->toDateTimeString())
            ->where('datetime', '<=', $saturday->toDateTimeString())
            ->where('user_id', Auth::user()->id)
            ->with('type', 'lists')
            ->orderBy('datetime')
            ->get();

        $weekNum = Carbon::now()->weekOfYear;
        $user = Auth::user();
        $report_types = ReportType::all();

        // -- for testing on php web serve problem with assets

        // return $view = View::make('reports.generate-report', compact('reports', 'weekNum', 'report_types', 'user', 'dt'))->render();
        // $pdf = PDF::loadView('reports.generate-pdf', compact('reports', 'weekNum', 'report_types', 'user', 'dt'));
        // return $pdf->stream('izvestaj_' . $user->name . '_nedela_' . $weekNum . '_datum_' . $dt . '.pdf');

        $pdf = PDF::loadView('reports.generate-report', compact('reports', 'weekNum', 'report_types', 'user', 'dt'));
        return $pdf->stream('izvestaj_' . $user->name . '_nedela_' . $weekNum . '_datum_' . $dt . '.pdf');

    }

    public function reports($from, $to)
    {
        $reports = Report::where('datetime', '>=', $from)
            ->where('datetime', '<=', $to)
            ->where('user_id', Auth::user()->id)
            ->with('type', 'lists')
            ->orderBy('datetime')
            ->get();

        return $reports;

    }

}
