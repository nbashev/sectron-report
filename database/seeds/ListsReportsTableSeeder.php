<?php

use Illuminate\Database\Seeder;

class ListsReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $all_reports = App\Report::all();
        $list_count = App\Lista::all()->count();
        //$lists_num = range(1, $list_count);
        foreach ($all_reports as $report) {
            for ($i = 1; $i <= rand(1, 5); $i++) {
                // $report->lists()->attach(array_pop($range));
                $lists_num = range(1, $list_count);
                $rand_key = array_rand($lists_num);
                $report->lists()->attach($lists_num[1]);
                unset($lists_num[$rand_key]);
            }
        }
    }
}
