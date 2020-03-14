<?php

use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
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
		            'title' => 'Сервис первый',
		            'description' => 'Полное Описание первого сервиса Полное Описание первого сервиса Полное Описание первого сервиса Полное Описание первого сервиса Полное Описание первого сервиса Полное Описание первого сервиса Полное Описание первого сервиса Полное Описание первого сервиса  Полное Описание первого сервиса Полное Описание первого сервиса Полное Описание первого сервиса',
		            'short_description' => 'Краткое описание первого сервиса Краткое описание первого сервиса',
		            'meta_desc' => 'Мета описание',
		            'meta_tags' => 'Мета тэг',
		            'status' => '1',
		            'img' => 's1.png',
		        ],
		        [
		            'id' => '2',
		            'title' => 'Сервис Второй',
		            'description' => ' Полное Описание второго сервиса Полное Описание второго сервиса Полное Описание второго сервиса Полное Описание второго сервиса Полное Описание второго сервиса Полное Описание второго сервиса Полное Описание второго сервиса Полное Описание второго сервиса Полное Описание второго сервиса Полное Описание второго сервиса Полное Описание второго сервиса',
		            'short_description' => ' Краткое описание второго сервиса Краткое описание второго сервиса Краткое описание второго сервиса',
		            'meta_desc' => 'Мета описание',
		            'meta_tags' => 'Мета тэг',
		            'status' => '1',
		            'img' => 's2.png',
		        ],
		        [
		            'id' => '3',
		            'title' => 'Сервис Третий',
		            'description' => ' Полное Описание третей услуги Полное Описание третей услуги Полное Описание третей услуги Полное Описание третей услуги Полное Описание третей услуги Полное Описание третей услуги Полное Описание третей услуги Полное Описание третей услуги Полное Описание третей услуги Полное Описание третей услуги Полное Описание третей услуги Полное Описание третей услуги',
		            'short_description' => ' Краткое описание третьего сервиса Краткое описание третьего сервиса Краткое описание третьего сервиса',
		            'meta_desc' => 'Мета описание',
		            'meta_tags' => 'Мета тэг',
		            'status' => '1',
		            'img' => 's3.png',
		        ],
		        [
		            'id' => '4',
		            'title' => 'Сервис четвертый',
		            'description' => 'Полное Описание четвртого сервиса Полное Описание четвртого сервиса Полное Описание четвртого сервиса Полное Описание четвртого сервиса Полное Описание четвртого сервиса Полное Описание четвртого сервиса Полное Описание четвртого сервиса Полное Описание четвртого сервиса  Полное Описание четвртого сервиса Полное Описание четвртого сервиса Полное Описание четвртого сервиса',
		            'short_description' => 'Краткое описание четвртого сервиса Краткое описание четвртого сервиса',
		            'meta_desc' => 'Мета описание',
		            'meta_tags' => 'Мета тэг',
		            'status' => '1',
		            'img' => 's1.png',
		        ],
		        [
		            'id' => '5',
		            'title' => 'Сервис Пятый',
		            'description' => ' Полное Описание Пятого сервиса Полное Описание Пятого сервиса Полное Описание Пятого сервиса Полное Описание Пятого сервиса Полное Описание Пятого сервиса Полное Описание Пятого сервиса Полное Описание Пятого сервиса Полное Описание Пятого сервиса Полное Описание Пятого сервиса Полное Описание Пятого сервиса Полное Описание Пятого сервиса',
		            'short_description' => ' Краткое описание Пятого сервиса Краткое описание Пятого сервиса Краткое описание Пятого сервиса',
		            'meta_desc' => 'Мета описание',
		            'meta_tags' => 'Мета тэг',
		            'status' => '1',
		            'img' => 's2.png',
		        ],
		        [
		            'id' => '6',
		            'title' => 'Сервис Шестой',
		            'description' => ' Полное Описание шестой услуги Полное Описание шестой услуги Полное Описание шестой услуги Полное Описание шестой услуги Полное Описание шестой услуги Полное Описание шестой услуги Полное Описание шестой услуги Полное Описание шестой услуги Полное Описание шестой услуги Полное Описание шестой услуги Полное Описание шестой услуги Полное Описание шестой услуги',
		            'short_description' => ' Краткое описание третьего сервиса Краткое описание третьего сервиса Краткое описание третьего сервиса',
		            'meta_desc' => 'Мета описание',
		            'meta_tags' => 'Мета тэг',
		            'status' => '1',
		            'img' => 's3.png',
		        ],
		];
		DB::table('services')->insert($data);
    }
}
