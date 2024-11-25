<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraphController extends Controller
{
    public function PieChartFilter(Request $request)
    {
        return DB::table(DB::raw('(SELECT 1 AS month UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12) AS months'))->leftJoin(
            DB::raw('(
            SELECT
                MONTH(created_at) as month,
                COUNT(*) as total 
            FROM inter_view_sheets
            WHERE YEAR(created_at) = YEAR(CURRENT_DATE)
            AND doc_type = "'.$request->type.'"  
            GROUP BY month
        ) AS consumption'),
            'months.month',
            '=',
            'consumption.month'
        )
            ->select('months.month', DB::raw('COALESCE(consumption.total, 0) as total'))
            ->orderBy('months.month')
            ->get()
            ->map(fn ($item) => $item->total);
    }

    public function BarChartFilter(Request $request)
    {
        return DB::table(DB::raw('(SELECT 1 AS month UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12) AS months'))
            ->leftJoin(
                DB::raw('(
        SELECT
            MONTH(created_at) as month,
            COUNT(*) as total 
        FROM transactions
        WHERE YEAR(created_at) = YEAR(CURRENT_DATE)
        AND status = "'.$request->type.'"  -- Filtering by status
        GROUP BY month
    ) AS consumption'),
                'months.month',
                '=',
                'consumption.month'
            )
            ->select('months.month', DB::raw('COALESCE(consumption.total, 0) as total'))
            ->orderBy('months.month')
            ->get()
            ->map(fn ($item) => $item->total);
    }

    public function LineChartFilter(Request $request)
    {
        $currentYear = Carbon::now()->year;

        $years = $request->yearOldNew == 'old' ? collect(range($currentYear - 10, $currentYear - 1)) : collect(range($currentYear, $currentYear));

        $values = $years->map(function ($year) use ($request) {
            return Transaction::where('created_at', '>=', Carbon::parse($year.'-01-01')->format('Y-m-d'))
                ->where('created_at', '<', Carbon::parse(($year + 1).'-01-01')->format('Y-m-d'))
                ->where('case_type', $request->typeCase)
                ->count();
        });

        return [
            'years' => $years,
            'values' => $values,
        ];
    }
}
