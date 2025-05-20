<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\FundsUtilization;
use App\Models\VariationOrder;
use App\Models\Project;
use App\Models\FundsBreakdowns;
use App\Models\MQC;

class FundsUtilizationController extends Controller
{
    public function getFundUtilization($project_id)
    {
        $fundUtilization = FundsUtilization::where('project_id', $project_id)
            ->orderBy('updated_at', 'desc')
            ->first();
    
        $previousData = FundsUtilization::where('project_id', $project_id)
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();
    
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
            'previousData' => $previousData
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
                'fundData' => $fundData,
                'variation_orders' => $variationOrders
            ]);
    
            // Format summary and partial billings
            $formattedSummary = collect($summary)->map(function ($item, $key) {
                if (isset($item['amount'])) {
                    $item['amount'] = $this->cleanMoney($item['amount']);
                }
    
                if ($key === 'mobilization') {
                    if (isset($item['percent'])) {
                        $item['percent'] = floatval($item['percent']);
                    }
    
                    if (isset($item['remaining']['amount'])) {
                        $item['remaining']['amount'] = $this->cleanMoney($item['remaining']['amount']);
                    }
                }
    
                return $item;
            })->toArray();
    
            $formattedBillings = collect($partialBillings)->map(function ($item) {
                $item['amount'] = isset($item['amount']) ? $this->cleanMoney($item['amount']) : null;
                return $item;
            })->toArray();
    
            // Check if fund utilization already exists
            $fundUtilization = FundsUtilization::where('project_id', $request->project_id)->first();
    
            if ($fundUtilization) {
                // Update existing record
                $fundUtilization->update([
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
                    'totalExpenditure' => $this->cleanMoney($fundData['total_expenditure'] ?? null),
                    'totalSavings' => $this->cleanMoney($fundData['total_savings'] ?? null),
                    'summary' => $formattedSummary,
                    'partial_billings' => $formattedBillings,
                    'updated_at' => now(),
                ]);
            } else {
                // Create new record
                $fundUtilization = FundsUtilization::create([
                    'project_id' => $request->project_id,
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
                    'totalExpenditure' => $this->cleanMoney($fundData['total_expenditure'] ?? null),
                    'totalSavings' => $this->cleanMoney($fundData['total_savings'] ?? null),
                    'summary' => $formattedSummary,
                    'partial_billings' => $formattedBillings,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
    
            // Delete existing VOs for this fund utilization
            VariationOrder::where('funds_utilization_id', $fundUtilization->id)->delete();

            // Limit to max 3 VOs
            if (count($variationOrders) > 3) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Only up to 3 Variation Orders are allowed.'
                ], 400);
            }

            // Insert up to 3 VOs with correct numbering
            $voData = [];
            foreach ($variationOrders as $index => $vo) {
                $voData[] = [
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
                ];
            }
            if (!empty($voData)) {
                VariationOrder::insert($voData);
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
    
    public function storeFundDetail(Request $request, $id)
    {
        try {
            $fundUtilization = FundsUtilization::where('project_id', $id)->first();
    
            if (!$fundUtilization) {
                return response()->json(['success' => false, 'message' => 'Fund utilization record not found.']);
            }
    
            $entries = $request->input('entries', []);
    
            // Fallback to single entry if 'entries' array is not used
            if (empty($entries) && $request->has(['type', 'name', 'month', 'period', 'amount'])) {
                $entries = [[
                    'type' => $request->input('type'),
                    'name' => $request->input('name'),
                    'month' => $request->input('month'),
                    'period' => $request->input('period'),
                    'amount' => $request->input('amount'),
                ]];
            }
    
            $duplicates = [];
            $saved = 0;
    
            foreach ($entries as $entry) {
                $type = $entry['type'] ?? null;
                $name = trim($entry['name'] ?? '');
                $month = trim($entry['month'] ?? '');
                $paymentPeriod = $entry['period'] ?? null;
                $amount = $entry['amount'] ?? null;
    
                if (!$type || !$name || !$month || !$paymentPeriod || !$amount) {
                    Log::warning("Skipping incomplete entry: " . json_encode($entry));
                    continue;
                }
    
                // Check for duplicate
                $existing = FundsBreakdowns::where('funds_utilization_id', $fundUtilization->id)
                    ->where('type', $type)
                    ->where('name', $name)
                    ->where('month', $month)
                    ->where('payment_periods', $paymentPeriod)
                    ->first();
    
                if ($existing) {
                    $duplicates[] = "$name ($month, $paymentPeriod)";
                    continue;
                }
    
                FundsBreakdowns::create([
                    'funds_utilization_id' => $fundUtilization->id,
                    'type' => $type,
                    'name' => $name,
                    'month' => $month,
                    'payment_periods' => $paymentPeriod,
                    'amount' => $this->cleanMoney($amount),
                    'date' => now(),
                    'remarks' => null,
                ]);
    
                $saved++;
            }
    
            if ($saved > 0 && count($duplicates) > 0) {
                return response()->json([
                    'success' => true,
                    'message' => "$saved entr" . ($saved > 1 ? "ies" : "y") . " saved. Some duplicates were skipped: " . implode(', ', $duplicates)
                ]);
            } elseif ($saved > 0) {
                return response()->json(['success' => true, 'message' => 'All entries saved successfully.']);
            } else {
                return response()->json(['success' => false, 'message' => 'All entries were duplicates or invalid. Nothing saved.']);
            }
    
        } catch (\Exception $e) {
            Log::error("Failed to store fund detail: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to save.']);
        }
    }
    
    
    
public function getFundsUtilization(Request $request, $project_id)
{
    try {
        $project = Project::find($project_id);
        if (!$project) {
            return redirect()->back()->withErrors(['Project not found.']);
        }

        $fundUtilization = FundsUtilization::where('project_id', $project_id)
            ->orderBy('updated_at', 'desc')
            ->first();

        $funds = [];
        $summary = [];
        $partial_billings = [];
        $engineeringEntries = collect();
        $mqcEntries = collect();

        if ($fundUtilization) {
            $funds = $fundUtilization->only([
                'orig_abc', 'orig_contract_amount', 'orig_engineering', 'orig_mqc',
                'orig_contingency', 'orig_bid', 'orig_appropriation',
                'actual_abc', 'actual_contract_amount', 'actual_engineering',
                'actual_mqc', 'actual_contingency', 'actual_bid', 'actual_appropriation',
            ]);

            // JSON decode with fallback
            if (!empty($fundUtilization->summary)) {
                $summary = is_string($fundUtilization->summary)
                    ? json_decode($fundUtilization->summary, true) ?? []
                    : $fundUtilization->summary;
            }

            if (!empty($fundUtilization->partial_billings)) {
                $partial_billings = is_string($fundUtilization->partial_billings)
                    ? json_decode($fundUtilization->partial_billings, true) ?? []
                    : $fundUtilization->partial_billings;
            }

            $variationOrders = [];
    
           $variationOrders = VariationOrder::where('funds_utilization_id', $fundUtilization->id)
            ->orderBy('vo_number')
            ->orderBy('created_at', 'desc')
            ->get();

            // Fetch engineering and mqc from database
            $engineeringEntries = FundsBreakdowns::where('funds_utilization_id', $fundUtilization->id)
            ->where('type', 'engineering')
            ->orderBy('created_at', 'desc')
            ->get();
           

            \Log::info('Debug engineering entries', [
                'fund_utilization_id' => $fundUtilization->project_id ?? null,
                'engineering_count' => $engineeringEntries->count(),
                'entries' => $engineeringEntries->toArray()
            ]);
            
        

            $mqcEntries = FundsBreakdowns::where('funds_utilization_id', $fundUtilization->id)
                ->where('type', 'mqc')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('systemAdmin.fundsUtilization', compact(
            'project', 'funds', 'summary', 'partial_billings',
            'engineeringEntries', 'mqcEntries', 'variationOrders'
        ));
        

    } catch (\Exception $e) {
        \Log::error('Error fetching fund utilization: ' . $e->getMessage());
        return redirect()->back()->withErrors(['An error occurred while retrieving fund utilization.']);
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