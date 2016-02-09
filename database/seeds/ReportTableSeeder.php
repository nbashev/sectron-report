<?php

use Illuminate\Database\Seeder;

class ReportTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $all_types = App\ReportType::all();
        $types_list = range(1, $all_types->count());
        $num_of_report_per_day = rand(1, $all_types->count());

        $date = new Carbon\Carbon('first day of January 2016', 'Europe/Skopje');

        for ($i = 0; $i < 24; $i++) {
            $limit = rand(1, $all_types->count());
            $lists_num = $types_list;
            for ($j = 1; $j <= $limit; $j++) {
                $report = factory(App\Report::class)->make();

                $rand_key = array_rand($lists_num);

                $report->type_id = $lists_num[$rand_key];
                unset($lists_num[$rand_key]);

                $report->datetime = $date;
                $report->save();
            }
            $date->addDay();
        }
    }
}
