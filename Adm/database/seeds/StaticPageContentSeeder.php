<?php

use Illuminate\Database\Seeder;

class StaticPageContentSeeder extends Seeder
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
            		'title' => 'О НАС',
            		'description' => 'О НАС полное описание О НАС полное описание О НАС полное описание О НАС полное описание О НАС полное описание О НАС полное описание О НАС полное описание О НАС полное описание О НАС полное описание О НАС полное описание О НАС полное описание',
            		'short_description'=> ' О НАС короткое описание О НАС короткое описание О НАС короткое описание', 
            		'img' => 'sp1.png', 
            		'alias' => 'about-us', 
            		'status'=> '1',
                ],
                [
                    'id' => '2',
                    'title' => 'Адрес',
                    'description' => 'Улица Шохтемур 5/3 23',
                    'short_description'=> 'Улица Шохтемур 5/3 23', 
                    'img' => 'sp2.png', 
                    'alias' => 'address', 
                    'status'=> '1',
                ],
                [
                    'id' => '3',
                    'title' => 'История',
                    'description' => ' Полное описание истории Полное описание истории Полное описание истории Полное описание истории Полное описание истории Полное описание истории Полное описание истории Полное описание истории Полное описание истории Полное описание истории Полное описание истории',
                    'short_description'=> 'Краткое описание истории Краткое описание истории Краткое описание истории Краткое описание истории', 
                    'img' => 'sp3.png', 
                    'alias' => 'history', 
                    'status'=> '1',
                ],
                [
                    'id' => '4',
                    'title' => 'Контакты',
                    'description' => 'тел: +992-777-777-777 email: admin@admin.ru',
                    'short_description'=> 'тел: +992-777-777-777 email: admin@admin.ru', 
                    'img' => 'sp4.png', 
                    'alias' => 'contacts', 
                    'status'=> '1',
                ],
            ];
            DB::table('static_pages')->insert($data);

    }
}
