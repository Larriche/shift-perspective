<?php

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filename = storage_path('/app/questions.csv');
        $file = fopen($filename, "r");

        while (($data = fgetcsv($file, 200, ",")) !== false) {
            DB::table('questions')->insert([
                'question' => $data[0],
                'dimension' => $data[1],
                'direction' => $data[2]
            ]);
        }
    }
}
