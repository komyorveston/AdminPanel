<?php

use Illuminate\Database\Seeder;

class TopGallerySeeder extends Seeder
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
		            'title' => 'Главная',
		            'img' => '1.png',
		            'status' => '1',
                ],
                [
		            'id' => '2',
		            'title' => 'Главная 2',
		            'img' => '2.png',
		            'status' => '1',
                ],
                [
		            'id' => '3',
		            'title' => 'Главная 3',
		            'img' => '3.png',
		            'status' => '1',
                ],
                [
		            'id' => '4',
		            'title' => 'Галерея 1',
		            'img' => '4.png',
		            'status' => '1',
                ],
                [
		            'id' => '5',
		            'title' => 'Галерея 2',
		            'img' => '5.png',
		            'status' => '1',
                ],
                [
		            'id' => '6',
		            'title' => 'Галерея 3',
		            'img' => '6.png',
		            'status' => '1',
                ],
                
            ];
            DB::table('top_galleries')->insert($data);
    }
}
