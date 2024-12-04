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

    public $case = [];

    public static function canAccess(): bool
    {
        return ! auth()->user()->isClient();
    }

    public function getData($from = null, $to = null)
    {
        $transactions = Transaction::query();
        $interviewsheet = InterViewSheet::query();

        if ($from && $to) {
            $transactions->whereBetween('created_at', [$from, $to]);

            $interviewsheet->whereBetween('created_at', [$from, $to]);
        }

        $transactions = $transactions->get();
        $interviewsheet = $interviewsheet->get();

        $totalCriminal = 0;
        $totalCivil = 0;
        $totalAdministrative = 0;
        $totalLabor = 0;
        $totalPending = 0;
        $totalADM2 = 0;

        $totalCriminalReceived = 0;
        $totalCivilReceived = 0;
        $totalAdministrativeReceived = 0;
        $totalLaborReceived = 0;
        $totalNewReceived = 0;
        $totalADM2Received = 0;

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
        $totalADM2Handled = 0;

        $totalCriminalTerminated = 0;
        $totalCivilTerminated = 0;
        $totalAdministrativeTerminated = 0;
        $totalLaborTerminated = 0;
        $totalTerminated = 0;
        $totalADM2CriminalTerminated = 0;

        $totalCriminalTerminatedA = 0;
        $totalCivilTerminatedA = 0;
        $totalAdministrativeTerminatedA = 0;
        $totalLaborTerminatedA = 0;
        $totalTerminatedA = 0;
        $totalADM2TerminatedA = 0;

        $totalCriminalTerminatedB = 0;
        $totalCivilTerminatedB = 0;
        $totalAdministrativeTerminatedB = 0;
        $totalLaborTerminatedB = 0;
        $totalTerminatedB = 0;
        $totalADM2TerminatedB = 0;

        $totalAcquited = 0;
        $totalCriminalAcquited = 0;
        $totalCivilAcquited = 0;
        $totalAdministrativeAcquited = 0;
        $totalLaborAcquited = 0;
        $totalADM2Acquited = 0;

        $totalDismissedWithPrejudice = 0;
        $totalCriminalDismissedWithPrejudice = 0;
        $totalCivilDismissedWithPrejudice = 0;
        $totalAdministrativeDismissedWithPrejudice = 0;
        $totalLaborDismissedWithPrejudice = 0;
        $totalADM2DismissedWithPrejudice = 0;

        $totalMotionToQuashGranted = 0;
        $totalCriminalMotionToQuashGranted = 0;
        $totalCivilMotionToQuashGranted = 0;
        $totalAdministrativeMotionToQuashGranted = 0;
        $totalLaborMotionToQuashGranted = 0;
        $totalADM2MotionToQuashGranted = 0;

        $totalDemurrerToEvidenceGranted = 0;
        $totalCriminalDemurrerToEvidenceGranted = 0;
        $totalCivilDemurrerToEvidenceGranted = 0;
        $totalAdministrativeDemurrerToEvidenceGranted = 0;
        $totalLaborDemurrerToEvidenceGranted = 0;
        $totalADM2DemurrerToEvidenceGranted = 0;

        $totalProvisionallyDismissed = 0;
        $totalCriminalProvisionallyDismissed = 0;
        $totalCivilProvisionallyDismissed = 0;
        $totalAdministrativeProvisionallyDismissed = 0;
        $totalLaborProvisionallyDismissed = 0;
        $totalADM2ProvisionallyDismissed = 0;

        $totalConvictedToLesserOffense = 0;
        $totalCriminalConvictedToLesserOffense = 0;
        $totalCivilConvictedToLesserOffense = 0;
        $totalAdministrativeConvictedToLesserOffense = 0;
        $totalLaborConvictedToLesserOffense = 0;
        $totalADM2ConvictedToLesserOffense = 0;

        $totalProbationGranted = 0;
        $totalCriminalProbationGranted = 0;
        $totalCivilProbationGranted = 0;
        $totalAdministrativeProbationGranted = 0;
        $totalLaborProbationGranted = 0;
        $totalADM2ProbationGranted = 0;

        $totalWonCivil = 0;
        $totalCriminalWonCivil = 0;
        $totalCivilWonCivil = 0;
        $totalAdministrativeWonCivil = 0;
        $totalLaborWonCivil = 0;
        $totalADM2WonCivil = 0;

        $totalGrantedAwarded = 0;
        $totalCriminalGrantedAwarded = 0;
        $totalCivilGrantedAwarded = 0;
        $totalAdministrativeGrantedAwarded = 0;
        $totalLaborGrantedAwarded = 0;
        $totalADM2GrantedAwarded = 0;

        $totalDismissedCompromise = 0;
        $totalCriminalDismissedCompromise = 0;
        $totalCivilDismissedCompromise = 0;
        $totalAdministrativeDismissedCompromise = 0;
        $totalLaborDismissedCompromise = 0;
        $totalADM2DismissedCompromise = 0;

        $totalCriminalCasesForPreliminaryInvestigation = 0;
        $totalCivilCasesForPreliminaryInvestigation = 0;
        $totalAdministrativeCasesForPreliminaryInvestigation = 0;
        $totalLaborCasesForPreliminaryInvestigation = 0;
        $totalCasePreliminaryInvestigation = 0;
        $totalADM2CriminalCasesForPreliminaryInvestigation = 0;

        $totalConvictedAsCharged = 0;
        $totalCriminalConvictedAsCharged = 0;
        $totalCivilConvictedAsCharged = 0;
        $totalAdministrativeConvictedAsCharged = 0;
        $totalLaborConvictedAsCharged = 0;
        $totalADM2ConvictedAsCharged = 0;

        $totalLostCivilAdministrativeLabor = 0;
        $totalCriminalCivilAdministrativeLabor = 0;
        $totalCivilCivilAdministrativeLabor = 0;
        $totalAdministrativeCivilAdministrativeLabor = 0;
        $totalLaborCivilAdministrativeLabor = 0;
        $totalADM2LostCivilAdministrativeLabor = 0;

        $totalDismissedCAL = 0;
        $totalCriminalCAL = 0;
        $totalCivilCAL = 0;
        $totalAdministrativeCAL = 0;
        $totalLaborCAL = 0;
        $totalADM2DismissedCAL = 0;

        $totalPreliminaryInvestigation = 0;
        $totalCriminalPreliminaryInvestigation = 0;
        $totalCivilPreliminaryInvestigation = 0;
        $totalAdministrativePreliminaryInvestigation = 0;
        $totalLaborPreliminaryInvestigation = 0;
        $totalADM2PreliminaryInvestigation = 0;

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

                if ($value->last_action_taken == 'Affidavit Desist') {
                    $totalADM2++;
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
                if ($value->last_action_taken == 'Affidavit Desist') {
                    $totalADM2Received++;
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
            if ($value->last_action_taken == 'Affidavit Desist') {
                $totalADM2Handled++;
            }

            //terminated
            if ($value->status === 'terminated') {
                $totalTerminated++;
                if ($value->case_type == 'Criminal') {
                    $totalCriminalTerminated++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivilTerminated++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrativeTerminated++;
                } elseif ($value->case_type == 'Labor') {
                    $totalLaborTerminated++;
                }
                if ($value->last_action_taken == 'Affidavit Desist') {
                    $totalADM2CriminalTerminated++;
                }
            }
            //old
            if ($value->created_at->year <= Carbon::now()->subYear()->year && $value->status === 'terminated') {
                $totalTerminatedA++;
                if ($value->case_type == 'Criminal') {
                    $totalCriminalTerminatedA++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivilTerminatedA++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrativeTerminatedB++;
                } elseif ($value->case_type == 'Labor') {
                    $totalLaborTerminatedA++;
                }
                if ($value->last_action_taken == 'Affidavit Desist') {
                    $totalADM2TerminatedA++;
                }
            }
            //new
            if ($value->created_at->year == Carbon::now()->year && $value->status === 'terminated') {
                $totalTerminatedB++;
                if ($value->case_type == 'Criminal') {
                    $totalCriminalTerminatedB++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivilTerminatedB++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrativeTerminatedB++;
                } elseif ($value->case_type == 'Labor') {
                    $totalLaborTerminatedB++;
                }
                if ($value->last_action_taken == 'Affidavit Desist') {
                    $totalADM2TerminatedB++;
                }
            }

            //acquited
            if ($value->cause_of_termination === 'Acquitted') {
                $totalAcquited++;
                if ($value->case_type == 'Criminal') {
                    $totalCriminalAcquited++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivilAcquited++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrativeAcquited++;
                } elseif ($value->case_type == 'Labor') {
                    $totalLaborAcquited++;
                }
                if ($value->last_action_taken == 'Affidavit Desist') {
                    $totalADM2Acquited++;
                }
            }
            // Dismissed with prejudice
            if ($value->cause_of_termination === 'Dismissed with prejudice') {
                $totalDismissedWithPrejudice++;

                if ($value->case_type == 'Criminal') {
                    $totalCriminalDismissedWithPrejudice++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivilDismissedWithPrejudice++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrativeDismissedWithPrejudice++;
                } elseif ($value->case_type == 'Labor') {
                    $totalLaborDismissedWithPrejudice++;
                }
                if ($value->last_action_taken == 'Affidavit Desist') {
                    $totalADM2DismissedWithPrejudice++;
                }
            }
            // Motion to quash granted
            if ($value->cause_of_termination === 'Motion to quash granted') {
                $totalMotionToQuashGranted++;

                if ($value->case_type == 'Criminal') {
                    $totalCriminalMotionToQuashGranted++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivilMotionToQuashGranted++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrativeMotionToQuashGranted++;
                } elseif ($value->case_type == 'Labor') {
                    $totalLaborMotionToQuashGranted++;
                }
                if ($value->last_action_taken == 'Affidavit Desist') {
                    $totalADM2MotionToQuashGranted++;
                }
            }
            // Demurrer to evidence granted
            if ($value->cause_of_termination === 'Demurrer to evidence granted') {
                $totalDemurrerToEvidenceGranted++;

                if ($value->case_type == 'Criminal') {
                    $totalCriminalDemurrerToEvidenceGranted++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivilDemurrerToEvidenceGranted++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrativeDemurrerToEvidenceGranted++;
                } elseif ($value->case_type == 'Labor') {
                    $totalLaborDemurrerToEvidenceGranted++;
                }
                if ($value->last_action_taken == 'Affidavit Desist') {
                    $totalADM2DemurrerToEvidenceGranted++;
                }
            }
            // Provisionally dismissed
            if ($value->cause_of_termination === 'Provisionally dismissed') {
                $totalProvisionallyDismissed++;
                if ($value->case_type == 'Criminal') {
                    $totalCriminalProvisionallyDismissed++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivilProvisionallyDismissed++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrativeProvisionallyDismissed++;
                } elseif ($value->case_type == 'Labor') {
                    $totalLaborProvisionallyDismissed++;
                }
                if ($value->last_action_taken == 'Affidavit Desist') {
                    $totalADM2ProvisionallyDismissed++;
                }
            }
            // Convicted to lesser offense
            if ($value->cause_of_termination === 'Convicted to lesser offense') {
                $totalConvictedToLesserOffense++;
                if ($value->case_type == 'Criminal') {
                    $totalCriminalConvictedToLesserOffense++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivilConvictedToLesserOffense++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrativeConvictedToLesserOffense++;
                } elseif ($value->case_type == 'Labor') {
                    $totalLaborConvictedToLesserOffense++;
                }
                if ($value->last_action_taken == 'Affidavit Desist') {
                    $totalADM2ConvictedToLesserOffense++;
                }
            }
            // Probation granted
            if ($value->cause_of_termination === 'Probation granted') {
                $totalProbationGranted++;
                if ($value->case_type == 'Criminal') {
                    $totalCriminalProbationGranted++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivilProbationGranted++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrativeProbationGranted++;
                } elseif ($value->case_type == 'Labor') {
                    $totalLaborProbationGranted++;
                }
                if ($value->last_action_taken == 'Affidavit Desist') {
                    $totalADM2ProbationGranted++;
                }
            }
            // Won (civil, labor, and administrative)
            if ($value->cause_of_termination === 'Won (civil, labor, and administrative)') {
                $totalWonCivil++;
                if ($value->case_type == 'Criminal') {
                    $totalCriminalWonCivil++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivilWonCivil++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrativeWonCivil++;
                } elseif ($value->case_type == 'Labor') {
                    $totalLaborWonCivil++;
                }
                if ($value->last_action_taken == 'Affidavit Desist') {
                    $totalADM2WonCivil++;
                }
            }
            // Granted lesser award (civil, administrative & labor)
            if ($value->cause_of_termination === 'Granted lesser award (civil, administrative & labor)') {
                $totalGrantedAwarded++;
                if ($value->case_type == 'Criminal') {
                    $totalCriminalGrantedAwarded++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivilGrantedAwarded++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrativeGrantedAwarded++;
                } elseif ($value->case_type == 'Labor') {
                    $totalLaborGrantedAwarded++;
                }
                if ($value->last_action_taken == 'Affidavit Desist') {
                    $totalADM2GrantedAwarded++;
                }
            }
            // Dismissed cases based on compromise agreement (civil & labor)
            if ($value->cause_of_termination === 'Dismissed cases based on compromise agreement (civil & labor)') {
                $totalDismissedCompromise++;
                if ($value->case_type == 'Criminal') {
                    $totalCriminalDismissedCompromise++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivilDismissedCompromise++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrativeDismissedCompromise++;
                } elseif ($value->case_type == 'Labor') {
                    $totalLaborDismissedCompromise++;
                }
                if ($value->last_action_taken == 'Affidavit Desist') {
                    $totalADM2DismissedCompromise++;
                }
            }
            // Favorable Criminal cases for preliminary investigation
            if ($value->cause_of_termination === 'Favorable Criminal cases for preliminary investigation') {
                $totalCasePreliminaryInvestigation++;

                if ($value->case_type == 'Criminal') {
                    $totalCriminalCasesForPreliminaryInvestigation++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivilCasesForPreliminaryInvestigation++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrativeCasesForPreliminaryInvestigation++;
                } elseif ($value->case_type == 'Labor') {
                    $totalLaborCasesForPreliminaryInvestigation++;
                }
                if ($value->last_action_taken == 'Affidavit Desist') {
                    $totalADM2CriminalCasesForPreliminaryInvestigation++;
                }
            }
            // Convicted as charged
            if ($value->cause_of_termination === 'Convicted as charged') {
                $totalConvictedAsCharged++;
                if ($value->case_type == 'Criminal') {
                    $totalCriminalConvictedAsCharged++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivilConvictedAsCharged++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrativeConvictedAsCharged++;
                } elseif ($value->case_type == 'Labor') {
                    $totalLaborConvictedAsCharged++;
                }
                if ($value->last_action_taken == 'Affidavit Desist') {
                    $totalADM2ConvictedAsCharged++;
                }
            }
            // Lost (civil, administrative & labor)
            if ($value->cause_of_termination === 'Lost (civil, administrative & labor)') {
                $totalLostCivilAdministrativeLabor++;

                if ($value->case_type == 'Criminal') {
                    $totalCriminalCivilAdministrativeLabor++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivilCivilAdministrativeLabor++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrativeCivilAdministrativeLabor++;
                } elseif ($value->case_type == 'Labor') {
                    $totalLaborCivilAdministrativeLabor++;
                }
                if ($value->last_action_taken == 'Affidavit Desist') {
                    $totalADM2LostCivilAdministrativeLabor++;
                }
            }
            // Dismissed (civil, administrative & labor)
            if ($value->cause_of_termination === 'Dismissed (civil, administrative & labor)') {
                $totalDismissedCAL++;

                if ($value->case_type == 'Criminal') {
                    $totalCriminalCAL++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivilCAL++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrativeCAL++;
                } elseif ($value->case_type == 'Labor') {
                    $totalLaborCAL++;
                }
                if ($value->last_action_taken == 'Affidavit Desist') {
                    $totalADM2DismissedCAL++;
                }
            }

            // Unfavorable Criminal cases for preliminary investigation
            if ($value->cause_of_termination === 'Unfavorable Criminal cases for preliminary investigation') {
                $totalPreliminaryInvestigation++;

                if ($value->case_type == 'Criminal') {
                    $totalCriminalPreliminaryInvestigation++;
                } elseif ($value->case_type == 'Civil') {
                    $totalCivilPreliminaryInvestigation++;
                } elseif ($value->case_type == 'Administrative') {
                    $totalAdministrativePreliminaryInvestigation++;
                } elseif ($value->case_type == 'Labor') {
                    $totalLaborPreliminaryInvestigation++;
                }
                if ($value->last_action_taken == 'Affidavit Desist') {
                    $totalADM2PreliminaryInvestigation++;
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

        $this->case = [
            'casePending' => [
                'totalPending' => $totalPending,
                'crPending' => $totalCriminal,
                'cvPending' => $totalCivil,
                'adPending' => $totalAdministrative,
                'adm3Pending' => $totalLabor,
                'totalADM2' => $totalADM2,
            ],
            'caseReceived' => [
                'totalNewReceived' => $totalNewReceived,
                'totalCriminalReceived' => $totalCriminalReceived,
                'totalCivilReceived' => $totalCivilReceived,
                'totalAdministrativeReceived' => $totalAdministrativeReceived,
                'totalLaborReceived' => $totalLaborReceived,
                'totalADM2Received' => $totalADM2Received,
            ],
            'caseReceived2One' => [
                'totalNewReceived2One' => $totalNewReceived2One,
                'totalCriminalReceived2One' => $totalCriminalReceived2One,
                'totalCivilReceived2One' => $totalCivilReceived2One,
                'totalAdministrativeReceived2One' => $totalAdministrativeReceived2One,
                'totalLaborReceived2One' => $totalLaborReceived2One,
            ],
            'CaseHandled' => [
                'totalCriminalCaseHandled' => $totalCriminalCaseHandled,
                'totalCivilCaseHandled' => $totalCivilCaseHandled,
                'totalAdministrativeCaseHandled' => $totalAdministrativeCaseHandled,
                'totalLaborCaseHandled' => $totalLaborCaseHandled,
                'totalCaseHandled' => $totalCaseHandled,
                'totalADM2Handled' => $totalADM2Handled,
            ],
            'terminated' => [
                'totalCriminalTerminated' => $totalCriminalTerminated,
                'totalCivilTerminated' => $totalCivilTerminated,
                'totalAdministrativeTerminated' => $totalAdministrativeTerminated,
                'totalLaborTerminated' => $totalLaborTerminated,
                'totalTerminated' => $totalTerminated,
                'totalADM2CriminalTerminated' => $totalADM2CriminalTerminated,
            ],
            'terminatedA' => [
                'totalCriminalTerminatedA' => $totalCriminalTerminatedA,
                'totalCivilTerminatedA' => $totalCivilTerminatedA,
                'totalAdministrativeTerminatedA' => $totalAdministrativeTerminatedA,
                'totalLaborTerminatedA' => $totalLaborTerminatedA,
                'totalTerminatedA' => $totalTerminatedA,
                'totalADM2TerminatedA' => $totalADM2TerminatedA,
            ],
            'terminatedB' => [
                'totalCriminalTerminatedB' => $totalCriminalTerminatedB,
                'totalCivilTerminatedB' => $totalCivilTerminatedB,
                'totalAdministrativeTerminatedB' => $totalAdministrativeTerminatedB,
                'totalLaborTerminatedB' => $totalLaborTerminatedB,
                'totalTerminatedB' => $totalTerminatedB,
                'totalADM2TerminatedB' => $totalADM2TerminatedB,
            ],
            'acquited' => [
                'totalCriminalAcquited' => $totalCriminalAcquited,
                'totalCivilAcquited' => $totalCivilAcquited,
                'totalAdministrativeAcquited' => $totalAdministrativeAcquited,
                'totalLaborAcquited' => $totalLaborAcquited,
                'totalAcquited' => $totalAcquited,
                'totalADM2Acquited' => $totalADM2Acquited,
            ],
            'dismissedwithPrejudice' => [
                'totalCriminalDismissedWithPrejudice' => $totalCriminalDismissedWithPrejudice,
                'totalCivilDismissedWithPrejudice' => $totalCivilDismissedWithPrejudice,
                'totalAdministrativeDismissedWithPrejudice' => $totalAdministrativeDismissedWithPrejudice,
                'totalLaborDismissedWithPrejudice' => $totalLaborDismissedWithPrejudice,
                'totalDismissedWithPrejudice' => $totalDismissedWithPrejudice,
                'totalADM2DismissedWithPrejudice' => $totalADM2DismissedWithPrejudice,
            ],
            'motionToQuashGranted' => [
                'totalCriminalMotionToQuashGranted' => $totalCriminalMotionToQuashGranted,
                'totalCivilMotionToQuashGranted' => $totalCivilMotionToQuashGranted,
                'totalAdministrativeMotionToQuashGranted' => $totalAdministrativeMotionToQuashGranted,
                'totalLaborMotionToQuashGranted' => $totalLaborMotionToQuashGranted,
                'totalMotionToQuashGranted' => $totalMotionToQuashGranted,
                'totalADM2MotionToQuashGranted' => $totalADM2MotionToQuashGranted,
            ],
            'demurrerToEvidenceGranted' => [
                'totalCriminalDemurrerToEvidenceGranted' => $totalCriminalDemurrerToEvidenceGranted,
                'totalCivilDemurrerToEvidenceGranted' => $totalCivilDemurrerToEvidenceGranted,
                'totalAdministrativeDemurrerToEvidenceGranted' => $totalAdministrativeDemurrerToEvidenceGranted,
                'totalLaborDemurrerToEvidenceGranted' => $totalLaborDemurrerToEvidenceGranted,
                'totalDemurrerToEvidenceGranted' => $totalDemurrerToEvidenceGranted,
                'totalADM2DemurrerToEvidenceGranted' => $totalADM2DemurrerToEvidenceGranted,
            ],
            'provisionallyDismissed' => [
                'totalCriminalProvisionallyDismissed' => $totalCriminalProvisionallyDismissed,
                'totalCivilProvisionallyDismissed' => $totalCivilProvisionallyDismissed,
                'totalAdministrativeProvisionallyDismissed' => $totalAdministrativeProvisionallyDismissed,
                'totalLaborProvisionallyDismissed' => $totalLaborProvisionallyDismissed,
                'totalProvisionallyDismissed' => $totalProvisionallyDismissed,
                'totalADM2ProvisionallyDismissed' => $totalADM2ProvisionallyDismissed,
            ],
            'convictedToLesserOffense' => [
                'totalCriminalConvictedToLesserOffense' => $totalCriminalConvictedToLesserOffense,
                'totalCivilConvictedToLesserOffense' => $totalCivilConvictedToLesserOffense,
                'totalAdministrativeConvictedToLesserOffense' => $totalAdministrativeConvictedToLesserOffense,
                'totalLaborConvictedToLesserOffense' => $totalLaborConvictedToLesserOffense,
                'totalConvictedToLesserOffense' => $totalConvictedToLesserOffense,
                'totalADM2ConvictedToLesserOffense' => $totalADM2ConvictedToLesserOffense,
            ],
            'probationGranted' => [
                'totalCriminalProbationGranted' => $totalCriminalProbationGranted,
                'totalCivilProbationGranted' => $totalCivilProbationGranted,
                'totalAdministrativeProbationGranted' => $totalAdministrativeProbationGranted,
                'totalLaborProbationGranted' => $totalLaborProbationGranted,
                'totalProbationGranted' => $totalProbationGranted,
                'totalADM2ProbationGranted' => $totalADM2ProbationGranted,
            ],
            'wonCivil' => [
                'totalWonCivil' => $totalWonCivil,
                'totalCriminalWonCivil' => $totalCriminalWonCivil,
                'totalCivilWonCivil' => $totalCivilWonCivil,
                'totalAdministrativeWonCivil' => $totalAdministrativeWonCivil,
                'totalLaborWonCivil' => $totalLaborWonCivil,
                'totalADM2WonCivil' => $totalADM2WonCivil,
            ],
            'grantedAwarded' => [
                'totalGrantedAwarded' => $totalGrantedAwarded,
                'totalCriminalGrantedAwarded' => $totalCriminalGrantedAwarded,
                'totalCivilGrantedAwarded' => $totalCivilGrantedAwarded,
                'totalAdministrativeGrantedAwarded' => $totalAdministrativeGrantedAwarded,
                'totalLaborGrantedAwarded' => $totalLaborGrantedAwarded,
                'totalADM2GrantedAwarded' => $totalADM2GrantedAwarded,
            ],
            'dismissedCompromise' => [
                'totalDismissedCompromise' => $totalDismissedCompromise,
                'totalCriminalDismissedCompromise' => $totalCriminalDismissedCompromise,
                'totalCivilDismissedCompromise' => $totalCivilDismissedCompromise,
                'totalAdministrativeDismissedCompromise' => $totalAdministrativeDismissedCompromise,
                'totalLaborDismissedCompromise' => $totalLaborDismissedCompromise,
                'totalADM2DismissedCompromise' => $totalADM2DismissedCompromise,
            ],
            'casesForPreliminaryInvestigation' => [
                'totalCriminalCasesForPreliminaryInvestigation' => $totalCriminalCasesForPreliminaryInvestigation,
                'totalCivilCasesForPreliminaryInvestigation' => $totalCivilCasesForPreliminaryInvestigation,
                'totalAdministrativeCasesForPreliminaryInvestigation' => $totalAdministrativeCasesForPreliminaryInvestigation,
                'totalLaborCasesForPreliminaryInvestigation' => $totalLaborCasesForPreliminaryInvestigation,
                'totalCasePreliminaryInvestigation' => $totalCasePreliminaryInvestigation,
                'totalADM2CriminalCasesForPreliminaryInvestigation' => $totalADM2CriminalCasesForPreliminaryInvestigation,
            ],
            'convictedAsCharged' => [
                'totalConvictedAsCharged' => $totalConvictedAsCharged,
                'totalCriminalConvictedAsCharged' => $totalCriminalConvictedAsCharged,
                'totalCivilConvictedAsCharged' => $totalCivilConvictedAsCharged,
                'totalAdministrativeConvictedAsCharged' => $totalAdministrativeConvictedAsCharged,
                'totalLaborConvictedAsCharged' => $totalLaborConvictedAsCharged,
                'totalADM2ConvictedAsCharged' => $totalADM2ConvictedAsCharged,
            ],
            'lostCivilLabor' => [
                'totalLostCivilAdministrativeLabor' => $totalLostCivilAdministrativeLabor,
                'totalCriminalCivilAdministrativeLabor' => $totalCriminalCivilAdministrativeLabor,
                'totalCivilCivilAdministrativeLabor' => $totalCivilCivilAdministrativeLabor,
                'totalAdministrativeCivilAdministrativeLabor' => $totalAdministrativeCivilAdministrativeLabor,
                'totalLaborCivilAdministrativeLabor' => $totalLaborCivilAdministrativeLabor,
                'totalADM2LostCivilAdministrativeLabor' => $totalADM2LostCivilAdministrativeLabor,
            ],
            'dismissedCAL' => [
                'totalDismissedCAL' => $totalDismissedCAL,
                'totalCriminalCAL' => $totalCriminalCAL,
                'totalCivilCAL' => $totalCivilCAL,
                'totalAdministrativeCAL' => $totalAdministrativeCAL,
                'totalLaborCAL' => $totalLaborCAL,
                'totalADM2DismissedCAL' => $totalADM2DismissedCAL,
            ],
            'preliminaryInvestigation' => [
                'totalPreliminaryInvestigation' => $totalPreliminaryInvestigation,
                'totalCriminalPreliminaryInvestigation' => $totalCriminalPreliminaryInvestigation,
                'totalCivilPreliminaryInvestigation' => $totalCivilPreliminaryInvestigation,
                'totalAdministrativePreliminaryInvestigation' => $totalAdministrativePreliminaryInvestigation,
                'totalLaborPreliminaryInvestigation' => $totalLaborPreliminaryInvestigation,
                'totalADM2PreliminaryInvestigation' => $totalADM2PreliminaryInvestigation,
            ],
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
        // Get the state from the form
        $data = $this->form->getState();

        // Convert dates to Carbon instances for proper formatting
        $from = $data['from'] ? Carbon::parse($data['from'])->startOfDay() : null;
        $to = $data['to'] ? Carbon::parse($data['to'])->endOfDay() : null;

        // Call the getData method with the filtered from and to dates
        $this->getData($from, $to);
    }

    public function print()
    {
        $this->form->getState();

        $data = $this->case;

        $data['from'] = isset($this->data['from'])
            ? Carbon::parse($this->data['from'])->format('F d, Y')
            : '-';

        $data['to'] = isset($this->data['to'])
            ? Carbon::parse($this->data['to'])->format('F d, Y')
            : '-';

        $data['month'] = Carbon::parse($this->data['to'])->format('F Y');

        $pdf = \PDF::loadView('pdf.reports', $data)->setPaper('legal');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Reports-'.now()->format('Y-m-d h:i:s').'.pdf');
    }
}
