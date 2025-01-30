<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PWARequest;
use App\Http\Resources\PWAResource;
use App\Services\PWAService;
use Exception;

class PWAController extends AdminController
{
    public PWAService $pwaService;

    public function __construct(PWAService $pwaService)
    {
        parent::__construct();
        $this->pwaService = $pwaService;
        $this->middleware(['permission:settings'])->only('update');
    }

    public function index(): \Illuminate\Foundation\Application|\Illuminate\Http\Response|PWAResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return new PWAResource($this->pwaService->list());
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function update(PWARequest $request): \Illuminate\Foundation\Application|\Illuminate\Http\Response|PWAResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return new PWAResource($this->pwaService->update($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
