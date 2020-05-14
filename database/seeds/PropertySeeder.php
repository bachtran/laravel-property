<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertySeeder extends Seeder
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
            DB::table('properties')->insert([
                'id' => $record['id'],
                'guid' => $record['id'],
                'suburb' => $record['suburb'],
                'state' => $record['state'],
                'country' => $record['country'],
            ]);
        }
    }

    private function get_data()
    {
        $csv_file_path = storage_path('app/properties.csv');
        $csv_file = fopen($csv_file_path, 'r');
        $data = [];
        while (($tmp_data = fgetcsv($csv_file, 0, ',')) !== FALSE) {
            $record = [
                'id' => $tmp_data[0],
                'suburb' => $tmp_data[1],
                'state' => $tmp_data[2],
                'country' => $tmp_data[3],
            ];
            $data []= $record;
        }
        fclose($csv_file);
        // Remove header
        unset($data[0]);
        return $data;
    }
}
