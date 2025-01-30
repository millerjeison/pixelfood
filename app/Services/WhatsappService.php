<?php 
namespace App\Services;
use App\Models\WhatsappOrderSetup;
use Exception;
use Illuminate\Support\Facades\Log;
use Dipokhalder\EnvEditor\EnvEditor;
use App\Http\Requests\WhatsappRequest;
use Smartisan\Settings\Facades\Settings;

class WhatsappService {
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
            return WhatsappOrderSetup::with('branch')->get();
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }


        /**
     * @throws Exception
     */
    public function store(WhatsappRequest $request)
    {
        try {
            return WhatsappOrderSetup::create($request->validated());
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function update(WhatsappRequest $request, WhatsappOrderSetup $whatsappOrderSetup)
    {
        try {
            return tap($whatsappOrderSetup)->update($request->validated());
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function destroy(WhatsappOrderSetup $whatsappOrderSetup)
    {
        try {
            return $whatsappOrderSetup->delete();
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function branchSetup($branchId)
    {
        try {
            if(!blank($branchId)){
                return WhatsappOrderSetup::where('branch_id', $branchId)->first();
            }
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }
}