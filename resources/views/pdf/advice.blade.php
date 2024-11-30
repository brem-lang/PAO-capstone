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
            <span>Rehiyon : ______________________________</span><br>
            <span>District Office :
                ______________________________</span>
        </div>

        <div style="margin-top:-5px;">
            <div class="row">
                <div class="column">
                    <div>
                        <span>Petsa :______________________________</span>
                    </div>
                    <div>
                        <span>Control No :______________________________</span>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div>
                        <span class="underline-container">
                            <span class="text-above">Mananayam :___________________________</span>
                            <span class="text-below"> (Pangalan at Lagda) Public Attorney </span>
                        </span>
                    </div>
                    <br>
                    <br>
                    <div>
                        <span>Ini-refer ni/Inindorso ni :______________________________</span>
                    </div>
                </div>
                <div class="column">
                    <span>Ginawang Aksyon :</span><br>
                    <div style="display: inline-block; vertical-align: middle;">
                        <div style="display: inline-block; vertical-align: middle;">
                            <input type="checkbox" name="option1" value="Option 1">
                        </div>
                        <div style="display: inline-block; vertical-align: middle;">
                            Higit pang pag-aaralan (merit at indigency test)
                        </div>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <div style="display: inline-block; vertical-align: middle;">
                            <input type="checkbox" name="option1" value="Option 1">
                        </div>
                        <div style="display: inline-block; vertical-align: middle;">
                            Para sa representasyon at iba pang tulong-legal
                        </div>
                    </div>
                    <div>
                        <span>Ini-atas kay : ______________________________</span>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <div style="display: inline-block; vertical-align: middle;">
                            <input type="checkbox" name="option1" value="Option 1">
                        </div>
                        <div style="display: inline-block; vertical-align: middle;">
                            Ibinigay na serbisyong-legal: ___________________
                        </div>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <div style="display: inline-block; vertical-align: middle;">
                            <input type="checkbox" name="option1" value="Option 1">
                        </div>
                        <div style="display: inline-block; vertical-align: middle;">
                            Iba pa: _____________________________________
                        </div>
                    </div>
                    <div>
                        <span class="underline-container">
                            <span class="text-above">APROBADO ang AKSYON ni :___________________________</span>
                            <span class="text-below">Pangalan at Lagda ng DPA / OIC-DPA </span>
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
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Legal Documentation
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Inquest/Legal Assistance
                </div>
            </div>
        </div>
        <div class="column1">
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Administration of oath
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Mediation/Conciliation
                </div>
            </div>
        </div>
        <div class="column1">
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
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
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Iba pa:
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
                        <span>Pangalan : _______________</span>
                    </div>
                    <div>
                        <span>Relihiyon : _______________________________ </span>
                    </div>
                    <div>
                        <span>Pagkamamamayan : ______________ </span>
                    </div>
                    <div>
                        <span>Tirahan : _______________________</span>
                    </div>
                    <div>
                        <span>E-mail : _________________________</span>
                    </div>
                    <div>
                        <span>Individual Monthly Income: ________________</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div>
                            <span>Nakakulong :</span>
                            <div style="display: inline-block; vertical-align: middle;margin-top: 5px;">
                                <div style="display: inline-block; vertical-align: middle;">
                                    <input type="checkbox" name="option1" value="Option 1">
                                </div>
                                <div style="display: inline-block; vertical-align: middle;">
                                    Yes
                                </div>
                            </div>
                            <div style="display: inline-block; vertical-align: middle;margin-top: 5px">
                                <div style="display: inline-block; vertical-align: middle;">
                                    <input type="checkbox" name="option1" value="Option 1">
                                </div>
                                <div style="display: inline-block; vertical-align: middle;">
                                    No
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <span>Petsa ng pagakakulong : _____________________</span>
                    </div>
                </div>
                <div class="column">
                    <div> <span>Edad: ______ Sex: ________ Civil Status: ______</span></div>
                    <div><span>Naabot na pag-aaral : _________________________</span></div>
                    <div> <span>Salita/Dialekto : __________________________</span></div>
                    <div><span>Contact No. : ___________________________</span></div>
                    <div> <span>Asawa : _____________________________________________</span></div>
                    <div><span>Tirahan ng Asawa : ____________________________________</span></div>
                    <div> <span>Contact No. ng Asawa: _________________________________</span></div>
                    <div><span>Lugar ng Detention: ____________________________________</span></div>
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
                        <span>Pangalan : _______________</span>
                    </div>
                    <div>
                        <span>Tirahan : _______________________________ </span>
                    </div>
                    <div>
                        <span>Relasyon sa aplikante : ______________ </span>
                    </div>
                </div>
                <div class="column">
                    <div> <span>Edad: ______ Sex: ________ Civil Status: ______</span></div>
                    <div><span>Contact No. : ___________________________</span></div>
                    <div> <span>Email : _____________________________________________</span></div>
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
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Criminal
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Administrative
                </div>
            </div>
        </div>
        <div class="column1">
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Civil
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Appeal
                </div>
            </div>
        </div>
        <div class="column1">
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
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
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Child in Conflict with the Law
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Woman
                </div>
            </div>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    VAWC Victim
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Law Enforcer
                </div>
            </div>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Drug-related duty
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    OFW - Land-based
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    OFW - Sea-based
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
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
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Senior Citizen
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Refugee/Evacuee
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Tenant ng Agrarian Case
                </div>
            </div><br>

            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Arrested for Terrorism (R.A.No.11479)
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Victim of Torture (R.A. No. 9745)
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Victim of Trafficking (R.A. No. 9208)
                </div>
            </div><br>
        </div>
        <div class="column1">
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Foreign National : _____
                </div>
            </div><br>

            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Urban Poor : _____
                </div>
            </div><br>

            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Rural Poor : _____
                </div>
            </div><br>

            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Indigenous People : _____
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    PWD; Type of Disability : _____
                </div>
            </div><br>
            <div style="display: inline-block; vertical-align: middle;">
                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" name="option1" value="Option 1">
                </div>
                <div style="display: inline-block; vertical-align: middle;">
                    Petitioner for Voluntary Rehabilitation
                </div>
                (Drugs) : _____
            </div><br>
        </div>
    </div>

    <div style="text-align: center; background-color: rgb(83, 81, 81); color: white;padding: 5px;margin-top:-12px;">
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
                I, PATRICK BARCELO of legal age, SINGLE - MARRIED: MARRIED TO
                and residing at DEGUZMAN STREET TORIL DAVAO CITY and having been duly sworn in
                accordance with law, depose and say:
            </p>

            <ol class="statement1" style="font-size: 13px;margin-top: -10px;">
                <li>
                    That I desire to avail of the free legal service of the Public Attorney’s Office;
                </li>
                <li>
                    That my net monthly salary/income is P_________________; and
                </li>
                <li>
                    That I am executing this affidavit to entitle me to the desired legal services.
                </li>
            </ol>
        </div>

        <!-- Witness Section -->
        <div class="closing" style="margin-top: -40px;">
            <p style="font-size: 13px;">
                <strong>IN WITNESS WHEREOF</strong>, I have hereunto set my hand this <span class="underline">NOVEMBER
                    16 2023</span>
                at Panabo City, Davao del Norte, Philippines.
            </p>
        </div>

        <!-- Signature Section -->
        <div class="signature" style="font-size: 13px;margin-top: -15px;">
            <span>PATRICK BARCELO</span>
            Affiant
        </div>

        <!-- Notary Section -->
        <div class="notary" style="margin-top: -10px;">
            <p style="font-size: 13px;">
                <strong>SUBSCRIBED and SWORN</strong>, I have hereunto set my hand this <span
                    class="underline">NOVEMBER 16 2023</span>
                at Panabo City, Davao del Norte, Philippines.
            </p>
        </div>
    </div>
</body>

</html>
