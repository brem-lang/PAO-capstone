<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;

class BarChart extends ChartWidget
{
    protected static ?string $heading = 'Criminal Cases';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Total Case',
                    'data' => [120, 150, 200, 250, 300],
                ],
            ],
            'labels' => ['2020', '2021', '2022', '2023', '2024'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',  // Make the bars horizontal
            'scales' => [
                'x' => [
                    'beginAtZero' => true,  // Ensure X-axis starts at 0
                ],
                'y' => [
                    'beginAtZero' => true,  // Ensure Y-axis starts at 0
                ],
            ],
        ];
    }
}
