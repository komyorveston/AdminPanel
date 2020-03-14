<?php

use Illuminate\Database\Seeder;

class PartnersSeeder extends Seeder
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
            'name' => 'Алиэкспресс Рус',
            'web_site' => 'www.aliexpress.com',
            'img' => 'l1.png',
            'status' => '1',
        	],
        	[
            'id' => '2',
            'name' => 'Таобао Рус',
            'web_site' => 'www.taobao.com',
            'img' => 'l2.png',
            'status' => '1',
        	],
        	[
            'id' => '3',
            'name' => 'Сифат фарма Рус',
            'web_site' => 'www.sifat-farm.tj',
            'img' => 'l3.png',
            'status' => '1',
        	],
        	[
            'id' => '4',
            'name' => 'Шири Душанбе Рус',
            'web_site' => 'www.sharikfour.tj',
            'img' => 'l4.png',
            'status' => '1',
        	],
        ];

         DB::table('partners')->insert($data);
    }
}
