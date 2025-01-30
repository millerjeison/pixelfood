<?php 
namespace App\Services;
use App\Http\Requests\PWARequest;
use App\Models\PWASetting;
use Exception;
use Illuminate\Support\Facades\Log;
use Smartisan\Settings\Facades\Settings;
use Illuminate\Support\Facades\Config;
use Dipokhalder\EnvEditor\EnvEditor;
use App\Models\PWA;


class PWAService {



    public EnvEditor $envService;
    public function __construct(EnvEditor $envEditor)
    {
        $this->envService = $envEditor;
    }

    /**
     * @throws Exception
     */
    public function list()
    {
         try {
              return PWA::first();
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function update(PWARequest $request)
    {

        try {
            $pwa =  PWA::first();
            if(!$pwa) {
                $pwa = PWA::create(['id' => 1]);
            }


            if ($request->pwa_splash) {
                $pwa->clearMediaCollection('pwa_splash');
                $pwa->addMedia($request->pwa_splash)->toMediaCollection('pwa_splash');
            }
            if ($request->pwa_icon) {
                $pwa->clearMediaCollection('pwa_icon');
                $pwa->addMedia($request->pwa_icon)->toMediaCollection('pwa_icon');
            }

            if (!empty($pwa->getFirstMediaUrl('pwa_icon'))) {
                $icons = $pwa->getMedia('pwa_icon')->first();
                if($url = $icons->getUrl('D_72x72')){
                    $this->envService->addData([
                        'D_72x72' =>  $icons->getUrl('D_72x72')
                    ]);
                }
                if($url = $icons->getUrl('D_96x96')){
                    $this->envService->addData([
                        'D_96x96' =>  $icons->getUrl('D_96x96')
                    ]);
                }
                if($url = $icons->getUrl('D_128x128')){
                    $this->envService->addData([
                        'D_128x128' =>  $icons->getUrl('D_128x128')
                    ]);
                }
                if($url = $icons->getUrl('D_144x144')){
                    $this->envService->addData([
                        'D_144x144' =>  $icons->getUrl('D_144x144')
                    ]);
                }
                if($url = $icons->getUrl('D_152x152')){
                    $this->envService->addData([
                        'D_152x152' =>  $icons->getUrl('D_152x152')
                    ]);
                }
                if($url = $icons->getUrl('D_192x192')){
                    $this->envService->addData([
                        'D_192x192' =>  $icons->getUrl('D_192x192')
                    ]);
                }
                if($url = $icons->getUrl('D_384x384')){
                    $this->envService->addData([
                        'D_384x384' =>  $icons->getUrl('D_384x384')
                    ]);
                }
                if($url = $icons->getUrl('D_512x512')){
                    $this->envService->addData([
                        'D_512x512' =>  $icons->getUrl('D_512x512')
                    ]);
                }
            }

            if (!empty($pwa->getFirstMediaUrl('pwa_splash'))) {
                $splash = $pwa->getMedia('pwa_splash')->first();
                if($url = $splash->getUrl('D_640x1136')){
                    $this->envService->addData([
                        'D_640x1136' =>  $splash->getUrl('D_640x1136')
                    ]);
                }
                if($url = $splash->getUrl('D_750x1334')){
                    $this->envService->addData([
                        'D_750x1334' =>  $splash->getUrl('D_750x1334')
                    ]);
                }
                if($url = $splash->getUrl('D_828x1792')){
                    $this->envService->addData([
                        'D_828x1792' =>  $splash->getUrl('D_828x1792')
                    ]);
                }
                if($url = $splash->getUrl('D_1125x2436')){
                    $this->envService->addData([
                        'D_1125x2436' =>  $splash->getUrl('D_1125x2436')
                    ]);
                }
                if($url = $splash->getUrl('D_1242x2208')){
                    $this->envService->addData([
                        'D_1242x2208' =>  $splash->getUrl('D_1242x2208')
                    ]);
                }
                if($url = $splash->getUrl('D_1242x2688')){
                    $this->envService->addData([
                        'D_1242x2688' =>  $splash->getUrl('D_1242x2688')
                    ]);
                }
                if($url = $splash->getUrl('D_1536x2048')){
                    $this->envService->addData([
                        'D_1536x2048' =>  $splash->getUrl('D_1536x2048')
                    ]);
                }
                if($url = $splash->getUrl('D_1668x2224')){
                    $this->envService->addData([
                        'D_1668x2224' =>  $splash->getUrl('D_1668x2224')
                    ]);
                }
                if($url = $splash->getUrl('D_1668x2388')){
                    $this->envService->addData([
                        'D_1668x2388' =>  $splash->getUrl('D_1668x2388')
                    ]);
                }
                if($url = $splash->getUrl('D_2048x2732')){
                    $this->envService->addData([
                        'D_2048x2732' =>  $splash->getUrl('D_2048x2732')
                    ]);
                }
            }

            return $pwa;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }
}