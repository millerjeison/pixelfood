<?php

namespace Database\Seeders;

use App\Enums\Activity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Dipokhalder\EnvEditor\EnvEditor;
use App\Models\WhatsappOrderSetup;
use Illuminate\Database\Seeder;

class WhatsappOrderSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $envService = new EnvEditor();
        if ($envService->getValue('DEMO')) {
            WhatsappOrderSetup::create([
                'branch_id'      => 1,
                'phone'          => '01676667726',
                'status'         =>  Activity::ENABLE
            ]);

            WhatsappOrderSetup::create([
                'branch_id'      => 2,
                'phone'          => '01676667726',
                'status'         =>  Activity::ENABLE
            ]);
        }
    }
}
