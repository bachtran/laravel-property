<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyAnalyticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->get_data();
        foreach ($data as $record) {
            DB::table('property_analytics')->insert([
                'property_id' => $record['property_id'],
                'analytic_type_id' => $record['analytic_type_id'],
                'value' => $record['value'],
            ]);
        }
    }

    private function get_data()
    {
        $csv_file_path = storage_path('app/property_analytics.csv');
        $csv_file = fopen($csv_file_path, 'r');
        $data = [];
        while (($tmp_data = fgetcsv($csv_file, 0, ',')) !== FALSE) {
            $record = [
                'property_id' => $tmp_data[0],
                'analytic_type_id' => $tmp_data[1],
                'value' => $tmp_data[2],
            ];
            $data []= $record;
        }
        fclose($csv_file);
        // Remove header
        unset($data[0]);
        return $data;
    }
}
