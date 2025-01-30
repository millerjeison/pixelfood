<?php

namespace App\Services;

use Exception;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactRequest;
use Smartisan\Settings\Facades\Settings;

class ContactService
{

    public function sendEmail(ContactRequest $request): void
    {
        try {
            Mail::to(Settings::group('company')->get('company_email'))->send(new ContactMail($request));
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }
}
