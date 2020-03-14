<?php

use Illuminate\Database\Seeder;

class TeamTableSeeder extends Seeder
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
		            'name' => 'Бобомурадов Ансар',
		            'short_description' => 'Описание краткое Бобомуродов Ансор Описание краткое Описание краткое',
		            'description' => ' Описание полное Бобомуродов Ансор Описание полное Описание полное Описание полное Описание полное Описание полное Описание полное Описание полное Описание полное Описание полное',
		            'img' => 't1.png',
		            'status' => '1',
                ],
                [
		            'id' => '2',
		            'name' => 'Ташпулатов Сангин',
		            'short_description' => ' Описание краткое Ташпулатов Сангин Описание краткое Ташпулатов Сангин Описание краткое Ташпулатов Сангин',
		            'description' => 'Описание полное Ташпулатов Сангин Описание полное Ташпулатов Сангин Описание полное Ташпулатов Сангин Описание полное Ташпулатов Сангин Описание полное Ташпулатов Сангин Описание полное Ташпулатов Сангин Описание полное Ташпулатов Сангин Описание полное Ташпулатов Сангин Описание полное Ташпулатов Сангин Описание полное Ташпулатов Сангин',
		            'img' => 't2.png',
		            'status' => '1',
                ],
                [
		            'id' => '3',
		            'name' => 'Алиева Хайри',
		            'short_description' => ' Описание краткое Алиева Хайри Описание краткое Алиева Хайри Описание краткое Алиева Хайри',
		            'description' => ' Описание полное Алиева Хайри Описание полное Алиева Хайри Описание полное Алиева Хайри Описание полное Алиева Хайри Описание полное Алиева Хайри Описание полное Алиева Хайри Описание полное Алиева Хайри Описание полное Алиева Хайри Описание полное Алиева Хайри Описание полное Алиева Хайри Описание полное Алиева Хайри',
		            'img' => 't3.png',
		            'status' => '1',
                ],
                [
		            'id' => '4',
		            'name' => 'Шаропов Парвиз',
		            'short_description' => ' Описание краткое Шаропов Парвиз Описание краткое Шаропов Парвиз Описание краткое Шаропов Парвиз',
		            'description' => ' Описание полное Шаропов Парвиз Описание полное Шаропов Парвиз Описание полное Шаропов Парвиз Описание полное Шаропов Парвиз Описание полное Шаропов Парвиз Описание полное Шаропов Парвиз Описание полное Шаропов Парвиз Описание полное Шаропов Парвиз Описание полное Шаропов Парвиз Описание полное Шаропов Парвиз Описание полное Шаропов Парвиз',
		            'img' => 't4.png',
		            'status' => '1',
                ],
                
            ];
            DB::table('teams')->insert($data);
    }
}
