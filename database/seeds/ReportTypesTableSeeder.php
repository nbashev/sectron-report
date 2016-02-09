<?php

use Illuminate\Database\Seeder;

class ReportTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = App\ReportType::firstOrCreate(['name' => 'Сервис']);
        $type = App\ReportType::firstOrCreate(['name' => 'Техничка подршка']);
        $type = App\ReportType::firstOrCreate(['name' => 'Теренска работа']);
        $type = App\ReportType::firstOrCreate(['name' => 'Останата работа']);
    }
}
