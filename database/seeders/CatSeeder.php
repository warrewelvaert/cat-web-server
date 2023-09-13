<?php

namespace Database\Seeders;

use App\Models\Cat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = fopen(storage_path("csv/cat_breeds_basic_info.csv"), 'r');
        $header = fgetcsv($file);
        $data = [];
        while ($row = fgetcsv($file)) {
            $data[] = array_combine($header, $row);
        }
        fclose($file);

        $model = new Cat();
        foreach ($data as $row) {
            $model->create($row);
        }
    }
}
