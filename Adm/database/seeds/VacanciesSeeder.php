<?php

use Illuminate\Database\Seeder;

class VacanciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $data = [
                [
		            'id' => '1',
		            'title' => 'Главный бухгалтер',
		            'description' => 'Описание вакансии',
		            'img' => 'v1.png',
		            'status' => '1',
                ],
                [
		            'id' => '2',
		            'title' => 'Директор рус',
		            'description' => 'Описание вакансии',
		            'img' => 'v2.png',
		            'status' => '1',
                ],
                [
		            'id' => '3',
		            'title' => 'Маркетолог рус',
		            'description' => 'Описание вакансии',
		            'img' => 'v3.png',
		            'status' => '1',
                ],
                [
		            'id' => '4',
		            'title' => 'Дизайнер рус',
		            'description' => 'Описание вакансии',
		            'img' => 'v4.png',
		            'status' => '1',
                ],
                
            ];
            DB::table('vacancies')->insert($data);

    }
}
