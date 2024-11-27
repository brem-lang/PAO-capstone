<?php

namespace App\Filament\Pages;

use App\Models\InterViewSheet;
use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    protected static ?int $navigationSort = 1;

    public $pieData = [];

    public $barData = [];

    public $years = [];

    public $values = [];

    public function mount()
    {
        if (! auth()->user()->isClient()) {
            $this->getPieData('advice');
            $this->getBarDataCase('pending');
            $this->lineChart();
        }
    }

    public function getPieData($type)
    {
        // $this->pieData = InterViewSheet::where('doc_type', 'advice')->where('doc_type', 'notarize')->count();
        $this->pieData = DB::table(DB::raw('(SELECT 1 AS month UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12) AS months'))
            ->leftJoin(
                DB::raw('(
            SELECT
                MONTH(created_at) as month,
                COUNT(*) as total
            FROM inter_view_sheets
            WHERE YEAR(created_at) = YEAR(CURRENT_DATE)
            AND doc_type = "'.$type.'"
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

    public function getBarDataCase($type)
    {
        $this->barData = DB::table(DB::raw('(SELECT 1 AS month UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12) AS months'))
            ->leftJoin(
                DB::raw('(
            SELECT
                MONTH(created_at) as month,
                COUNT(*) as total 
            FROM transactions
            WHERE YEAR(created_at) = YEAR(CURRENT_DATE)
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

    public function lineChart()
    {
        $currentYear = Carbon::now()->year;

        $years = collect(range($currentYear - 10, $currentYear));

        $values = $years->map(function ($year) {
            return Transaction::where('created_at', '>=', Carbon::parse($year.'-01-01')->format('Y-m-d'))
                ->where('created_at', '<', Carbon::parse(($year + 1).'-01-01')->format('Y-m-d'))
                ->count();
        });

        $this->years = $years;
        $this->values = $values;
    }
}
