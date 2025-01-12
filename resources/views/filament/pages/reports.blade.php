<x-filament-panels::page>
    <div style="display: flex; justify-content: flex-end; align-items: center; gap: 25px;">
        <div>
            {{ $this->form }}
        </div>
        <div style="margin-top: 31px;">
            <x-filament::button icon="heroicon-o-magnifying-glass" style="width: 100px;" wire:click.prevent="search">
                Search
            </x-filament::button>
        </div>
        <div style="margin-top: 31px;">
            <!-- Button that shows after loading is complete -->
            <x-filament::button icon="heroicon-o-printer" style="width: 100px;" wire:click.prevent="print"
                wire:target="getData" wire:loading.remove>
                Print
            </x-filament::button>
        </div>
    </div>
    <div x-init="$wire.getData()" x-data="{ items: @entangle('case').live }"
        class="w-full gap-4 fi-wi-stats-overview-stat relative rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <table class="styled-table w-full">
            <thead>
                <tr style="text-align: center;">
                    <th>KEY RESULTS AREA</th>
                    <th>KEY INDICATORS OF PERFORMANCE</th>
                    <th>Total</th>
                    <th>CR</th>
                    <th>CV</th>
                    <th>ADM1</th>
                    <th>ADM2</th>
                    <th>ADM3</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-weight: bold;">I. RENDITION OF JUDICIAL SERVICES</td>
                    <td style="font-weight: bold;">A. REGULAR SERVICES</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;">1. Cases pending, beginning</td>
                    <td x-text="items.casePending.totalPending"></td>
                    <td x-text="items.casePending.crPending"></td>
                    <td x-text="items.casePending.cvPending"></td>
                    <td x-text="items.casePending.adPending"></td>
                    <td x-text="items.casePending.totalADM2"></td>
                    <td x-text="items.casePending.adm3Pending"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;"> 2. New Cases Received</td>
                    <td x-text="items.caseReceived.totalNewReceived"></td>
                    <td x-text="items.caseReceived.totalCriminalReceived"></td>
                    <td x-text="items.caseReceived.totalCivilReceived"></td>
                    <td x-text="items.caseReceived.totalAdministrativeReceived"></td>
                    <td x-text="items.caseReceived.totalADM2Received"></td>
                    <td x-text="items.caseReceived.totalLaborReceived"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 20px;">2.1. No. of clients involved</td>
                    <td x-text="items.caseReceived2One.totalNewReceived2One"></td>
                    <td x-text="items.caseReceived2One.totalCriminalReceived2One"></td>
                    <td x-text="items.caseReceived2One.totalCivilReceived2One"></td>
                    <td x-text="items.caseReceived2One.totalAdministrativeReceived2One"></td>
                    <td>0</td>
                    <td x-text="items.caseReceived2One.totalLaborReceived2One"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;"> 3. Cases received from another PAO lawyer</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;"> 4. Cases transferred to another PAO lawyer</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;"> 5. Total Cases Handled (Item 1+2+3-4)</td>
                    <td x-text="items.CaseHandled.totalCaseHandled"></td>
                    <td x-text="items.CaseHandled.totalCriminalCaseHandled"></td>
                    <td x-text="items.CaseHandled.totalCivilCaseHandled"></td>
                    <td x-text="items.CaseHandled.totalAdministrativeCaseHandled"></td>
                    <td x-text="items.CaseHandled.totalADM2Handled"></td>
                    <td x-text="items.CaseHandled.totalLaborCaseHandled"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;"> 6. Total Terminated Cases/Disposition (Old + New)</td>
                    <td x-text="items.terminated.totalTerminated"></td>
                    <td x-text="items.terminated.totalCriminalTerminated"></td>
                    <td x-text="items.terminated.totalCivilTerminated"></td>
                    <td x-text="items.terminated.totalAdministrativeTerminated"></td>
                    <td x-text="items.terminated.totalADM2CriminalTerminated"></td>
                    <td x-text="items.terminated.totalLaborTerminated"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 20px;"> a. Old Cases</td>
                    <td x-text="items.terminatedA.totalTerminatedA"></td>
                    <td x-text="items.terminatedA.totalCriminalTerminatedA"></td>
                    <td x-text="items.terminatedA.totalCivilTerminatedA"></td>
                    <td x-text="items.terminatedA.totalAdministrativeTerminatedA"></td>
                    <td x-text="items.terminatedA.totalADM2TerminatedA"></td>
                    <td x-text="items.terminatedA.totalLaborTerminatedA"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 20px;"> b. New Cases</td>
                    <td x-text="items.terminatedB.totalTerminatedB"></td>
                    <td x-text="items.terminatedB.totalCriminalTerminatedB"></td>
                    <td x-text="items.terminatedB.totalCivilTerminatedB"></td>
                    <td x-text="items.terminatedB.totalAdministrativeTerminatedB"></td>
                    <td x-text="items.terminatedB.totalADM2TerminatedB"></td>
                    <td x-text="items.terminatedB.totalLaborTerminatedB"></td>
                </tr>
                <tr>
                    <td></td>
                    <td> Status (terminated cases / dispositions)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;"> I. Favorable Dispositions to Clients </td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;text-indent: 20px;"> a. Acquitted </td>
                    <td x-text="items.acquited.totalAcquited"></td>
                    <td x-text="items.acquited.totalCriminalAcquited"></td>
                    <td x-text="items.acquited.totalCivilAcquited"></td>
                    <td x-text="items.acquited.totalAdministrativeAcquited"></td>
                    <td x-text="items.acquited.totalADM2Acquited"></td>
                    <td x-text="items.acquited.totalLaborAcquited"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;"> a.1. No. of clients involved</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;text-indent: 20px;"> b. Dismissed with prejudice</td>
                    <td x-text="items.dismissedwithPrejudice.totalDismissedWithPrejudice"></td>
                    <td x-text="items.dismissedwithPrejudice.totalCriminalDismissedWithPrejudice"></td>
                    <td x-text="items.dismissedwithPrejudice.totalCivilDismissedWithPrejudice"></td>
                    <td x-text="items.dismissedwithPrejudice.totalAdministrativeDismissedWithPrejudice"></td>
                    <td x-text="items.dismissedwithPrejudice.totalADM2DismissedWithPrejudice"></td>
                    <td x-text="items.dismissedwithPrejudice.totalLaborDismissedWithPrejudice"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;"> b.1. No. of clients involved</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;text-indent: 20px;"> c. Motion to quash granted</td>
                    <td x-text="items.motionToQuashGranted.totalMotionToQuashGranted"></td>
                    <td x-text="items.motionToQuashGranted.totalCriminalMotionToQuashGranted"></td>
                    <td x-text="items.motionToQuashGranted.totalCivilMotionToQuashGranted"></td>
                    <td x-text="items.motionToQuashGranted.totalAdministrativeMotionToQuashGranted"></td>
                    <td x-text="items.motionToQuashGranted.totalADM2MotionToQuashGranted"></td>
                    <td x-text="items.motionToQuashGranted.totalLaborMotionToQuashGranted"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;"> c.1. No. of clients involved</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;text-indent: 20px;"> d. Demurrer to evidence granted</td>
                    <td x-text="items.demurrerToEvidenceGranted.totalDemurrerToEvidenceGranted"></td>
                    <td x-text="items.demurrerToEvidenceGranted.totalCriminalDemurrerToEvidenceGranted"></td>
                    <td x-text="items.demurrerToEvidenceGranted.totalCivilDemurrerToEvidenceGranted"></td>
                    <td x-text="items.demurrerToEvidenceGranted.totalAdministrativeDemurrerToEvidenceGranted"></td>
                    <td x-text="items.demurrerToEvidenceGranted.totalADM2DemurrerToEvidenceGranted"></td>
                    <td x-text="items.demurrerToEvidenceGranted.totalLaborDemurrerToEvidenceGranted"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;"> d.1. No. of clients involved</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;text-indent: 20px;"> e. Provisionally dismissed</td>
                    <td x-text="items.provisionallyDismissed.totalProvisionallyDismissed"></td>
                    <td x-text="items.provisionallyDismissed.totalCriminalProvisionallyDismissed"></td>
                    <td x-text="items.provisionallyDismissed.totalCivilProvisionallyDismissed"></td>
                    <td x-text="items.provisionallyDismissed.totalAdministrativeProvisionallyDismissed"></td>
                    <td x-text="items.provisionallyDismissed.totalADM2ProvisionallyDismissed"></td>
                    <td x-text="items.provisionallyDismissed.totalLaborProvisionallyDismissed"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;"> e.1. No. of clients involved</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;text-indent: 20px;"> f. Convicted to lesser offense</td>
                    <td x-text="items.convictedToLesserOffense.totalConvictedToLesserOffense"></td>
                    <td x-text="items.convictedToLesserOffense.totalCriminalConvictedToLesserOffense"></td>
                    <td x-text="items.convictedToLesserOffense.totalCivilConvictedToLesserOffense"></td>
                    <td x-text="items.convictedToLesserOffense.totalAdministrativeConvictedToLesserOffense"></td>
                    <td x-text="items.convictedToLesserOffense.totalADM2ConvictedToLesserOffense"></td>
                    <td x-text="items.convictedToLesserOffense.totalLaborConvictedToLesserOffense"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;"> f.1. No. of clients involved</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;text-indent: 20px;"> g. Probation granted</td>
                    <td x-text="items.probationGranted.totalProbationGranted"></td>
                    <td x-text="items.probationGranted.totalCriminalProbationGranted"></td>
                    <td x-text="items.probationGranted.totalCivilProbationGranted"></td>
                    <td x-text="items.probationGranted.totalAdministrativeProbationGranted"></td>
                    <td x-text="items.probationGranted.totalADM2ProbationGranted"></td>
                    <td x-text="items.probationGranted.totalLaborProbationGranted"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;"> g.1. No. of clients involved</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;text-indent: 20px;"> h. Won (civil, labor, and administrative)</td>
                    <td x-text="items.wonCivil.totalWonCivil"></td>
                    <td x-text="items.wonCivil.totalCriminalWonCivil"></td>
                    <td x-text="items.wonCivil.totalCivilWonCivil"></td>
                    <td x-text="items.wonCivil.totalAdministrativeWonCivil"></td>
                    <td x-text="items.wonCivil.totalADM2WonCivil"></td>
                    <td x-text="items.wonCivil.totalLaborWonCivil"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;"> h.1. No. of clients involved</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;text-indent: 20px;"> i. Granted lesser award (civil, administrative &
                        labor)</td>
                    <td x-text="items.grantedAwarded.totalGrantedAwarded"></td>
                    <td x-text="items.grantedAwarded.totalCriminalGrantedAwarded"></td>
                    <td x-text="items.grantedAwarded.totalCivilGrantedAwarded"></td>
                    <td x-text="items.grantedAwarded.totalAdministrativeGrantedAwarded"></td>
                    <td x-text="items.grantedAwarded.totalADM2GrantedAwarded"></td>
                    <td x-text="items.grantedAwarded.totalLaborGrantedAwarded"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;"> i.1. No. of clients involved</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;text-indent: 20px;"> j. Dismissed cases based on compromise agreement
                        (civil & labor)
                    </td>
                    <td x-text="items.dismissedCompromise.totalDismissedCompromise"></td>
                    <td x-text="items.dismissedCompromise.totalCriminalDismissedCompromise"></td>
                    <td x-text="items.dismissedCompromise.totalCivilDismissedCompromise"></td>
                    <td x-text="items.dismissedCompromise.totalAdministrativeDismissedCompromise"></td>
                    <td x-text="items.dismissedCompromise.totalADM2DismissedCompromise"></td>
                    <td x-text="items.dismissedCompromise.totalLaborDismissedCompromise"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;"> j.1. No. of clients involved</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;text-indent: 20px;">k. Criminal cases for preliminary investigation
                    </td>
                    <td x-text="items.casesForPreliminaryInvestigation.totalCasePreliminaryInvestigation"></td>
                    <td x-text="items.casesForPreliminaryInvestigation.totalCriminalCasesForPreliminaryInvestigation">
                    </td>
                    <td x-text="items.casesForPreliminaryInvestigation.totalCivilCasesForPreliminaryInvestigation">
                    </td>
                    <td
                        x-text="items.casesForPreliminaryInvestigation.totalAdministrativeCasesForPreliminaryInvestigation">
                    </td>
                    <td
                        x-text="items.casesForPreliminaryInvestigation.totalADM2CriminalCasesForPreliminaryInvestigation">
                    </td>
                    <td x-text="items.casesForPreliminaryInvestigation.totalLaborCasesForPreliminaryInvestigation">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;font-weight: bold;"> k.1. Case filed in court (complainant) </td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 60px;">k.1.1. No. of clients involved</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;font-weight: bold;">k.2. Dismissed (respondent)</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 60px;">k.2.1. No. of clients involved </td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;text-indent: 20px;">l. Pre-trial releases and other dispositions
                    </td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;font-weight: bold;">l.1. Bail (Non-bailable offense)</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 60px;">l.1.1. No. of clients involved</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;font-weight: bold;">l.2. Recognizance</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 60px;">l.2.1. No. of clients involved</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;font-weight: bold;">l.3. Diversion proceedings / Intervention</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 60px;"> l.3.1. No. of clients involved </td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;font-weight: bold;">l.4. Suspended sentence</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 60px;"> l.4.1. No. of clients involved</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;font-weight: bold;">l.5. Maximum imposable penalty served</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 60px;"> l.5.1. No. of clients involved</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;">II. Unfavorable Dispositions to Clients </td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;text-indent: 20px;"> a. Convicted as charged </td>
                    <td x-text="items.convictedAsCharged.totalConvictedAsCharged"></td>
                    <td x-text="items.convictedAsCharged.totalCriminalConvictedAsCharged"></td>
                    <td x-text="items.convictedAsCharged.totalCivilConvictedAsCharged"></td>
                    <td x-text="items.convictedAsCharged.totalAdministrativeConvictedAsCharged"></td>
                    <td x-text="items.convictedAsCharged.totalADM2ConvictedAsCharged"></td>
                    <td x-text="items.convictedAsCharged.totalLaborConvictedAsCharged"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;">a.1. No. of clients involved</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;text-indent: 20px;">b. Lost (civil, administrative & labor)</td>
                    <td x-text="items.lostCivilLabor.totalLostCivilAdministrativeLabor"></td>
                    <td x-text="items.lostCivilLabor.totalCriminalCivilAdministrativeLabor"></td>
                    <td x-text="items.lostCivilLabor.totalCivilCivilAdministrativeLabor"></td>
                    <td x-text="items.lostCivilLabor.totalAdministrativeCivilAdministrativeLabor"></td>
                    <td x-text="items.lostCivilLabor.totalADM2LostCivilAdministrativeLabor"></td>
                    <td x-text="items.lostCivilLabor.totalLaborCivilAdministrativeLabor"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;">b.1. No. of clients involved</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;text-indent: 20px;">c. Dismissed (civil, administrative & labor)</td>
                    <td x-text="items.dismissedCAL.totalDismissedCAL"></td>
                    <td x-text="items.dismissedCAL.totalCriminalCAL"></td>
                    <td x-text="items.dismissedCAL.totalCivilCAL"></td>
                    <td x-text="items.dismissedCAL.totalAdministrativeCAL"></td>
                    <td x-text="items.dismissedCAL.totalADM2DismissedCAL"></td>
                    <td x-text="items.dismissedCAL.totalLaborCAL"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;">c.1. No. of clients involved </td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;text-indent: 20px;"> d. Criminal cases for preliminary investigation
                    </td>
                    <td x-text="items.preliminaryInvestigation.totalPreliminaryInvestigation"></td>
                    <td x-text="items.preliminaryInvestigation.totalCriminalPreliminaryInvestigation"></td>
                    <td x-text="items.preliminaryInvestigation.totalCivilPreliminaryInvestigation"></td>
                    <td x-text="items.preliminaryInvestigation.totalAdministrativePreliminaryInvestigation"></td>
                    <td x-text="items.preliminaryInvestigation.totalADM2PreliminaryInvestigation"></td>
                    <td x-text="items.preliminaryInvestigation.totalLaborPreliminaryInvestigation"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;font-weight: bold;">d.1. Dismissed (complainant) </td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 60px;"> d.1.1. No. of clients involved </td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 40px;font-weight: bold;">d.2. Cases filed in court (respondent) </td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-indent: 60px;">d.2.1. No. of clients involved </td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            </tbody>
        </table>
    </div>
    <style>
        .styled-table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
        }

        .styled-table thead tr {
            background-color: #0D9488;
            color: white;
            text-align: left;
            border-radius: 12px;
        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }

        .styled-table thead th:first-child {
            border-top-left-radius: 12px;
        }

        .styled-table thead th:last-child {
            border-top-right-radius: 12px;
        }

        .styled-table tbody tr {
            border-bottom: 1px solid #ddd;
        }

        .styled-table tbody tr:last-child {
            border-bottom: none;
        }

        .styled-table tr {
            font-size: 12px;
        }
    </style>
</x-filament-panels::page>
