<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report PDF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Nunito Sans', sans-serif;
        }

        .mheaders {
            margin-top: 30px !important;
        }

        .container {
            width: 100%;
        }

        .layout {
            display: flex;
            align-items: center;
            justify-content: space-between;
            /* Ensure space between elements */
        }

        .report-title {
            flex: 1;
            /* Take up remaining space */
            text-align: center;
            margin-bottom: 30px;
        }

        .report-title h5,
        .report-title h4,
        .report-title h6 {
            margin: 0;
            /* Remove default margin */
            padding: 0;
            /* Remove default padding */
        }

        .report-title h5 {
            margin-bottom: 5px;
            /* Control space between individual h5 elements */
        }

        .report-title h4 {
            margin-bottom: 3px;
            /* Control space between individual h4 elements */
        }

        .report-title h6 {
            margin-bottom: 2px;
            /* Control space between individual h6 elements */
        }

        .mheaders {
            font-weight: bold;
            margin-top: 15px;
            /* Adjust space above the last heading */
        }

        .logo-img {
            max-width: 100px;
            /* Adjust width as needed */
            height: auto;
            /* Maintain aspect ratio */
            position: absolute;
            margin-top: 13px;
            margin-left: 30px;

        }

        .logo-img2 {
            max-width: 105px;
            /* Adjust width as needed */
            height: auto;
            /* Maintain aspect ratio */
            position: absolute;
            margin-top: 10px;
            margin-left: 590px;
        }

        .styled-table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
        }

        .styled-table thead tr {
            /* background-color: #0D9488; */
            /* color: white; */
            text-align: left;
            /* border-radius: 12px; */
        }

        .styled-table th,
        .styled-table td {
            padding: 2px;
            /* padding: 12px 15px; */
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
            font-size: 9px;
        }

        .date {
            text-align: right;
            margin-top: 40px;
        }

        .date1 {
            text-align: left;
        }

        .signature-label {
            margin-top: 5px;
            font-size: 12px;
            position: relative;
            display: inline-block;
        }

        .printed-name {
            align-items: center;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 3px;
            margin-top: -28px;
        }

        .signature-label::before {
            content: '';
            position: absolute;
            top: -8px;
            left: 0;
            width: 100%;
            border-top: 1px solid #000;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="layout">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(asset('images/pao.png'))) }}"
                alt="Logo" class="logo-img">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(asset('images/bggov.png'))) }}"
                alt="Logo" class="logo-img2">
            <div class="report-title">
                <h6>Republika ng Pilipinas</h6>
                <h6>KAGAWARAN NG KATARUNGAN</h6>
                <h5>TANGGAPAN NG MANANANGGOL PAMBAYAN</h5>
                <h5>(PUBLIC ATTORNEY'S OFFICE)</h5>
                <h6 style="font-weight: 100">Regional Office No. XI</h6>
                <h6 style="font-weight: 100">District Office PANABO CITY</h6>
                <h6>INDIVIDUAL PERFORMANCE REPORT</h6>
                <h6 style="font-weight: 100">For the month of <strong>{{ $month }}</strong></h6>
            </div>
        </div>
        {{-- <div class="date">
            <span style="font-size: 10px;">Date: {{ $from }} - {{ $to }}</span><br>
            <span style="font-size: 10px;">Exported Date: {{ now()->timezone('Asia/Manila')->format('F j, Y') }}</span>
        </div> --}}
        <div
            class="w-full gap-4 fi-wi-stats-overview-stat relative rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <table class="styled-table w-full">
                <thead>
                    <tr style="text-align: center; font-size: 10px;">
                        <th>KEY RESULTS AREA</th>
                        <th>KEY INDICATORS OF PERFORMANCE</th>
                        <th>Total</th>
                        <th>Criminal Cases</th>
                        <th>Civil Cases</th>
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
                        <td>{{ $casePending['totalPending'] }}</td>
                        <td>{{ $casePending['crPending'] }}</td>
                        <td>{{ $casePending['cvPending'] }}</td>
                        <td>{{ $casePending['adPending'] }}</td>
                        <td>{{ $casePending['totalADM2'] }}</td>
                        <td>{{ $casePending['adm3Pending'] }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;"> 2. New Cases Received</td>
                        <td>{{ $caseReceived['totalNewReceived'] }}</td>
                        <td>{{ $caseReceived['totalCriminalReceived'] }}</td>
                        <td>{{ $caseReceived['totalCivilReceived'] }}</td>
                        <td>{{ $caseReceived['totalAdministrativeReceived'] }}</td>
                        <td>{{ $caseReceived['totalADM2Received'] }}</td>
                        <td>{{ $caseReceived['totalLaborReceived'] }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 20px;">2.1. No. of clients involved</td>
                        <td x-text="items.caseReceived2One.totalNewReceived2One">
                            {{ $caseReceived2One['totalNewReceived2One'] }}</td>
                        <td x-text="items.caseReceived2One.totalCriminalReceived2One">
                            {{ $caseReceived2One['totalCriminalReceived2One'] }}</td>
                        <td x-text="items.caseReceived2One.totalCivilReceived2One">
                            {{ $caseReceived2One['totalCivilReceived2One'] }}</td>
                        <td x-text="items.caseReceived2One.totalAdministrativeReceived2One">
                            {{ $caseReceived2One['totalAdministrativeReceived2One'] }}</td>
                        <td>0</td>
                        <td x-text="items.caseReceived2One.totalLaborReceived2One">
                            {{ $caseReceived2One['totalLaborReceived2One'] }}</td>
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
                        <td x-text="items.CaseHandled.totalCaseHandled">{{ $CaseHandled['totalCaseHandled'] }}</td>
                        <td x-text="items.CaseHandled.totalCriminalCaseHandled">
                            {{ $CaseHandled['totalCriminalCaseHandled'] }}</td>
                        <td x-text="items.CaseHandled.totalCivilCaseHandled">
                            {{ $CaseHandled['totalCivilCaseHandled'] }}</td>
                        <td x-text="items.CaseHandled.totalAdministrativeCaseHandled">
                            {{ $CaseHandled['totalAdministrativeCaseHandled'] }}</td>
                        <td>{{ $CaseHandled['totalADM2Handled'] }}</td>
                        <td x-text="items.CaseHandled.totalLaborCaseHandled">
                            {{ $CaseHandled['totalLaborCaseHandled'] }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;"> 6. Total Terminated Cases/Disposition (Old + New)</td>
                        <td x-text="items.terminated.totalTerminated">{{ $terminated['totalTerminated'] }}</td>
                        <td x-text="items.terminated.totalCriminalTerminated">
                            {{ $terminated['totalCriminalTerminated'] }}</td>
                        <td x-text="items.terminated.totalCivilTerminated">{{ $terminated['totalCivilTerminated'] }}
                        </td>
                        <td x-text="items.terminated.totalAdministrativeTerminated">
                            {{ $terminated['totalAdministrativeTerminated'] }}</td>
                        <td> {{ $terminated['totalADM2CriminalTerminated'] }}</td>
                        <td x-text="items.terminated.totalLaborTerminated">{{ $terminated['totalLaborTerminated'] }}
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 20px;"> a. Old Cases</td>
                        <td x-text="items.terminatedA.totalTerminatedA">{{ $terminatedA['totalTerminatedA'] }}</td>
                        <td x-text="items.terminatedA.totalCriminalTerminatedA">
                            {{ $terminatedA['totalCriminalTerminatedA'] }}</td>
                        <td x-text="items.terminatedA.totalCivilTerminatedA">
                            {{ $terminatedA['totalCivilTerminatedA'] }}</td>
                        <td x-text="items.terminatedA.totalAdministrativeTerminatedA">
                            {{ $terminatedA['totalAdministrativeTerminatedA'] }}</td>
                        <td> {{ $terminatedA['totalADM2TerminatedA'] }}</td>
                        <td x-text="items.terminatedA.totalLaborTerminatedA">
                            {{ $terminatedA['totalLaborTerminatedA'] }}
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 20px;"> b. New Cases</td>
                        <td x-text="items.terminatedB.totalTerminatedB">{{ $terminatedB['totalTerminatedB'] }}</td>
                        <td x-text="items.terminatedB.totalCriminalTerminatedB">
                            {{ $terminatedB['totalCriminalTerminatedB'] }}</td>
                        <td x-text="items.terminatedB.totalCivilTerminatedB">
                            {{ $terminatedB['totalCivilTerminatedB'] }}</td>
                        <td x-text="items.terminatedB.totalAdministrativeTerminatedB">
                            {{ $terminatedB['totalAdministrativeTerminatedB'] }}</td>
                        <td>{{ $terminatedB['totalADM2TerminatedB'] }}</td>
                        <td x-text="items.terminatedB.totalLaborTerminatedB">
                            {{ $terminatedB['totalLaborTerminatedB'] }}
                        </td>
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
                        <td x-text="items.acquited.totalAcquited">{{ $acquited['totalAcquited'] }}</td>
                        <td x-text="items.acquited.totalCriminalAcquited">
                            {{ $acquited['totalCriminalAcquited'] }}</td>
                        <td x-text="items.acquited.totalCivilAcquited">
                            {{ $acquited['totalCivilAcquited'] }}</td>
                        <td x-text="items.acquited.totalAdministrativeAcquited">
                            {{ $acquited['totalAdministrativeAcquited'] }}</td>
                        <td>{{ $acquited['totalADM2Acquited'] }}</td>
                        <td x-text="items.acquited.totalLaborAcquited">{{ $acquited['totalLaborAcquited'] }}</td>
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
                        <td x-text="items.dismissedwithPrejudice.totalDismissedWithPrejudice">
                            {{ $dismissedwithPrejudice['totalDismissedWithPrejudice'] }}</td>
                        <td x-text="items.dismissedwithPrejudice.totalCriminalDismissedWithPrejudice">
                            {{ $dismissedwithPrejudice['totalCriminalDismissedWithPrejudice'] }}</td>
                        <td x-text="items.dismissedwithPrejudice.totalCivilDismissedWithPrejudice">
                            {{ $dismissedwithPrejudice['totalCivilDismissedWithPrejudice'] }}</td>
                        <td x-text="items.dismissedwithPrejudice.totalAdministrativeDismissedWithPrejudice">
                            {{ $dismissedwithPrejudice['totalAdministrativeDismissedWithPrejudice'] }}</td>
                        <td>{{ $dismissedwithPrejudice['totalADM2DismissedWithPrejudice'] }}</td>
                        <td x-text="items.dismissedwithPrejudice.totalLaborDismissedWithPrejudice">
                            {{ $dismissedwithPrejudice['totalLaborDismissedWithPrejudice'] }}</td>
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
                        <td x-text="items.motionToQuashGranted.totalMotionToQuashGranted">
                            {{ $motionToQuashGranted['totalMotionToQuashGranted'] }}</td>
                        <td x-text="items.motionToQuashGranted.totalCriminalMotionToQuashGranted">
                            {{ $motionToQuashGranted['totalCriminalMotionToQuashGranted'] }}</td>
                        <td x-text="items.motionToQuashGranted.totalCivilMotionToQuashGranted">
                            {{ $motionToQuashGranted['totalCivilMotionToQuashGranted'] }}</td>
                        <td x-text="items.motionToQuashGranted.totalAdministrativeMotionToQuashGranted">
                            {{ $motionToQuashGranted['totalAdministrativeMotionToQuashGranted'] }}</td>
                        <td> {{ $motionToQuashGranted['totalADM2MotionToQuashGranted'] }}</td>
                        <td x-text="items.motionToQuashGranted.totalLaborMotionToQuashGranted">
                            {{ $motionToQuashGranted['totalLaborMotionToQuashGranted'] }}</td>
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
                        <td x-text="items.demurrerToEvidenceGranted.totalDemurrerToEvidenceGranted">
                            {{ $demurrerToEvidenceGranted['totalDemurrerToEvidenceGranted'] }}</td>
                        <td x-text="items.demurrerToEvidenceGranted.totalCriminalDemurrerToEvidenceGranted">
                            {{ $demurrerToEvidenceGranted['totalCriminalDemurrerToEvidenceGranted'] }}</td>
                        <td x-text="items.demurrerToEvidenceGranted.totalCivilDemurrerToEvidenceGranted">
                            {{ $demurrerToEvidenceGranted['totalCivilDemurrerToEvidenceGranted'] }}</td>
                        <td x-text="items.demurrerToEvidenceGranted.totalAdministrativeDemurrerToEvidenceGranted">
                            {{ $demurrerToEvidenceGranted['totalAdministrativeDemurrerToEvidenceGranted'] }}</td>
                        <td> {{ $demurrerToEvidenceGranted['totalADM2DemurrerToEvidenceGranted'] }}</td>
                        <td x-text="items.demurrerToEvidenceGranted.totalLaborDemurrerToEvidenceGranted">
                            {{ $demurrerToEvidenceGranted['totalLaborDemurrerToEvidenceGranted'] }}</td>
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
                        <td x-text="items.provisionallyDismissed.totalProvisionallyDismissed">
                            {{ $provisionallyDismissed['totalProvisionallyDismissed'] }}</td>
                        <td x-text="items.provisionallyDismissed.totalCriminalProvisionallyDismissed">
                            {{ $provisionallyDismissed['totalCriminalProvisionallyDismissed'] }}</td>
                        <td x-text="items.provisionallyDismissed.totalCivilProvisionallyDismissed">
                            {{ $provisionallyDismissed['totalCivilProvisionallyDismissed'] }}</td>
                        <td x-text="items.provisionallyDismissed.totalAdministrativeProvisionallyDismissed">
                            {{ $provisionallyDismissed['totalAdministrativeProvisionallyDismissed'] }}</td>
                        <td> {{ $provisionallyDismissed['totalADM2ProvisionallyDismissed'] }}</td>
                        <td x-text="items.provisionallyDismissed.totalLaborProvisionallyDismissed">
                            {{ $provisionallyDismissed['totalLaborProvisionallyDismissed'] }}</td>
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
                        <td x-text="items.convictedToLesserOffense.totalConvictedToLesserOffense">
                            {{ $convictedToLesserOffense['totalConvictedToLesserOffense'] }}</td>
                        <td x-text="items.convictedToLesserOffense.totalCriminalConvictedToLesserOffense">
                            {{ $convictedToLesserOffense['totalCriminalConvictedToLesserOffense'] }}</td>
                        <td x-text="items.convictedToLesserOffense.totalCivilConvictedToLesserOffense">
                            {{ $convictedToLesserOffense['totalCivilConvictedToLesserOffense'] }}</td>
                        <td x-text="items.convictedToLesserOffense.totalAdministrativeConvictedToLesserOffense">
                            {{ $convictedToLesserOffense['totalAdministrativeConvictedToLesserOffense'] }}</td>
                        <td>{{ $convictedToLesserOffense['totalADM2ConvictedToLesserOffense'] }}</td>
                        <td x-text="items.convictedToLesserOffense.totalLaborConvictedToLesserOffense">
                            {{ $convictedToLesserOffense['totalLaborConvictedToLesserOffense'] }}</td>
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
                        <td x-text="items.probationGranted.totalProbationGranted">
                            {{ $probationGranted['totalProbationGranted'] }}</td>
                        <td x-text="items.probationGranted.totalCriminalProbationGranted">
                            {{ $probationGranted['totalCriminalProbationGranted'] }}</td>
                        <td x-text="items.probationGranted.totalCivilProbationGranted">
                            {{ $probationGranted['totalCivilProbationGranted'] }}</td>
                        <td x-text="items.probationGranted.totalAdministrativeProbationGranted">
                            {{ $probationGranted['totalAdministrativeProbationGranted'] }}</td>
                        <td> {{ $probationGranted['totalADM2ProbationGranted'] }}</td>
                        <td x-text="items.probationGranted.totalLaborProbationGranted">
                            {{ $probationGranted['totalLaborProbationGranted'] }}</td>
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
                        <td style="font-weight: bold;text-indent: 20px;"> h. Won (civil, labor, and administrative)
                        </td>
                        <td x-text="items.wonCivil.totalWonCivil">{{ $wonCivil['totalWonCivil'] }}</td>
                        <td x-text="items.wonCivil.totalCriminalWonCivil">{{ $wonCivil['totalCriminalWonCivil'] }}
                        </td>
                        <td x-text="items.wonCivil.totalCivilWonCivil">{{ $wonCivil['totalCivilWonCivil'] }}</td>
                        <td x-text="items.wonCivil.totalAdministrativeWonCivil">
                            {{ $wonCivil['totalAdministrativeWonCivil'] }}</td>
                        <td> {{ $wonCivil['totalADM2WonCivil'] }}</td>
                        <td x-text="items.wonCivil.totalLaborWonCivil">{{ $wonCivil['totalLaborWonCivil'] }}</td>
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
                        <td style="font-weight: bold;text-indent: 20px;"> i. Granted lesser award (civil,
                            administrative &
                            labor)</td>
                        <td x-text="items.grantedAwarded.totalGrantedAwarded">
                            {{ $grantedAwarded['totalGrantedAwarded'] }}</td>
                        <td x-text="items.grantedAwarded.totalCriminalGrantedAwarded">
                            {{ $grantedAwarded['totalCriminalGrantedAwarded'] }}</td>
                        <td x-text="items.grantedAwarded.totalCivilGrantedAwarded">
                            {{ $grantedAwarded['totalCivilGrantedAwarded'] }}</td>
                        <td x-text="items.grantedAwarded.totalAdministrativeGrantedAwarded">
                            {{ $grantedAwarded['totalAdministrativeGrantedAwarded'] }}</td>
                        <td>{{ $grantedAwarded['totalADM2GrantedAwarded'] }}</td>
                        <td x-text="items.grantedAwarded.totalLaborGrantedAwarded">
                            {{ $grantedAwarded['totalLaborGrantedAwarded'] }}</td>
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
                        <td style="font-weight: bold;text-indent: 20px;"> j. Dismissed cases based on compromise
                            agreement
                            (civil & labor)
                        </td>
                        <td x-text="items.dismissedCompromise.totalDismissedCompromise">
                            {{ $dismissedCompromise['totalDismissedCompromise'] }}</td>
                        <td x-text="items.dismissedCompromise.totalCriminalDismissedCompromise">
                            {{ $dismissedCompromise['totalCriminalDismissedCompromise'] }}</td>
                        <td x-text="items.dismissedCompromise.totalCivilDismissedCompromise">
                            {{ $dismissedCompromise['totalCivilDismissedCompromise'] }}</td>
                        <td x-text="items.dismissedCompromise.totalAdministrativeDismissedCompromise">
                            {{ $dismissedCompromise['totalAdministrativeDismissedCompromise'] }}</td>
                        <td> {{ $dismissedCompromise['totalADM2DismissedCompromise'] }}</td>
                        <td x-text="items.dismissedCompromise.totalLaborDismissedCompromise">
                            {{ $dismissedCompromise['totalLaborDismissedCompromise'] }}</td>
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
                        <td style="font-weight: bold;text-indent: 20px;">k. Criminal cases for preliminary
                            investigation
                        </td>
                        <td x-text="items.casesForPreliminaryInvestigation.totalCasePreliminaryInvestigation">
                            {{ $casesForPreliminaryInvestigation['totalCasePreliminaryInvestigation'] }}</td>
                        <td
                            x-text="items.casesForPreliminaryInvestigation.totalCriminalCasesForPreliminaryInvestigation">
                            {{ $casesForPreliminaryInvestigation['totalCriminalCasesForPreliminaryInvestigation'] }}
                        </td>
                        <td x-text="items.casesForPreliminaryInvestigation.totalCivilCasesForPreliminaryInvestigation">
                            {{ $casesForPreliminaryInvestigation['totalCivilCasesForPreliminaryInvestigation'] }}</td>
                        <td
                            x-text="items.casesForPreliminaryInvestigation.totalAdministrativeCasesForPreliminaryInvestigation">
                            {{ $casesForPreliminaryInvestigation['totalAdministrativeCasesForPreliminaryInvestigation'] }}
                        </td>
                        <td> {{ $casesForPreliminaryInvestigation['totalADM2CriminalCasesForPreliminaryInvestigation'] }}
                        </td>
                        <td x-text="items.casesForPreliminaryInvestigation.totalLaborCasesForPreliminaryInvestigation">
                            {{ $casesForPreliminaryInvestigation['totalLaborCasesForPreliminaryInvestigation'] }}
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
                        <td x-text="items.convictedAsCharged.totalConvictedAsCharged">
                            {{ $convictedAsCharged['totalConvictedAsCharged'] }}</td>
                        <td x-text="items.convictedAsCharged.totalCriminalConvictedAsCharged">
                            {{ $convictedAsCharged['totalCriminalConvictedAsCharged'] }}</td>
                        <td x-text="items.convictedAsCharged.totalCivilConvictedAsCharged">
                            {{ $convictedAsCharged['totalCivilConvictedAsCharged'] }}</td>
                        <td x-text="items.convictedAsCharged.totalAdministrativeConvictedAsCharged">
                            {{ $convictedAsCharged['totalAdministrativeConvictedAsCharged'] }}</td>
                        <td> {{ $convictedAsCharged['totalADM2ConvictedAsCharged'] }}</td>
                        <td x-text="items.convictedAsCharged.totalLaborConvictedAsCharged">
                            {{ $convictedAsCharged['totalLaborConvictedAsCharged'] }}</td>
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
                        <td x-text="items.lostCivilLabor.totalLostCivilAdministrativeLabor">
                            {{ $lostCivilLabor['totalLostCivilAdministrativeLabor'] }}</td>
                        <td x-text="items.lostCivilLabor.totalCriminalCivilAdministrativeLabor">
                            {{ $lostCivilLabor['totalCriminalCivilAdministrativeLabor'] }}</td>
                        <td x-text="items.lostCivilLabor.totalCivilCivilAdministrativeLabor">
                            {{ $lostCivilLabor['totalCivilCivilAdministrativeLabor'] }}</td>
                        <td x-text="items.lostCivilLabor.totalAdministrativeCivilAdministrativeLabor">
                            {{ $lostCivilLabor['totalAdministrativeCivilAdministrativeLabor'] }}</td>
                        <td> {{ $lostCivilLabor['totalADM2LostCivilAdministrativeLabor'] }}</td>
                        <td x-text="items.lostCivilLabor.totalLaborCivilAdministrativeLabor">
                            {{ $lostCivilLabor['totalLaborCivilAdministrativeLabor'] }}</td>
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
                        <td style="font-weight: bold;text-indent: 20px;">c. Dismissed (civil, administrative & labor)
                        </td>
                        <td x-text="items.dismissedCAL.totalDismissedCAL">{{ $dismissedCAL['totalDismissedCAL'] }}
                        </td>
                        <td x-text="items.dismissedCAL.totalCriminalCAL">{{ $dismissedCAL['totalCriminalCAL'] }}</td>
                        <td x-text="items.dismissedCAL.totalCivilCAL">{{ $dismissedCAL['totalCivilCAL'] }}</td>
                        <td x-text="items.dismissedCAL.totalAdministrativeCAL">
                            {{ $dismissedCAL['totalAdministrativeCAL'] }}</td>
                        <td>{{ $dismissedCAL['totalADM2DismissedCAL'] }}</td>
                        <td x-text="items.dismissedCAL.totalLaborCAL">{{ $dismissedCAL['totalLaborCAL'] }}</td>
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
                        <td style="font-weight: bold;text-indent: 20px;"> d. Criminal cases for preliminary
                            investigation
                        </td>
                        <td x-text="items.preliminaryInvestigation.totalPreliminaryInvestigation">
                            {{ $preliminaryInvestigation['totalPreliminaryInvestigation'] }}</td>
                        <td x-text="items.preliminaryInvestigation.totalCriminalPreliminaryInvestigation">
                            {{ $preliminaryInvestigation['totalCriminalPreliminaryInvestigation'] }}</td>
                        <td x-text="items.preliminaryInvestigation.totalCivilPreliminaryInvestigation">
                            {{ $preliminaryInvestigation['totalCivilPreliminaryInvestigation'] }}</td>
                        <td x-text="items.preliminaryInvestigation.totalAdministrativePreliminaryInvestigation">
                            {{ $preliminaryInvestigation['totalAdministrativePreliminaryInvestigation'] }}</td>
                        <td> {{ $preliminaryInvestigation['totalADM2PreliminaryInvestigation'] }}</td>
                        <td x-text="items.preliminaryInvestigation.totalLaborPreliminaryInvestigation">
                            {{ $preliminaryInvestigation['totalLaborPreliminaryInvestigation'] }}</td>
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

        <div class="date">
            <div class="signature-label">Signature Over Printed Name</div>
        </div>

        <div class="date1">
            <div class="printed-name">{{ auth()->user()->name }}</div>
            <div class="signature-label">Signature Over Printed Name</div>
        </div>
    </div>
</body>

</html>
