<?php

use Illuminate\Database\Seeder;

class ListaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Lista::class, 200)->create();

        $all_lists = App\Lista::all();
        $report_count = App\Report::all()->count();

        foreach ($all_lists as $list) {
            $list->report_id = rand(1, $report_count);
            $list->save();
        }
    }
}
