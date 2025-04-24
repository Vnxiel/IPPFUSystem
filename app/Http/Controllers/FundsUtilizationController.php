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

                // Insert or update the main fund utilization using Eloquent
                $fundUtilization = FundsUtilization::updateOrCreate(
                    ['project_id' => $request->project_id],
                    [
                        'orig_abc' => $fundData['orig_abc'] ?? null,
                        'orig_contract_amount' => $fundData['orig_contract_amount'] ?? null,
                        'orig_engineering' => $fundData['orig_engineering'] ?? null,
                        'orig_mqc' => $fundData['orig_mqc'] ?? null,
                        'orig_contingency' => $fundData['orig_contingency'] ?? null,
                        'orig_bid' => $fundData['orig_bid'] ?? null,
                        'orig_appropriation' => $fundData['orig_appropriation'] ?? null,
                        'actual_abc' => $fundData['actual_abc'] ?? null,
                        'actual_contract_amount' => $fundData['actual_contract_amount'] ?? null,
                        'actual_engineering' => $fundData['actual_engineering'] ?? null,
                        'actual_mqc' => $fundData['actual_mqc'] ?? null,
                        'actual_bid' => $fundData['actual_bid'] ?? null,
                        'actual_contingency' => $fundData['actual_contingency'] ?? null,
                        'actual_appropriation' => $fundData['actual_appropriation'] ?? null,
                        'summary' => json_encode($summary),
                        'partial_billings' => json_encode($partialBillings),
                        'updated_at' => now()
                    ]
                );

                // Update original values in the project model
                $project = Project::find($request->project_id);
                if ($project) {
                    $project->update([
                        'abc' => $fundData['orig_abc'] ?? null,
                        'contractAmount' => $fundData['orig_contract_amount'] ?? null,
                        'engineering' => $fundData['orig_engineering'] ?? null,
                        'mqc' => $fundData['orig_mqc'] ?? null,
                        'contingency' => $fundData['orig_contingency'] ?? null,
                        'bid' => $fundData['orig_bid'] ?? null,
                        'appropriation' => $fundData['orig_appropriation'] ?? null,
                    ]);
                }

                // Remove old variation orders
                VariationOrder::where('funds_utilization_id', $fundUtilization->id)->delete();

                // Insert updated variation orders
                foreach ($variationOrders as $index => $vo) {
                    VariationOrder::create([
                        'funds_utilization_id' => $fundUtilization->id,
                        'vo_number' => $index + 1,
                        'vo_abc' => $vo['vo_abc'] ?? null,
                        'vo_contract_amount' => $vo['vo_contract_amount'] ?? null,
                        'vo_engineering' => $vo['vo_engineering'] ?? null,
                        'vo_mqc' => $vo['vo_mqc'] ?? null,
                        'vo_bid' => $vo['vo_bid'] ?? null,
                        'vo_contingency' => $vo['vo_contingency'] ?? null,
                        'vo_appropriation' => $vo['vo_appropriation'] ?? null,
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

}
