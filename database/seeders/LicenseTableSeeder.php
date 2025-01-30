<?php

namespace Database\Seeders;


use Dipokhalder\EnvEditor\EnvEditor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Smartisan\Settings\Facades\Settings;

class LicenseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $envService = new EnvEditor();
        Settings::group('license')->set([
            'license_key' => $envService->getValue('MIX_API_KEY')
        ]);
        if ($envService->getValue('DEMO')) {
            Settings::group('license')->set([
                'license_key' => 't8l57bk3-k4d6-48z9-3331-h708j46098r124'
            ]);
            $envService->addData(['MIX_API_KEY' => 't8l57bk3-k4d6-48z9-3331-h708j46098r124']);
            Artisan::call('optimize:clear');
        }
    }
}