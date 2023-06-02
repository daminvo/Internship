<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attestation PDF</title>
    <style>
        body {
            font-family: Arial;
            /* font-family: Arial, sans-serif; */
        }

        .container {
            margin: 15px;
            position: relative;
            min-height: 100vh;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .card {
            padding: 25px;
            margin-bottom: 10px;
            margin-left: 30px;
            margin-right: 30px;
        }

        .card strong {
            font-weight: bold;
        }

        .card p {
            margin: 5px 0;
            font-size: 30px;
            line-height: 1.7;
        }

        .footer {
            text-align: right;
            font-size: 12px;
        }

        .signature {
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.4;
            margin-bottom: 10px;
        }

        .left_s {
            position: absolute;
            bottom: 35%;
            left: 12%
        }

        .right_s {
            position: absolute;
            bottom: 35%;
            right: 12%
        }

        hr {
            border: none;
            border-top: 1px solid black;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .legal-disclaimer {
            font-weight: bold;
            font-family: Arial, sans-serif;
            font-size: 16px;
            text-align: center;
        }

        .footer {
            position: absolute;
            bottom: 45%;
            right: 30%;
        }

        .bottom_hr {
            width: 100%;
            position: absolute;
            bottom: 0;

            margin-bottom: 20px;

        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <p>République Algérienne Démocratique et Populaire</p>
            <h1 style="font-size: 30px;">ATTESTATION DE STAGE</h1>
        </div>

        <div class="card">
            <p style="font-size: 18px; line-height: 1.5;">
                Je, soussigné(e) <span>{{ $firstname }} {{ $familyname }}</span> responsable de stage de
                <span>{{ $theme }}</span><br>
                atteste que l'étudiant(e) <span>{{ $fststudent }}</span> <span>{{ $fmstudent }}</span>&nbsp;
                né(e) le <span>{{ $birthday }}</span> à
                <span>{{ $birth_place }}</span> <br> inscrit(e) à l’UNIVERSITE DE CONSTANTINE 2,<br> a
                effectué un stage de formation dans la spécialité
                <span>{{ $speciality }} <br> </span> à
                <span>{{ $company_name }}</span>,
                <span>{{ $company_adresse }}</span><br> Durant la période du
                <span>{{ $start_date }}</span>
                au <span>{{ $end_date}}</span>.
            </p>
            <p></p>
        </div>

        <div class="footer">
            <p style="font-weight: bold; font-size: 16px; line-height: 1;">
                Fait à <span style="font-weight: normal;">{{ $company_adresse }}</span>.&nbsp;le
                <span style="font-weight: normal;">{{ date('Y-m-d') }}</span>
            </p>
        </div>

        <div class="signature">
            <span class="left_s" style="font-weight: bold; font-size: 16px; line-height: 1.4;  text-align: center;">
                Le Représentant de l'Universite de <br> Constantine 2 Abelhamid Mehri
            </span>
            <span class="right_s" style="font-weight: bold; font-size: 16px; line-height: 1.4;  text-align: center;">
                Le Responsable de l'établissement <br> ou de l'administration d'accueil
            </span>
        </div>

        <div class="bottom_hr">
            <hr>
            <p class="legal-disclaimer">
                Cette attestation est délivrée pour servir et faire valoir ce que de droit
            </p>
        </div>
    </div>
</body>

</html>

