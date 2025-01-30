<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\NotificationSetting;
use Dipokhalder\EnvEditor\EnvEditor;
use Smartisan\Settings\Facades\Settings;


class NotificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $envService = new EnvEditor();
        Settings::group('notification')->set([
            'notification_fcm_public_vapid_key'    => $envService->getValue('DEMO') ? 'BLS2gBEFn0hRgiWLek8Mxsugd58XSJhdqgZ-xuGRhxZZWpX9GZerVXzWZ368OKW81_WA_IAED0FPm49PDFaXAac' : '',
            'notification_fcm_api_key'             => $envService->getValue('DEMO') ? 'AIzaSyA6ngEoX_-ngKeQa8Kq2AWps_C2w-4JliY' : '',
            'notification_fcm_auth_domain'         => $envService->getValue('DEMO') ? 'foodappi-f4f14.firebaseapp.com' : '',
            'notification_fcm_project_id'          => $envService->getValue('DEMO') ? 'foodappi-f4f14' : '',
            'notification_fcm_storage_bucket'      => $envService->getValue('DEMO') ? 'foodappi-f4f14.appspot.com' : '',
            'notification_fcm_messaging_sender_id' => $envService->getValue('DEMO') ? '1007415649902' : '',
            'notification_fcm_app_id'              => $envService->getValue('DEMO') ? '1:1007415649902:web:42dedc623d98bdee97687f' : '',
            'notification_fcm_measurement_id'      => $envService->getValue('DEMO') ? 'G-MSY9XE6JW3' : '',
            'notification_fcm_json_file'           => '',
        ]);

        if ($envService->getValue('DEMO') && file_exists(public_path('/file/service-account-file.json'))) {
            $setting = NotificationSetting::where('key', 'notification_fcm_json_file')->first();
            $setting->addMedia(public_path('/file/service-account-file.json'))->preservingOriginal()->usingFileName('service-account-file.json')->toMediaCollection('notification-file');
        }
    }
}
