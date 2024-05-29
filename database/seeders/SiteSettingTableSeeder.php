<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        SiteSetting::create([
        	'email' => 'info@yoursite.com',
        	'title' => 'My Site'
        ]);
    }
}
