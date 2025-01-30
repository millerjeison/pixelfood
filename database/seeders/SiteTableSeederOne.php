<?php

namespace Database\Seeders;


use App\Enums\Activity;
use App\Enums\CurrencyPosition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Smartisan\Settings\Facades\Settings;

class SiteTableSeederOne extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::group('site')->set([
            'site_guest_login'        => Activity::ENABLE,
        ]);

        Artisan::call('optimize:clear');
    }
}
