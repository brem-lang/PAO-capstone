<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advice</title>
    <style>
        body {
            border: 1px solid #333;
            /* Solid black border */
            margin: -15px;
            /* Adds space between the border and browser edge */
            /* padding: 10px; */
            /* Adds space inside the border */
            box-sizing: border-box;
            /* Ensures padding is included within the border */
        }

        /* Create two equal columns that floats next to each other */
        .column {
            float: left;
            width: 50%;
            padding: 10px;
            height: 300px;
            /* Should be removed. Only for demonstration */
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .underline-container {
            display: inline-block;
            text-align: center;
            position: relative;
        }

        .underline-container .text-above {
            /* text-decoration: underline; */
        }

        .underline-container .text-below {
            position: absolute;
            top: 20px;
            /* Adjust spacing between underline and text below */
            left: 0;
            width: 100%;
            font-size: 8px;
            /* Adjust the size of the text below */
        }

        /* Create three equal columns that floats next to each other */
        .column1 {
            float: left;
            width: 30.7%;
            padding: 10px;
            font-size: 13px;
        }

        /* Clear floats after the columns */
        .row1:after {
            content: "";
            display: table;
            clear: both;
            /* margin-left: -10px; */
        }

        .inline-container p {
            display: inline;
            /* Makes the <p> elements appear on the same line */
            margin: 0;
            /* Removes default margin of <p> elements */
            padding-right: 25px;
            /* Optional: Adds space between words */
        }

        .content1 {
            /* margin: 20px 60px; */
            padding: 10px;
            text-align: justify;
        }

        .statement1 {
            margin-left: 40px;
        }

        .signature {
            /* margin: 50px 60px; */
            text-align: center;
        }

        .signature span {
            display: block;
            text-decoration: underline;
            margin: 10px 0;
        }

        .closing {
            /* margin: 20px 60px; */
            padding: 10px;
            text-align: justify;
        }

        .notary {
            /* margin: 40px 60px; */
            padding: 10px;
            text-align: justify;
        }

        .underline {
            font-size: 10px;
            text-decoration: underline;
            font-weight: bold;
        }
    </style>

<body>
    <div style="text-align: center;margin-top: 1px">
        <span style="font-size: 17px;font-weight:bold;">INTERVIEW SHEET (Para sa Serbisyong-Legal at/o
            Representasyon)</span>
    </div>
    <div style="margin-top: 3px;text-align: center;">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(asset('images/appointment.jpg'))) }}"
            alt="Logo" height="auto" width="752px">
    </div>

    <div style="padding: 10px;margin-top: -10px;font-size: 13px;">
        <div style="text-align: center;">
            <span>Rehiyon: <span class="underline">{{ $region }}</span></span><br>
            <span>District Office: <span class="underline">{{ $district_office }}</span></span>
        </div>

        <div style="margin-top:-5px;">
            <div class="row">
                <div class="column">
                    <div>
                        <span>Petsa: <span class="underline">{{ $date ?? '____________________' }}</span></span>
                    </div>
                    <div>
                        <span>Control No: <span
                                class="underline">{{ $control_no ?? '____________________' }}</span></span>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div>
                        <span class="underline-container">
                            <span class="text-above">Mananayam: <span
                                    class="underline">{{ $mananayam ?? '____________________' }}</span></span>
                            <span class="text-below" style="margin-left:40px;"> (Pangalan at Lagda) Public Attorney
                            </span>
                        </span>
                    </div>
                    <br>
                    <br>
                    <div>
                        <span>Ini-refer ni/Inindorso ni: <span
                                class="underline">{{ $referredBy ?? '____________________' }}</span></span>
                    </div>
                </div>
                <div class="column">
                    <span>Ginawang Aksyon :</span><br>
                    <div style="display: inline-block; vertical-align: middle;">
                        <div style="display: inline-block; vertical-align: middle;">
                            <input type="checkbox" {{ $merit ? 'checked' : '' }}>
                        </div>
                        <div style="display: inline-block; vertical-align: middle;">
                            Higit pang pag-aaralan (merit at indigency test)
                        </div>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <div style="display: inline-block; vertical-align: middle;">
                            <input type="checkbox" {{ $rep ? 'checked' : '' }}>
                        </div>
                        <div style="display: inline-block; vertical-align: middle;">
                            Para sa representasyon at iba pang tulong-legal
                        </div>
                    </div>
                    <div>
                        <span>Ini-atas kay: <span
                                class="underline">{{ $assignTo ?? '____________________' }}</span></span>
                    </div>
                    <di></di>
                    <div style="display: inline-block; vertical-align: middle;">
                        <div style="display: inline-block; vertical-align: middle;">
                            <input type="checkbox" {{ $isServiceCheck ? 'checked' : '' }}>
                        </div>
                        <div style="display: inline-block; vertical-align: middle;">
                            Ibinigay na serbisyong-legal: <span
                                class="underline">{{ $isServiceInput ?? '____________________' }}</span>
                        </div>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <div style="display: inline-block; vertical-align: middle;">
                            <input type="checkbox" {{ $isOthersCheck ? 'checked' : '' }}>
                        </div>
                        <div style="display: inline-block; vertical-align: middle;">
                            Iba pa: <span class="underline">{{ $isOthersInput ?? '____________________' }}</span>
                        </div>
                    </div>
                    <div>
                        <span class="underline-container">
                            <span class="text-above">APROBADO ang AKSYON ni: <span
                                    class="underline">________________________</span></span>
                            <span class="text-below" style="margin-left: 80px;">Pangalan at Lagda ng DPA / OIC-DPA
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="text-align: center; margin-top: -165px; background-color: rgb(83, 81, 81); color: white;padding: 5px;">
        <span style="font-size: 14px; font-weight: bold;">I. URI NG INIHIHINGI NG TULONG</span>
        <span style="font-size: 14px;">(Para sa kawani ng PAO)</span>
    </div>

    <div class="row1">
        <div class="column1">
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $legalDoc ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Legal Documentation
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $inquest ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Inquest/Legal Assistance
                </div>
            </div>
        </div>
        <div class="column1">
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $adminOath ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Administration of oath
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $mediation ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Mediation/Conciliation
                </div>
            </div>
        </div>
        <div class="column1">
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $courtRep ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Representasyon sa Korte o ibang
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Tanggapan
                </div>
            </div>
            <br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $isOthers2Check ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Iba pa: <span class="underline">{{ $isOthers2Input ?? '____________________' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div style="text-align: center; background-color: rgb(83, 81, 81); color: white;padding: 5px;margin-top:-12px;">
        <span style="font-size: 14px; font-weight: bold;">II. IMPORMASYON UKOL SA APLIKANTE </span><br>
        <span style="font-size: 14px;">(Para sa aplikante/representative. Gumamit ng panibago kung higit sa isa sa
            aplikante/kliyente)</span>
    </div>

    <div style="padding: 10px;margin-top: -10px;font-size: 13px;">
        <div style="margin-top:-2px;">
            <div class="row">
                <div class="column">
                    <div>
                        <span>Pangalan: <span class="underline">{{ $name ?? '____________________' }}</span></span>
                    </div>
                    <div>
                        <span>Relihiyon: <span
                                class="underline">{{ $religion ?? '____________________' }}</span></span>
                    </div>
                    <div>
                        <span>Pagkamamamayan: <span
                                class="underline">{{ $citizenship ?? '____________________' }}</span></span>
                    </div>
                    <div>
                        <span>Tirahan: <span
                                class="underline">{{ $barangay ? $barangay . '-' . $city : '_______________________' }}</span></span>
                    </div>
                    <div>
                        <span>E-mail: <span class="underline">{{ $email ?? '____________________' }}</span></span>
                    </div>
                    <div>
                        <span>Individual Monthly Income: <span
                                class="underline">{{ $income ?? '____________________' }}</span></span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div>
                            <span>Nakakulong :</span>
                            <div style="display: inline-block; vertical-align: middle;margin-top: 5px;">
                                <div style="display: inline-block; vertical-align: middle;">
                                    <input type="checkbox" {{ $nakakulong ? 'checked' : '' }}>
                                </div>
                                <div style="display: inline-block; vertical-align: middle;">
                                    Yes
                                </div>
                            </div>
                            <div style="display: inline-block; vertical-align: middle;margin-top: 5px">
                                <div style="display: inline-block; vertical-align: middle;">
                                    <input type="checkbox" {{ $nakakulong ? '' : 'checked' }}>
                                </div>
                                <div style="display: inline-block; vertical-align: middle;">
                                    No
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <span>Petsa ng pagakakulong: <span
                                class="underline">{{ $dateofKulong ?? '____________________' }}</span></span>
                    </div>
                </div>
                <div class="column">
                    <div> <span>Edad: <span class="underline">{{ $age ?? '_______' }}</span> Sex: <span
                                class="underline">{{ $sex ?? '_______' }}</span>
                            Civil Status: <span class="underline">{{ $civilStatus ?? '_______' }}</span></span></div>
                    <div><span>Naabot na pag-aaral: <span
                                class="underline">{{ $degree ?? '____________________' }}</span></div>
                    <div> <span>Salita/Dialekto: <span
                                class="underline">{{ $language ?? '____________________' }}</span></span></div>
                    <div><span>Contact No.: <span
                                class="underline">{{ $contact_number ?? '____________________' }}</span></span></div>
                    <div> <span>Asawa: <span class="underline">{{ $asawa ?? '____________________' }}</span></span>
                    </div>
                    <div><span>Tirahan ng Asawa: <span
                                class="underline">{{ $asawaAddress ?? '____________________' }}</span></span></div>
                    <div> <span>Contact No. ng Asawa: <span
                                class="underline">{{ $contactNumberAsawa ?? '____________________' }}</span></span>
                    </div>
                    <div><span>Lugar ng Detention: <span
                                class="underline">{{ $dPlace ?? '____________________' }}</span></span></div>
                </div>
            </div>
        </div>
    </div>

    <div style="text-align: center; background-color: rgb(83, 81, 81); color: white;padding: 5px;margin-top:-180px;">
        <span style="font-size: 14px; font-weight: bold;">II. A. IMPORMASYON UKOL SA REPRESENTATIVE </span>
        <span style="font-size: 14px;">(Pupunan kung wala ang aplikante)</span>
    </div>

    <div style="padding: 10px;margin-top: -15px;font-size: 13px;">
        <div style="margin-top:-2px;">
            <div class="row">
                <div class="column">
                    <div>
                        <span>Pangalan: <span
                                class="underline">{{ $representativeName ?? '____________________' }}</span></span>
                    </div>
                    <div>
                        <span>Tirahan: <span
                                class="underline">{{ $representativeTirahan ?? '____________________' }}</span></span>
                    </div>
                    <div>
                        <span>Relasyon sa aplikante: <span
                                class="underline">{{ $representativeRelationship ?? '____________________' }}</span></span>
                    </div>
                </div>
                <div class="column">
                    <div> <span>Edad: <span class="underline">{{ $representativeAge ?? '_______' }}</span> Sex: <span
                                class="underline">{{ $representativeSex ?? '_______' }}</span> Civil Status: <span
                                class="underline">{{ $representativeCivilStatus ?? '_______' }}</span></span></div>
                    <div><span>Contact No.: <span
                                class="underline">{{ $representativeContactNumber ?? '____________________' }}</span></span>
                    </div>
                    <div> <span>Email: <span
                                class="underline">{{ $representativeEmail ?? '____________________' }}</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="text-align: center; background-color: rgb(83, 81, 81); color: white;padding: 5px;margin-top:-271px;">
        <span style="font-size: 14px; font-weight: bold;">III. URI NG KASO</span>
    </div>

    <div class="row1" style="margin-top: -5px;">
        <div class="column1">
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $type_of_case == 'criminal' ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Criminal
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $type_of_case == 'administrative' ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Administrative
                </div>
            </div>
        </div>
        <div class="column1">
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $type_of_case == 'civil' ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Civil
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $type_of_case == 'appealed' ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Appeal
                </div>
            </div>
        </div>
        <div class="column1">
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $type_of_case == 'labor' ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Labor
                </div>
            </div>
        </div>
    </div>

    <div style="text-align: center; background-color: rgb(83, 81, 81); color: white;padding: 5px;margin-top:-12px;">
        <span style="font-size: 14px; font-weight: bold;">IV. SEKTOR NA KABILANG ANG APLIKANTE </span>
    </div>

    <div class="row1" style="margin-top: -6px;">
        <div class="column1">
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $child_in_conflict ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Child in Conflict with the Law
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $woman ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Woman
                </div>
            </div>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $victim_of_VAWC ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    VAWC Victim
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $law_enforcer ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Law Enforcer
                </div>
            </div>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $drug_related_duty ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Drug-related duty
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $ofw_land_based ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    OFW - Land-based
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $ofw_sea_based ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    OFW - Sea-based
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $former_rebel ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Former Rebel (FR) and Former
                </div>
                Violent Extremist (FVE)
            </div><br>
        </div>
        <div class="column1">
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $senior_citizen ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Senior Citizen
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $drug_refugee ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Refugee/Evacuee
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $tenant_of_agrarian_case ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Tenant ng Agrarian Case
                </div>
            </div><br>

            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $arrested_for_terrorism ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Arrested for Terrorism(R.A.No.11479)
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $victim_of_torture ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Victim of Torture (R.A. No. 9745)
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $victim_of_trafficking ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Victim of Trafficking (R.A. No. 9208)
                </div>
            </div><br>
        </div>
        <div class="column1">
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $foreign_national ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Foreign National:
                    <span class="underline">
                        {{ $foreign_national_input ?? '_________________' }}
                    </span>
                </div>
            </div><br>

            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $urban_poor ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Urban Poor:
                    <span class="underline">
                        {{ $urban_poor_input ?? '_________________' }}
                    </span>
                </div>
            </div><br>

            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" {{ $rural_poor ? 'checked' : '' }}>
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Rural Poor:
                    <span class="underline">
                        {{ $rural_poor_input ?? '_________________' }}
                    </span>
                </div><br>

                <div style="display: inline-block; vertical-align: middle;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" {{ $indigenous_people ? 'checked' : '' }}>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        Indigenous People:
                        <span class="underline">
                            {{ $indigenous_people_input ?? '_________________' }}
                        </span>
                    </div>
                </div><br>
                <div style="display: inline-block; vertical-align: middle;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" {{ $pwd_type ? 'checked' : '' }}>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        PWD;Type of
                    </div><br>
                    Disability:
                    <span class="underline">
                        {{ $pwd_type_input ?? '_________________' }}
                    </span>
                </div><br>
                <div style="display: inline-block; vertical-align: middle;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" {{ $petitioner_drugs ? 'checked' : '' }}>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        Petitioner for Voluntary Rehabilitation
                    </div>
                    (Drugs):
                    <span class="underline">
                        {{ $petitioner_drugs_input ?? '_________________' }}
                    </span>
                </div><br>
            </div>
        </div>


        <div
            style="text-align: center; background-color: rgb(83, 81, 81); color: white;padding: 5px;margin-top:185px;">
            <span style="font-size: 14px; font-weight: bold;">V. AFFIDAVIT OF INDIGENCY</span>
        </div>

        <div>
            <div style="line-height: 0.1;margin-left:7px;margin-top:7px;font-size: 13px;">
                <p>REPUBLIC OF THE PHILIPPINES</p>
                <div class="inline-container">
                    <p>CITY</p>
                    <p>OF</p>
                    <p>PANABO</p>
                    <p>)S.S.</p>
                </div>
                <p>X - - - - - - - - - - - - - - - - - - - - - - - -/</p>
            </div>

            <div style="text-align: center;margin-top: -18px;">
                <span>AFFIDAVIT OF INDIGENCY</span>
            </div>
            <div class="content1" style="margin-top: -20px;">
                <p style="font-size: 13px;">
                    I, <span class="underline">{{ $name }}</span>, <span
                        class="underline">{{ ucfirst($civilStatus) }}</span>
                    of <span class="underline">{{ $age }}</span> yrs old,
                    <span class="underline">{{ $civilStatus }}</span>, Filipino, and a resident of
                    <span class="underline">{{ $barangay . '-' . $city }}</span>, after being duly sworn to law do
                    hereby depose and say:
                </p>

                <ol class="statement1" style="font-size: 13px;margin-top: -10px;">
                    <li>
                        That I desire to avail of the free legal service of the Public Attorney’s Office;
                    </li>
                    <li>
                        That my net monthly salary/income is P <span class="underline">{{ $income }}.00</span>;
                        and
                    </li>
                    <li>
                        That I am executing this affidavit to entitle me to the desired legal services.
                    </li>
                </ol>
            </div>
            @php
                $formattedDate = \Carbon\Carbon::now()->format('jS \\d\\a\\y \\o\\f F Y');
                // $formattedDate = \Carbon\Carbon::parse($date)->format('jS \\d\\a\\y \\o\\f F Y');
            @endphp

            <!-- Witness Section -->
            <div class="closing" style="margin-top: -40px;">
                <p style="font-size: 13px;">
                    <strong>IN WITNESS WHEREOF</strong>, I have hereunto set my hand this <span
                        class="underline">{{ $formattedDate }}</span>
                    at Panabo City, Davao del Norte, Philippines.
                </p>
            </div>

            <!-- Signature Section -->
            <div class="signature" style="font-size: 13px;margin-top: -20px;">
                <span>{{ $name }}</span>
                Affiant
            </div>

            <!-- Notary Section -->
            <div class="notary" style="margin-top: -16px;">
                <p style="font-size: 13px;">
                    <strong>SUBSCRIBED and SWORN</strong>, I have hereunto set my hand this <span
                        class="underline">{{ $formattedDate }}</span>
                    at Panabo City, Davao del Norte, Philippines.
                </p>
            </div>
        </div>
</body>

</html>
