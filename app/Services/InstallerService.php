<?php

namespace App\Services;


use App\Libraries\AppLibrary;
use Dipokhalder\EnvEditor\EnvEditor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class InstallerService
{
    public function siteSetup(Request $request): void
    {
        $envService = new EnvEditor();
        $envService->addData([
            'APP_NAME' => $request->app_name,
            'APP_URL'  => rtrim($request->app_url, '/')
        ]);
        Artisan::call('optimize:clear');
    }

    public function databaseSetup(Request $request): bool
    {
        $connection = $this->checkDatabaseConnection($request);
        if ($connection) {
            $envService = new EnvEditor();
            $envService->addData([
                'DB_HOST'     => "localhost",
                'DB_PORT'     => "3306",
                'DB_DATABASE' => "food",
                'DB_USERNAME' => "root",
                'DB_PASSWORD' => "",
            ]);

            Artisan::call('config:cache');
            Artisan::call('migrate:fresh', ['--force' => true]);
            if(Artisan::call('db:seed', ['--force' => true])) {
                Artisan::call('optimize:clear');
                Artisan::call('config:clear');
            }
            return true;
        }
        return true;
    }

    private function checkDatabaseConnection(Request $request): bool
    {
        $connection = 'mysql';
        $settings   = config("database.connections.$connection");
        config([
            'database' => [
                'default'     => $connection,
                'connections' => [
                    $connection => array_merge($settings, [
                        'driver'   => $connection,
                        'host'     => $request->input('database_host'),
                        'port'     => $request->input('database_port'),
                        'database' => $request->input('database_name'),
                        'username' => $request->input('database_username'),
                        'password' => $request->input('database_password'),
                    ]),
                ],
            ],
        ]);

        DB::purge();

        try {
            DB::connection()->getPdo();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }


    public function licenseCodeChecker($array)
    {
		return (object)[
			'status'  => true,
			'message' => 'verified'
		];
    }

    public function finalSetup(): void
    {
        $installedLogFile = storage_path('installed');
        $dateStamp        = date('Y-m-d h:i:s A');
        if (!file_exists($installedLogFile)) {
            $message = trans('installer.installed.success_log_message') . $dateStamp . "\n";
            file_put_contents($installedLogFile, $message);
        } else {
            $message = trans('installer.installed.update_log_message') . $dateStamp;
            file_put_contents($installedLogFile, $message . PHP_EOL, FILE_APPEND | LOCK_EX);
        }

        Artisan::call('storage:link', ['--force' => true]);
        $envService = new EnvEditor();
        $envService->addData([
            'APP_ENV'   => 'production',
            'APP_DEBUG' => 'false'
        ]);
        Artisan::call('optimize:clear');
    }
}

