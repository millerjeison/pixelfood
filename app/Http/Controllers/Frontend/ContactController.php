<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use App\Services\ContactService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;


class ContactController extends Controller
{
    public ContactService $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }


    public function sendEmail(ContactRequest $request)
    {
        try {
            return  $this->contactService->sendEmail($request);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}