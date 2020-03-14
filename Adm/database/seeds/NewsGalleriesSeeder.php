<?php

use Illuminate\Database\Seeder;

class NewsGalleriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $data = [];

            for ($y = 1; $y <= 10; $y++) {
                for ($i = 1; $i <= 3; $i++) {
                    $data[] = [
                        'news_id' => $y,
                        'img' => 'ng'.$y.'-'.$i.'.png',
                    ];
                }
            }


            DB::table('news_galleries')->insert($data);
    }
}
