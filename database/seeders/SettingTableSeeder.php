<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Setting::insert([
            [
            'headerImage'=>'header.png',
            'footerImage'=>'footer.png',
            'facebook'=>'https://www.facebook.com/',
            'linkedin'=>'https://www.linkedin.com/',
            'youtube'=>'https://www.youtube.com/',
            'instagram'=>'https://www.instagram.com/',
            'aboutus'=>'TajaKhana is a site for all your hungry needs.',
            'email'=>'info@tajamandi.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}
