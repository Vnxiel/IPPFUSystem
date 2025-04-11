<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\ActLogs;
use App\Http\Controllers\ActivityLogs;

class FundsUtilization extends Controller
{
    public function getFundUtilization($projectID)
    {
        try {
            // Get fund utilization by project ID
            $fundUtilization = DB::table('funds_utilization_tbl')
                ->where('projectID', $projectID)
                ->first();

            // Get project title from projects_tbl
            $projectTitle = DB::table('projects_tbl')
                ->where('projectID', $projectID)
                ->value('projectTitle');

            return response()->json([
                'status' => 'success',
                'data' => $fundUtilization,
                'projectTitle' => $projectTitle
            ]);

        } catch (\Exception $e) {
            \Log::error('Error fetching fund utilization: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch fund utilization.'
            ], 500);
        }
    }

    public function storeFundUtilization(Request $request)
{
    DB::beginTransaction();

    try {
        // Separate variation orders from main fund data
        $variationOrders = $request->input('variation_orders', []);
        $fundData = $request->except(['_token', 'variation_orders']);

        // Insert or update main fund utilization
        $fundUtilization = DB::table('funds_utilization_tbl')->updateOrInsert(
            ['projectID' => $request->projectID],
            [
                'orig_abc' => $fundData['orig_abc'] ?? null,
                'orig_contract_amount' => $fundData['orig_contractAmount'] ?? null,
                'orig_engineering' => $fundData['orig_engineering'] ?? null,
                'orig_mqc' => $fundData['orig_mqc'] ?? null,
                'orig_bid' => $fundData['orig_bid'] ?? null,
                'orig_appropriation' => $fundData['appropriation'] ?? null,
                'orig_completion_date' => $fundData['completionDate'] ?? null,

                'actual_abc' => $fundData['actual_abc'] ?? null,
                'actual_contract_amount' => $fundData['actual_contractAmount'] ?? null,
                'actual_engineering' => $fundData['actual_engineering'] ?? null,
                'actual_mqc' => $fundData['actual_mqc'] ?? null,
                'actual_bid' => $fundData['actual_bid'] ?? null,
                'actual_contingency' => $fundData['actual_contingency'] ?? null,
                'actual_appropriation' => $fundData['actual_appropriation'] ?? null,
                'actual_completion_date' => $fundData['actual_completionDate'] ?? null,
                'updated_at' => now()
            ]
        );

        // Get ID of the inserted/updated fund utilization row
        $fundID = DB::table('funds_utilization_tbl')
            ->where('projectID', $request->projectID)
            ->value('id');

        // Remove old variation orders if any
        DB::table('variation_orders')->where('funds_utilization_id', $fundID)->delete();

        // Insert variation orders
        foreach ($variationOrders as $vo) {
            DB::table('variation_orders')->insert([
                'funds_utilization_id' => $fundID,
                'vo_abc' => $vo['vo_abc'] ?? null,
                'vo_contract_amount' => $vo['vo_contractAmount'] ?? null,
                'vo_engineering' => $vo['vo_engineering'] ?? null,
                'vo_mqc' => $vo['vo_mqc'] ?? null,
                'vo_contingency' => $vo['vo_contingency'] ?? null,
                'vo_appropriation' => $vo['vo_appropriation'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => 'Fund Utilization and Variation Orders saved successfully.'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Error saving fund utilization: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to save fund utilization and variation orders.'
        ], 500);
    }
}
}
