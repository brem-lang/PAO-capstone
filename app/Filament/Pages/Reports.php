<?php

namespace App\Filament\Pages;

use App\Models\InterViewSheet;
use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;

class Reports extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.reports';

    protected static ?int $navigationSort = 15;

    public ?array $data = [];

    public $CaseHandled = [];

    public $caseReceived2One = [];

    public $caseReceived = [];

    public $casePending = [];

    public $terminated = [];

    public $terminatedA = [];

    public $terminatedB = [];

    public $caseTypes = ['Criminal', 'Civil', 'Administrative', 'Labor'];

    public static function canAccess(): bool
    {
        return ! auth()->user()->isClient();
    }

    public function mount()
    {
        $transactions = Transaction::get();
        $interviewsheet = InterViewSheet::get();

        $totalCriminal = 0;
        $totalCivil = 0;
        $totalAdministrative = 0;
        $totalLabor = 0;
        $totalPending = 0;

        $totalCriminalReceived = 0;
        $totalCivilReceived = 0;
        $totalAdministrativeReceived = 0;
        $totalLaborReceived = 0;
        $totalNewReceived = 0;

        $totalCriminalReceived2One = 0;
        $totalCivilReceived2One = 0;
        $totalAdministrativeReceived2One = 0;
        $totalLaborReceived2One = 0;
        $totalNewReceived2One = 0;

        $totalCriminalCaseHandled = 0;
        $totalCivilCaseHandled = 0;
        $totalAdministrativeCaseHandled = 0;
        $totalLaborCaseHandled = 0;
        $totalCaseHandled = 0;

        $totalCriminalTerminated = 0;
        $totalCivilTerminated = 0;
        $totalAdministrativeTerminated = 0;
        $totalLaborTerminated = 0;
        $totalTerminated = 0;

        $totalCriminalTerminatedA = 0;
        $totalCivilTerminatedA = 0;
        $totalAdministrativeTerminatedA = 0;
        $totalLaborTerminatedA = 0;
        $totalTerminatedA = 0;

        $totalCriminalTerminatedB = 0;
        $totalCivilTerminatedB = 0;
        $totalAdministrativeTerminatedB = 0;
        $totalLaborTerminatedB = 0;
        $totalTerminatedB = 0;

        foreach ($transactions as $value) {
            if ($value->status === 'pending') {
                $totalPending++;
                if ($value->case_type == 'Criminal') {
                    $totalCriminal++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivil++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrative++;
                } elseif ($value->case_type == 'Labor') {
                    $totalLabor++;
                }
            }
            //new cases received
            if ($value->created_at->between(Carbon::now()->startOfYear(), Carbon::now()->endOfYear())) {
                $totalNewReceived++;
                if ($value->case_type == 'Criminal') {
                    $totalCriminalReceived++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivilReceived++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrativeReceived++;
                } elseif ($value->case_type == 'Labor') {
                    $totalLaborReceived++;
                }
            }
            $totalCaseHandled++;
            if ($value->case_type == 'Criminal') {
                $totalCriminalCaseHandled++;
            } elseif ($value->case_type == 'Civil') {
                $totalCivilCaseHandled++;
            } elseif ($value->case_type == 'Administrative') {
                $totalAdministrativeCaseHandled++;
            } elseif ($value->case_type == 'Labor') {
                $totalLaborCaseHandled++;
            }

            //terminated
            if ($value->status === 'terminated') {
                $totalTerminated++;
                if ($value->case_type == 'Criminal') {
                    $totalCriminalTerminated++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivil++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrative++;
                } elseif ($value->case_type == 'Labor') {
                    $totalLaborTerminated++;
                }
            }
            //old
            if ($value->created_at->year == Carbon::now()->subYear()->year && $value->status === 'terminated') {
                $totalTerminatedB++;
                if ($value->case_type == 'Criminal') {
                    $totalCriminalTerminatedA++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivilTerminatedA++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrativeTerminatedA++;
                } elseif ($value->case_type == 'Labor') {
                    $totalTerminatedA++;
                }
            }
            //new
            if ($value->created_at->year == Carbon::now()->year && $value->status === 'terminated') {
                $totalCriminalTerminatedB++;
                if ($value->case_type == 'Criminal') {
                    $totalCriminalTerminatedB++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivilTerminatedB++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrativeTerminatedB++;
                } elseif ($value->case_type == 'Labor') {
                    $totalTerminatedB++;
                }
            }
        }

        foreach ($interviewsheet as $value) {
            if ($value->doc_type == 'advice') {
                $totalNewReceived2One++;

                if ($value->type_of_case == 'criminal') {
                    $totalCriminalReceived2One++;
                } elseif ($value->case_type == 'civil') {
                    $totalCivilTerminated++;
                } elseif ($value->case_type == 'administrative') {
                    $totalAdministrativeTerminated++;
                } elseif ($value->case_type == 'labor') {
                    $totalLaborReceived2One++;
                }
            }
        }

        // Store the results
        $this->casePending[] = [
            'totalPending' => $totalPending,
            'crPending' => $totalCriminal,
            'cvPending' => $totalCivil,
            'adPending' => $totalAdministrative,
            'adm3Pending' => $totalLabor,
        ];

        $this->caseReceived[] = [
            'totalNewReceived' => $totalNewReceived,
            'totalCriminalReceived' => $totalCriminalReceived,
            'totalCivilReceived' => $totalCivilReceived,
            'totalAdministrativeReceived' => $totalAdministrativeReceived,
            'totalLaborReceived' => $totalLaborReceived,
        ];

        $this->caseReceived2One[] = [
            'totalNewReceived2One' => $totalNewReceived2One,
            'totalCriminalReceived2One' => $totalCriminalReceived2One,
            'totalCivilReceived2One' => $totalCivilReceived2One,
            'totalAdministrativeReceived2One' => $totalAdministrativeReceived2One,
            'totalLaborReceived2One' => $totalLaborReceived2One,
        ];

        $this->CaseHandled[] = [
            'totalCriminalCaseHandled' => $totalCriminalCaseHandled,
            'totalCivilCaseHandled' => $totalCivilCaseHandled,
            'totalAdministrativeCaseHandled' => $totalAdministrativeCaseHandled,
            'totalLaborCaseHandled' => $totalLaborCaseHandled,
            'totalCaseHandled' => $totalCaseHandled,
        ];

        $this->terminated[] = [
            'totalCriminalTerminated' => $totalCriminalTerminated,
            'totalCivilTerminated' => $totalCivilTerminated,
            'totalAdministrativeTerminated' => $totalAdministrativeTerminated,
            'totalLaborTerminated' => $totalLaborTerminated,
            'totalTerminated' => $totalTerminated,
        ];

        $this->terminatedA[] = [
            'totalCriminalTerminatedA' => $totalCriminalTerminatedA,
            'totalCivilTerminatedA' => $totalCivilTerminatedA,
            'totalAdministrativeTerminatedA' => $totalAdministrativeTerminatedA,
            'totalLaborTerminatedA' => $totalLaborTerminatedA,
            'totalTerminatedA' => $totalTerminatedA,
        ];

        $this->terminatedB[] = [
            'totalCriminalTerminatedB' => $totalCriminalTerminatedB,
            'totalCivilTerminatedB' => $totalCivilTerminatedB,
            'totalAdministrativeTerminatedB' => $totalAdministrativeTerminatedB,
            'totalLaborTerminatedB' => $totalLaborTerminatedB,
            'totalTerminatedB' => $totalTerminatedB,
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('from')
                    ->required(),
                DatePicker::make('to')
                    ->required(),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function search()
    {
        dd(true);
    }

    public function print()
    {
        $pdf = \PDF::loadView('pdf.reports', [
            'casePending' => $this->casePending,
            'caseReceived' => $this->caseReceived,
            'caseReceived2One' => $this->caseReceived2One,
            'CaseHandled' => $this->CaseHandled,
            'terminated' => $this->terminated,
            'terminatedA' => $this->terminatedA,
            'terminatedB' => $this->terminatedB,
        ])->setPaper('legal');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Reports-'.now()->format('Y-m-d h:i:s').'.pdf');
    }
}
