<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WhatsappRequest;
use App\Http\Resources\WhatsappResource;
use App\Models\WhatsappOrderSetup;
use App\Services\WhatsappService;
use Exception;

class WhatsappController extends AdminController
{
    public WhatsappService $whatsappService;

    public function __construct(WhatsappService $whatsappService)
    {
        parent::__construct();
        $this->whatsappService = $whatsappService;
        $this->middleware(['permission:settings'])->only('index','store','update','destroy');
    }

    public function index()
    {
        try {
            return WhatsappResource::collection($this->whatsappService->list());
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function store(WhatsappRequest $request)
    {
        try {
            return new WhatsappResource($this->whatsappService->store($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function update(WhatsappRequest $request, WhatsappOrderSetup $whatsappOrderSetup)
    {
        try {
            return new WhatsappResource($this->whatsappService->update($request, $whatsappOrderSetup));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function destroy(WhatsappOrderSetup $whatsappOrderSetup)
    {
        try {
            return $this->whatsappService->destroy($whatsappOrderSetup);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
