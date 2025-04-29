<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FundsUtilization;
use App\Models\VariationOrder;
use App\Models\Project;

class FundsUtilizationController extends Controller
{
    public function getFundUtilization($project_id)
    {
        $fundUtilization = FundsUtilization::where('project_id', $project_id)->first();
        $variationOrders = [];

        if ($fundUtilization) {
            $variationOrders = VariationOrder::where('funds_utilization_id', $fundUtilization->id)
                                             ->orderBy('vo_number')
                                             ->get();
        }

        $project = Project::find($project_id);

        if (!$project) {
            return response()->json([
                'status' => 'error',
                'message' => 'Project not found.'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $fundUtilization,
            'variationOrders' => $variationOrders,
            'projectTitle' => $project->projectTitle ?? '',
        ]);
    }

    public function storeFundUtilization(Request $request)
    {
        DB::beginTransaction();
    
        try {
            $variationOrders = $request->input('variation_orders', []);
            $summary = $request->input('summary', []);
            $partialBillings = $request->input('partialBillings', []);
            $fundData = $request->except(['_token', 'variation_orders', 'summary', 'partialBillings']);

            \Log::info('Incoming Fund Utilization Data', [
                'summary' => $summary,
                'partialBillings' => $partialBillings,
                'fundData' => $fundData
            ]);

            $project = Project::find($request->project_id);
            if ($project) {
                $project->update([
                    'abc' => $this->cleanMoney($fundData['orig_abc'] ?? null),
                    'contractAmount' => $this->cleanMoney($fundData['orig_contract_amount'] ?? null),
                    'engineering' => $this->cleanMoney($fundData['orig_engineering'] ?? null),
                    'mqc' => $this->cleanMoney($fundData['orig_mqc'] ?? null),
                    'contingency' => $this->cleanMoney($fundData['orig_contingency'] ?? null),
                    'bid' => $this->cleanMoney($fundData['orig_bid'] ?? null),
                    'appropriation' => $this->cleanMoney($fundData['orig_appropriation'] ?? null),
                ]);
            }

            $fundUtilization = FundsUtilization::updateOrCreate(
                ['project_id' => $request->project_id],
                [
                    'orig_abc' => $this->cleanMoney($fundData['orig_abc'] ?? null),
                    'orig_contract_amount' => $this->cleanMoney($fundData['orig_contract_amount'] ?? null),
                    'orig_engineering' => $this->cleanMoney($fundData['orig_engineering'] ?? null),
                    'orig_mqc' => $this->cleanMoney($fundData['orig_mqc'] ?? null),
                    'orig_contingency' => $this->cleanMoney($fundData['orig_contingency'] ?? null),
                    'orig_bid' => $this->cleanMoney($fundData['orig_bid'] ?? null),
                    'orig_appropriation' => $this->cleanMoney($fundData['orig_appropriation'] ?? null),
                    'actual_abc' => $this->cleanMoney($fundData['actual_abc'] ?? null),
                    'actual_contract_amount' => $this->cleanMoney($fundData['actual_contract_amount'] ?? null),
                    'actual_engineering' => $this->cleanMoney($fundData['actual_engineering'] ?? null),
                    'actual_mqc' => $this->cleanMoney($fundData['actual_mqc'] ?? null),
                    'actual_bid' => $this->cleanMoney($fundData['actual_bid'] ?? null),
                    'actual_contingency' => $this->cleanMoney($fundData['actual_contingency'] ?? null),
                    'actual_appropriation' => $this->cleanMoney($fundData['actual_appropriation'] ?? null),
                    'summary' => $summary,
                    'partial_billings' => $partialBillings,
                    'updated_at' => now()
                ]
            );

            VariationOrder::where('funds_utilization_id', $fundUtilization->id)->delete();

            foreach ($variationOrders as $index => $vo) {
                VariationOrder::create([
                    'funds_utilization_id' => $fundUtilization->id,
                    'vo_number' => $index + 1,
                    'vo_abc' => $this->cleanMoney($vo['vo_abc'] ?? null),
                    'vo_contract_amount' => $this->cleanMoney($vo['vo_contract_amount'] ?? null),
                    'vo_engineering' => $this->cleanMoney($vo['vo_engineering'] ?? null),
                    'vo_mqc' => $this->cleanMoney($vo['vo_mqc'] ?? null),
                    'vo_bid' => $this->cleanMoney($vo['vo_bid'] ?? null),
                    'vo_contingency' => $this->cleanMoney($vo['vo_contingency'] ?? null),
                    'vo_appropriation' => $this->cleanMoney($vo['vo_appropriation'] ?? null),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Fund Utilization, Summary, and Variation Orders saved successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error saving fund utilization: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save fund utilization.'
            ], 500);
        }
    }

    /**
     * Helper function to clean currency strings (₱, commas, etc.)
     */
    private function cleanMoney($value)
    {
        return $value ? str_replace([',', '₱', 'Php', 'php'], '', $value) : null;
    }
}
