<?php

use Illuminate\Database\Seeder;

class StaticPagesGalleriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $data = [];

            for ($y = 1; $y <= 4; $y++) {
                for ($i = 1; $i <= 3; $i++) {
                    $data[] = [
                        'staticpage_id' => $y,
                        'img' => 'spg'.$y.'-'.$i.'.png',
                    ];
                }
            }


            DB::table('staticpage_galleries')->insert($data);
    }
}
