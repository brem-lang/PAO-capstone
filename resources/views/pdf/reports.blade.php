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
            margin-bottom: 5px;
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
            </div>
        </div>
        <div class="date">
            <span style="font-size: 10px;">Date: test = test </span><br>
            <span style="font-size: 10px;">Exported Date: {{ now()->timezone('Asia/Manila')->format('F j, Y') }}</span>
        </div>
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
                        <td>{{ $casePending[0]['totalPending'] }}</td>
                        <td>{{ $casePending[0]['crPending'] }}</td>
                        <td>{{ $casePending[0]['cvPending'] }}</td>
                        <td>{{ $casePending[0]['adPending'] }}</td>
                        <td></td>
                        <td>{{ $casePending[0]['adm3Pending'] }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;"> 2. New Cases Received</td>
                        <td>{{ $caseReceived[0]['totalNewReceived'] }}</td>
                        <td>{{ $caseReceived[0]['totalCriminalReceived'] }}</td>
                        <td>{{ $caseReceived[0]['totalCivilReceived'] }}</td>
                        <td>{{ $caseReceived[0]['totalAdministrativeReceived'] }}</td>
                        <td></td>
                        <td>{{ $caseReceived[0]['totalLaborReceived'] }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 20px;">2.1. No. of clients involved</td>
                        <td>{{ $caseReceived2One[0]['totalNewReceived2One'] }}</td>
                        <td>{{ $caseReceived2One[0]['totalCriminalReceived2One'] }}</td>
                        <td>{{ $caseReceived2One[0]['totalCivilReceived2One'] }}</td>
                        <td>{{ $caseReceived2One[0]['totalAdministrativeReceived2One'] }}</td>
                        <td></td>
                        <td>{{ $caseReceived2One[0]['totalLaborReceived2One'] }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;"> 3. Cases received from another PAO lawyer</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;"> 4. Cases transferred to another PAO lawyer</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;"> 5. Total Cases Handled (Item 1+2+3-4)</td>
                        <td>{{ $CaseHandled[0]['totalCaseHandled'] }}</td>
                        <td>{{ $CaseHandled[0]['totalCriminalCaseHandled'] }}</td>
                        <td>{{ $CaseHandled[0]['totalCivilCaseHandled'] }}</td>
                        <td>{{ $CaseHandled[0]['totalAdministrativeCaseHandled'] }}</td>
                        <td></td>
                        <td>{{ $CaseHandled[0]['totalLaborCaseHandled'] }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;"> 6. Total Terminated Cases/Disposition (Old + New)</td>
                        <td>{{ $terminated[0]['totalTerminated'] }}</td>
                        <td>{{ $terminated[0]['totalCriminalTerminated'] }}</td>
                        <td>{{ $terminated[0]['totalCivilTerminated'] }}</td>
                        <td>{{ $terminated[0]['totalAdministrativeTerminated'] }}</td>
                        <td></td>
                        <td>{{ $terminated[0]['totalLaborTerminated'] }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 20px;"> a. Old Cases</td>
                        <td>{{ $terminatedA[0]['totalTerminatedA'] }}</td>
                        <td>{{ $terminatedA[0]['totalCriminalTerminatedA'] }}</td>
                        <td>{{ $terminatedA[0]['totalCivilTerminatedA'] }}</td>
                        <td>{{ $terminatedA[0]['totalAdministrativeTerminatedA'] }}</td>
                        <td></td>
                        <td>{{ $terminatedA[0]['totalLaborTerminatedA'] }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 20px;"> b. New Cases</td>
                        <td>{{ $terminatedB[0]['totalTerminatedB'] }}</td>
                        <td>{{ $terminatedB[0]['totalCriminalTerminatedB'] }}</td>
                        <td>{{ $terminatedB[0]['totalCivilTerminatedB'] }}</td>
                        <td>{{ $terminatedB[0]['totalAdministrativeTerminatedB'] }}</td>
                        <td></td>
                        <td>{{ $terminatedB[0]['totalLaborTerminatedB'] }}</td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;text-indent: 20px;"> a. Acquitted </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;"> a.1. No. of clients involved</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;text-indent: 20px;"> b. Dismissed with prejudice</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;"> b.1. No. of clients involved</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;text-indent: 20px;"> c. Motion to quash granted</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;"> c.1. No. of clients involved</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;text-indent: 20px;"> d. Demurrer to evidence granted</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;"> d.1. No. of clients involved</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;text-indent: 20px;"> e. Provisionally dismissed</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;"> e.1. No. of clients involved</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;text-indent: 20px;"> f. Convicted to lesser offense</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;"> f.1. No. of clients involved</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;text-indent: 20px;"> g. Probation granted</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;"> g.1. No. of clients involved</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;text-indent: 20px;"> h. Won (civil, labor, and administrative)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;"> h.1. No. of clients involved</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;text-indent: 20px;"> i. Granted lesser award (civil, administrative
                            &
                            labor)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;"> i.1. No. of clients involved</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;text-indent: 20px;"> j. Dismissed cases based on compromise
                            agreement
                            (civil & labor)
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;"> j.1. No. of clients involved</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;text-indent: 20px;">k. Criminal cases for preliminary investigation
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;font-weight: bold;"> k.1. Case filed in court (complainant) </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 60px;">k.1.1. No. of clients involved</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;font-weight: bold;">k.2. Dismissed (respondent)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 60px;">k.2.1. No. of clients involved </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;text-indent: 20px;">l. Pre-trial releases and other dispositions
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;font-weight: bold;">l.1. Bail (Non-bailable offense)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 60px;">l.1.1. No. of clients involved</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;font-weight: bold;">l.2. Recognizance</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 60px;">l.2.1. No. of clients involved</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;font-weight: bold;">l.3. Diversion proceedings / Intervention</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 60px;"> l.3.1. No. of clients involved </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;font-weight: bold;">l.4. Suspended sentence</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 60px;"> l.4.1. No. of clients involved</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;font-weight: bold;">l.5. Maximum imposable penalty served</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 60px;"> l.5.1. No. of clients involved</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;">II. Unfavorable Dispositions to Clients </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;text-indent: 20px;"> a. Convicted as charged </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;">a.1. No. of clients involved</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;text-indent: 20px;">b. Lost (civil, administrative & labor)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;">b.1. No. of clients involved</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;text-indent: 20px;">c. Dismissed (civil, administrative & labor)
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;">c.1. No. of clients involved </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;text-indent: 20px;"> d. Criminal cases for preliminary
                            investigation
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;font-weight: bold;">d.1. Dismissed (complainant) </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 60px;"> d.1.1. No. of clients involved </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 40px;font-weight: bold;">d.2. Cases filed in court (respondent) </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-indent: 60px;">d.2.1. No. of clients involved </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
