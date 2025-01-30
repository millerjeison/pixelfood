<?php

namespace Database\Seeders;

use App\Models\Offer;
use Dipokhalder\EnvEditor\EnvEditor;
use Illuminate\Database\Seeder;
use App\Enums\Status;
use Carbon\Carbon;
use Illuminate\Support\Str;

class OfferTableSeeder extends Seeder
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
            $offers = [
                [
                    'name'       => 'New Kings Collection',
                    'slug'       => Str::slug('New Kings Collection'),
                    'amount'     => '5.00',
                    'status'     => Status::ACTIVE,
                    'start_date' => now(),
                    'end_date'   => Carbon::now()->addDay(365),
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name'       => 'New Kings Collection Off $49',
                    'slug'       => Str::slug('New Kings Collection Off $49'),
                    'amount'     => '7.00',
                    'status'     => Status::ACTIVE,
                    'start_date' => now(),
                    'end_date'   => Carbon::now()->addDay(365),
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name'       => 'Free Fiery Chicken',
                    'slug'       => Str::slug('Free Fiery Chicken'),
                    'amount'     => '4.00',
                    'status'     => Status::ACTIVE,
                    'start_date' => now(),
                    'end_date'   => Carbon::now()->addDay(365),
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name'       => 'Free Apple Thik Shake',
                    'slug'       => Str::slug('Free Apple Thik Shake'),
                    'amount'     => '8.00',
                    'status'     => Status::ACTIVE,
                    'start_date' => now(),
                    'end_date'   => Carbon::now()->addDay(365),
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ];

            foreach ($offers as $offer) {
                $offerObject = Offer::create($offer);
                if (file_exists(
                    public_path('/images/seeder/offer/' . strtolower(str_replace(' ', '_', $offer['name'])) . '.png')
                )) {
                    $offerObject->addMedia(
                        public_path(
                            '/images/seeder/offer/' . strtolower(str_replace(' ', '_', $offer['name'])) . '.png'
                        )
                    )->preservingOriginal()->toMediaCollection('offer');
                }
            }
        }
    }
}
