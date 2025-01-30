<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Resources\WhatsappResource;
use App\Models\Branch;
use App\Services\WhatsappService;
use Exception;
use App\Services\BranchService;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\BranchResource;
use App\Http\Controllers\Controller;

class BranchController extends Controller
{
    public BranchService $branchService;
    public WhatsappService $whatsappService;

    public function __construct(BranchService $branch, WhatsappService $whatsappService)
    {
        $this->branchService = $branch;
        $this->whatsappService = $whatsappService;
    }

    public function index(PaginateRequest $request) : \Illuminate\Http\Response | \Illuminate\Http\Resources\Json\AnonymousResourceCollection | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return BranchResource::collection($this->branchService->list($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function show(Branch $branch) : BranchResource | \Illuminate\Http\Response | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return new BranchResource($this->branchService->show($branch));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function whatsappSetup($branchId) 
    {
        try{
            return new WhatsappResource($this->whatsappService->branchSetup($branchId));
        } catch(Exception $exception){
            return response(['status' => false , 'message' => $exception->getMessage()], 422);
        }
    }
}
