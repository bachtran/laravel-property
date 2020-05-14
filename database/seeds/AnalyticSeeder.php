<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnalyticSeeder extends Seeder
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
            DB::table('analytic_types')->insert([
                'id' => $record['id'],
                'name' => $record['name'],
                'units' => $record['units'],
                'is_numeric' => $record['is_numeric'] == 'TRUE',
                'num_decimal_places' => $record['num_decimal_places'],
            ]);
        }
    }

    private function get_data()
    {
        $csv_file_path = storage_path('app/analytic_types.csv');
        $csv_file = fopen($csv_file_path, 'r');
        $data = [];
        while (($tmp_data = fgetcsv($csv_file, 0, ',')) !== FALSE) {
            $record = [
                'id' => $tmp_data[0],
                'name' => $tmp_data[1],
                'units' => $tmp_data[2],
                'is_numeric' => $tmp_data[3],
                'num_decimal_places' => $tmp_data[4],
            ];
            $data []= $record;
        }
        fclose($csv_file);
        // Remove header
        unset($data[0]);
        return $data;
    }
}
