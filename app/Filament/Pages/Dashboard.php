<?php

namespace App\Filament\Pages;

use App\Models\CalendarEvents;
use App\Models\InterViewSheet;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    protected static ?int $navigationSort = 1;

    public $pieData = [];

    public $pieLabel = [];

    public $barData = [];

    public $years = [];

    public $calendarData = [];

    public $values = [];

    public $genderData = [];

    public $appointmentData = [];

    public $monthlyCase = [];

    public function mount()
    {
        if (! auth()->user()->isClient()) {
            $this->getAppointmentRequest();
            $this->getMonthlyChart();
            $this->lineChart();
            $this->getGenderChart();
        } else {
            $events = CalendarEvents::where('user_id', auth()->user()->id)->get();

            $mappedEvents = $events->map(function ($event) {
                return [
                    'id' => $event->id,
                    'name' => $event->user['name'],
                    'title' => $event->title,
                    'start' => $event->startDate,
                    'description' => $event->description,
                ];
            });

            $this->calendarData = $mappedEvents;
        }
    }

    public function getPieData($type)
    {
        $data = InterViewSheet::selectRaw('doc_type, COUNT(*) as total')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereIn('doc_type', ['advice', 'notarize'])
            ->groupBy('doc_type')
            ->pluck('total', 'doc_type')
            ->toArray();

        $this->pieData = array_values($data);
    }

    public function getAppointmentRequest()
    {
        $currentYear = Carbon::now()->year;

        // Advice Requests per month
        $adviceRequests = InterViewSheet::currentYear()
            ->where('doc_type', 'advice')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Notarize Requests per month
        $notarizeRequests = InterViewSheet::currentYear()
            ->where('doc_type', 'notarize')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Fill missing months with zeros

        $this->appointmentData = [
            'advice' => collect(range(1, 12))->map(fn ($month) => $adviceRequests[$month] ?? 0)->toArray(),
            'notarize' => collect(range(1, 12))->map(fn ($month) => $notarizeRequests[$month] ?? 0)->toArray(),
        ];
    }

    public function getMonthlyChart()
    {

        $currentYear = Carbon::now()->year;

        $caseTypes = ['Criminal', 'Civil', 'Administrative', 'Appealed', 'Labor'];

        // Initialize result array
        $data = [];

        foreach ($caseTypes as $caseType) {
            // Fetch transactions grouped by month for the given case type
            $caseCounts = Transaction::whereYear('created_at', $currentYear)
                ->where('case_type', $caseType)
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('count', 'month')
                ->toArray();

            // Fill missing months with 0
            $data[$caseType] = collect(range(1, 12))->map(fn ($month) => $caseCounts[$month] ?? 0)->toArray();
        }
        $this->monthlyCase = $data;
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
            WHERE YEAR(created_at) = YEAR(CURDATE())
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

    public function getGenderChart()
    {
        // Count male clients
        $maleClientsCount = User::where('role', 'client')->where('gender', 'male')->count();

        // Count female clients
        $femaleClientsCount = User::where('role', 'client')->where('gender', 'female')->count();

        $this->genderData = [$maleClientsCount, $femaleClientsCount];
    }
}
