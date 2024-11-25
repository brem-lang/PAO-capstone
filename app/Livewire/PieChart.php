<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PieChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Advice/Notarize';

    protected static ?string $maxHeight = '277px';

    protected function getData(): array
    {
        $type = $this->filters['doc_type'] ?? 'advice';

        $monthlyData = DB::table(DB::raw('(SELECT 1 AS month UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12) AS months'))
            ->leftJoin(
                DB::raw('(
                SELECT
                    MONTH(created_at) as month,
                    COUNT(*) as total  -- Count the number of records with doc_type = "advice"
                FROM inter_view_sheets
                WHERE YEAR(created_at) = YEAR(CURRENT_DATE)
                AND doc_type = "'.$type.'"  -- Only count records where doc_type is "advice"
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

        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => $monthlyData,
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.5)', // Red
                        'rgba(54, 162, 235, 0.5)', // Blue
                        'rgba(255, 206, 86, 0.5)', // Yellow
                        'rgba(75, 192, 192, 0.5)', // Teal
                        'rgba(153, 102, 255, 0.5)', // Purple
                        'rgba(255, 159, 64, 0.5)', // Orange
                        'rgba(201, 203, 207, 0.5)', // Grey
                        'rgba(232, 67, 147, 0.5)', // Pink
                        'rgba(45, 225, 120, 0.5)', // Green
                        'rgba(90, 90, 220, 0.5)',  // Indigo
                        'rgba(255, 223, 186, 0.5)', // Peach
                        'rgba(85, 239, 196, 0.5)',   // Mint
                    ],
                    'borderColor' => [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(201, 203, 207, 1)',
                        'rgba(232, 67, 147, 1)',
                        'rgba(45, 225, 120, 1)',
                        'rgba(90, 90, 220, 1)',
                        'rgba(255, 223, 186, 1)',
                        'rgba(85, 239, 196, 1)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'x' => [
                    'display' => false,
                ],
                'y' => [
                    'display' => false,
                ],
            ],
        ];
    }
}
