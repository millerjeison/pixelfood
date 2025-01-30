<?php

namespace Database\Seeders;

use App\Models\Subscriber;
use Dipokhalder\EnvEditor\EnvEditor;
use Illuminate\Database\Seeder;

class SubscriberTableSeeder extends Seeder
{
    public function run()
    {
        $envService = new EnvEditor();
        if ($envService->getValue('DEMO')) {
            $subscribers = [
                [
                    'email' => 'favixiw592@eryod.com',
                ],
                [
                    'email' => 'johndoe@gmail.com',
                ],
                [
                    'email' => 'jackshon@gmail.com',
                ],
                [
                    'email' => 'kabirkundu@gmail.com',
                ],
                [
                    'email' => 'nohau@gmail.com',
                ],
                [
                    'email' => 'citadel@gmail.com',
                ],
                [
                    'email' => 'jrdowine@gmail.com',
                ],
                [
                    'email' => 'johnboostrap@gmail.com',
                ],
                [
                    'email' => 'sukla@gmail.com',
                ],
                [
                    'email' => 'rennu@gmail.com',
                ],
            ];

            foreach ($subscribers as $subscriber) {
                Subscriber::create($subscriber);
            }
        }
    }
}
