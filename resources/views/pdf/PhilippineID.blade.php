<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affidavit of Loss</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 5px;
            line-height: 1.6;
            font-size: 16px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header .inline {
            display: inline-block;
        }

        .line-break {
            border-top: 1px solid black;
            width: 80%;
            margin: 10px auto;
        }

        .title {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            /* margin-top: 30px; */
            /* margin-bottom: 35px; */
            font-size: 24px;
        }

        .content {
            margin: 20px 60px;
            text-align: justify;
        }

        .statement {
            margin-left: 40px;
        }

        .signature {
            margin: 50px 60px;
            text-align: center;
        }

        .signature span {
            display: block;
            text-decoration: underline;
            margin: 10px 0;
        }

        .closing {
            margin: 20px 60px;
            text-align: justify;
            margin-top: -10px;
        }

        .notary {
            margin: 40px 60px;
            text-align: justify;
            margin-top: 10px;
        }

        .id-presented {
            text-align: center;
            margin-top: 5px;
        }

        .id-presented span {
            display: block;
            text-decoration: underline;
        }

        .inline-container p {
            display: inline;
            /* Makes the <p> elements appear on the same line */
            margin: 0;
            /* Removes default margin of <p> elements */
            padding-right: 25px;
            /* Optional: Adds space between words */
        }

        .checkbox-container {
            margin: 10px 0;
        }

        .checkbox-container label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="checkbox"] {
            margin-right: 10px;
        }

        .underline {
            text-decoration: underline;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div>
        <!-- Header Section -->
        <div style="line-height: 0.1;margin-top: 10px;margin-left: 60px;">
            <p>REPUBLIC OF THE PHILIPPINES</p>
            <div class="inline-container">
                <p>CITY</p>
                <p>OF</p>
                <p>PANABO</p>
                <p>)S.S.</p>
            </div>
            <p>X - - - - - - - - - - - - - - - - - - - - - - - -/</p>
        </div>

        <!-- Title -->
        <h2 class="title">AFFIDAVIT OF LOSS</h2>

        <!-- Content -->
        <div class="content">
            <p>
                I, <span class="underline">{{ $name }}</span>, Student /of legal age,
                single/married/widow/er, Filipino, and a resident of
                <span class="underline">{{ $address }}</span>, after being duly sworn to law do hereby depose and
                say:
            </p>
            <ol class="statement">
                <li>
                    That I am a holder of Identification card/ Philippine Identification card issued by:

                    <div class="checkbox-container">
                        <label>
                            <input type="checkbox" name="options[]" value="PhilHealth">
                            Philippine Health Insurance Corporation (PhilHealth)
                        </label>
                        <label>
                            <input type="checkbox" name="options[]" value="BIR">
                            Bureau of Internal Revenue (BIR)
                        </label>
                        <label>
                            <input type="checkbox" name="options[]" value="OSCA">
                            Office of the Senior Citizens Affairs (OSCA)
                        </label>
                        <label>
                            <input type="checkbox" name="options[]" value="SSS">
                            Social Security System (SSS)
                        </label>
                        <label>
                            <input type="checkbox" name="options[]" value="GSIS">
                            Government Services Insurance System (GSIS)
                        </label>
                        <label>
                            <input type="checkbox" name="options[]" value="PRC">
                            Professional Regulation Commission (PRC)
                        </label>
                        <label>
                            <input type="checkbox" name="options[]" value="COMELEC">
                            Commission on Election (COMELEC)
                        </label>
                        <label>
                            <input type="checkbox" name="options[]" value="PSA">
                            Philippine Statistics Authority (PSA)
                        </label>
                </li>
                <li>
                    I have lost/misplaced my said Identification card/ Philippine Identification
                    card and despite diligent search, the same remains missing to this day;
                </li>
                <li>
                    Under the circumstances my said Identification card/ Philippine Identification
                    card can no longer be found, hence, may now be considered lost for all legal
                    intents and purposes;
                </li>
                <li>
                    I am executing this affidavit to apprise all those concerned of the foregoing facts
                    and for whatever legal purpose it may serve.
                </li>
            </ol>
        </div>

        <!-- Witness Section -->
        <div class="closing">
            <p>
                <strong>IN WITNESS WHEREOF</strong>, I have hereunto set my hand this <span
                    class="underline">{{ $formattedDate }}</span>
                at Panabo City, Davao del Norte, Philippines.
            </p>
        </div>

        <!-- Signature Section -->
        <div class="signature">
            <span>{{ $name }}</span>
            Affiant
        </div>

        <!-- ID Presented Section -->
        <div class="id-presented">
            <span>{{ $idType }} - {{ $id_number }}</span>
            I.D. PRESENTED
        </div>

        <!-- Notary Section -->
        <div class="notary">
            <p>
                <strong>SUBSCRIBED and SWORN</strong>, I have hereunto set my hand this <span
                    class="underline">{{ $formattedDate }}</span>
                at Panabo City, Davao del Norte, Philippines.
            </p>
        </div>
    </div>
</body>

</html>
