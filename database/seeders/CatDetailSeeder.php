<?php

namespace Database\Seeders;

use App\Models\CatsDetails;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = fopen(storage_path("csv/cat_breeds_details.csv"), 'r');
        $header = fgetcsv($file);
        $data = [];
        while ($row = fgetcsv($file)) {
            $data[] = array_combine($header, $row);
        }
        fclose($file);

        $model = new CatsDetails();
        foreach ($data as $row) {
            $model->create($row);
        }
    }
}
