<?php

// Calculate yesterday's date in the format YYYYMMDD

$yesterday = date('Ymd', strtotime('-1 day'));

 

// Database Connection

$servername = "";

$username = "";

$password = "";

$dbname = "";

 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}

 

// Query for the first box (Box 2)

$sqlBox6 = "SELECT COUNT(*) AS total_count FROM edi508 WHERE f508Name LIKE '%$yesterday%' AND MSGCODCIE = '9009' AND MSGTXTRET LIKE '%INTEG%' GROUP BY MSGREFSIN";

$resultBox6 = $conn->query($sqlBox6);

$rowBox6 = $resultBox6->fetch_assoc();

$totalCountBox6 = ($rowBox6) ? $rowBox6['total_count'] : 0;

 

// Query for the second box (Box 8)

$sqlBox12 = "SELECT COUNT(*) AS total_count FROM edi506 WHERE f506Name LIKE '%$yesterday%' AND MSGCODCIE = '9009' AND MSGTXTRET LIKE '%INTEG%' GROUP BY MSGREFSIN";

$resultBox12 = $conn->query($sqlBox12);

$rowBox12 = $resultBox12->fetch_assoc();

$totalCountBox12 = ($rowBox12) ? $rowBox12['total_count'] : 0;

 

// Query for New Box 5

$sqlBox5 = "SELECT COUNT(MSGREFSIN) AS total_count FROM edi508 WHERE MSGTXTRET LIKE '%COMPAGNIE GTA SANS CONVENTION IDA%' AND f508Name LIKE '%$yesterday%'";

$resultBox5 = $conn->query($sqlBox5);

$rowBox5 = $resultBox5->fetch_assoc();

$totalCountBox5 = ($rowBox5) ? $rowBox5['total_count'] : 0;

 

// Query for EXISTE PAS

$sqlExistPas = "SELECT COUNT(MSGREFSIN) AS exist_pas_count FROM edi508 WHERE MSGTXTRET LIKE '%EXISTE PAS%' AND f508Name LIKE '%$yesterday%'";

$resultExistPas = $conn->query($sqlExistPas);

$rowExistPas = $resultExistPas->fetch_assoc();

$existPasCount = ($rowExistPas) ? $rowExistPas['exist_pas_count'] : 0;

 

// Query for DEJA

$sqlDeja = "SELECT COUNT(MSGREFSIN) AS deja_count FROM edi508 WHERE MSGTXTRET LIKE '%DEJA%' AND f508Name LIKE '%$yesterday%'";

$resultDeja = $conn->query($sqlDeja);

$rowDeja = $resultDeja->fetch_assoc();

$dejaCount = ($rowDeja) ? $rowDeja['deja_count'] : 0;

 

// Query for LE NUMERO DE SINISTRE N'EST PAS DANS LA PLAGE ATTRIBUE

$sqlNumSinistre = "SELECT COUNT(MSGREFSIN) AS num_sinistre_count FROM edi508 WHERE MSGTXTRET LIKE '%LE NUMERO DE SINISTRE NEST PAS DANS LA PLAGE ATTRIBUE%' AND f508Name LIKE '%$yesterday%'";

$resultNumSinistre = $conn->query($sqlNumSinistre);

$rowNumSinistre = $resultNumSinistre->fetch_assoc();

$numSinistreCount = ($rowNumSinistre) ? $rowNumSinistre['num_sinistre_count'] : 0;

 

// Query for LE COURTIER N'EST PAS HABILITE

$sqlCourtier = "SELECT COUNT(MSGREFSIN) AS courtier_count FROM edi508 WHERE MSGTXTRET LIKE '%LE COURTIER NEST PAS HABILITE%' AND f508Name LIKE '%$yesterday%'";

$resultCourtier = $conn->query($sqlCourtier);

$rowCourtier = $resultCourtier->fetch_assoc();

$courtierCount = ($rowCourtier) ? $rowCourtier['courtier_count'] : 0;

 

// Query for SINISTRE HORS PERIMETRE EDI

$sqlSinistre = "SELECT COUNT(MSGREFSIN) AS sinistre_count FROM edi508 WHERE MSGTXTRET LIKE '%SINISTRE HORS PERIMETRE EDI%' AND f508Name LIKE '%$yesterday%'";

$resultSinistre = $conn->query($sqlSinistre);

$rowSinistre = $resultSinistre->fetch_assoc();

$sinistreCount = ($rowSinistre) ? $rowSinistre['sinistre_count'] : 0;

 

// Query for EXISTE PAS in edi506

$sqlExistPas506 = "SELECT COUNT(MSGREFSIN) AS exist_pas_count FROM edi506 WHERE MSGTXTRET LIKE '%EXISTE PAS%' AND f506Name LIKE '%$yesterday%'";

$resultExistPas506 = $conn->query($sqlExistPas506);

$rowExistPas506 = $resultExistPas506->fetch_assoc();

$existPasCount506 = ($rowExistPas506) ? $rowExistPas506['exist_pas_count'] : 0;

 

// Query for CODE SITUATION in edi506

$sqlCodeSituation506 = "SELECT COUNT(MSGREFSIN) AS code_situation_count FROM edi506 WHERE MSGTXTRET LIKE '%CODE SITUATION%' AND f506Name LIKE '%$yesterday%'";

$resultCodeSituation506 = $conn->query($sqlCodeSituation506);

$rowCodeSituation506 = $resultCodeSituation506->fetch_assoc();

$codeSituationCount506 = ($rowCodeSituation506) ? $rowCodeSituation506['code_situation_count'] : 0;

 

// Query for NUMERO DE POLICE NON TROUVE in edi506

$sqlNumeroPolice = "SELECT COUNT(MSGREFSIN) AS numero_police_count FROM edi506 WHERE MSGTXTRET LIKE '%NUMERO DE POLICE NON TROUVE%' AND f506Name LIKE '%$yesterday%'";

$resultNumeroPolice = $conn->query($sqlNumeroPolice);

$rowNumeroPolice = $resultNumeroPolice->fetch_assoc();

$numeroPoliceCount = ($rowNumeroPolice) ? $rowNumeroPolice['numero_police_count'] : 0;

 

// Query for GARANTIE NON OUVERT SUR LE SINISTRE in edi506

$sqlGarantieNonOuvert = "SELECT COUNT(MSGREFSIN) AS garantie_non_ouvert_count FROM edi506 WHERE MSGTXTRET LIKE '%GARANTIE NON OUVERTE SUR LE SINISTRE%' AND f506Name LIKE '%$yesterday%'";

$resultGarantieNonOuvert = $conn->query($sqlGarantieNonOuvert);

$rowGarantieNonOuvert = $resultGarantieNonOuvert->fetch_assoc();

$garantieNonOuvertCount = ($rowGarantieNonOuvert) ? $rowGarantieNonOuvert['garantie_non_ouvert_count'] : 0;

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Monitoring EDI</title>

    <!-- Include Bootstrap CSS -->

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->

    <style>

        .box {

            width: 80%; /* Take the full width of the parent column */

            height: 150px; /* Increased height for a larger box */

            border: 1px solid #ced4da;

            border-radius: 0.25rem;

            display: flex;

            justify-content: center;

            align-items: center;

            text-align: center;

            margin-bottom: 20px; /* Spacing between the boxes */

        }

        .boxx {

            width: 100%; /* Take the full width of the parent column */

            height: 150px; /* Increased height for a larger box */

            border: 1px solid #ced4da;

            border-radius: 0.25rem;

            display: flex;

            justify-content: center;

            align-items: center;

            text-align: center;

            margin-bottom: 20px; /* Spacing between the boxes */

        }

    </style>

</head>

<body>

 

    <div class="container">

        <div class="row mb-3">

            <div class="col-12 text-center">

                <h1 class="display-4">Monitoring EDI</h1>

            </div>

        </div>

 

        <div class="row">

            <!-- Existing Boxes Section -->

            <div class="col-md-4">

                <div class="box"><u><strong>Files date fichier<br>26/03/2024</u></strong></div>

                <div class="box"><u><strong>Intégrés par l'assureur : </u></strong></div>

                <div class="box"><u><strong>A Traiter par l'IT : </u></strong></div>

                <div class="box"><u><strong>A traiter par l'assureur : </u></strong></div>

                <div class="box"><u><strong>A traiter par le business : </u></strong></div>

                <div class="box"><u><strong>Total : </u></strong></div>

            </div>

           

            <!-- New Boxes Section -->

            <div class="col-md-4">

                <div class="boxx"><strong>EDI 508</strong></div>

                <div class="boxx"><?php echo "$totalCountBox6 sinistres"; ?></div>

                <div class="boxx"><?php echo "LE NUMERO DE SINISTRE EXISTE PAS: $existPasCount"; echo "<br>LE NUMERO DE SINISTRE EXISTE DEJA: $dejaCount"; echo "<br> LE NUMERO DE SINISTRE N'EST PAS DANS LA PLAGE ATTRIBUE: $numSinistreCount"; ?></div>

                <div class="boxx"><?php echo "LE COURTIER N'EST PAS HABILITE: $courtierCount"; echo "<br>SINISTRE HORS PERIMETRE EDI: $sinistreCount"; ?></div>

                <div class="boxx"><?php echo "COMPAGNIE GTA SANS CONVENTION IDA: $totalCountBox5"; ?></div>

                <div class="boxx"><?php echo "Total 508 : "; echo $totalCountBox5 + $existPasCount + $dejaCount + $numSinistreCount + $courtierCount + $sinistreCount; ?></div>

            </div>

           

            <!-- Additional Boxes Section -->

            <div class="col-md-4">

                <div class="boxx"><strong>EDI 506</strong></div>

                <div class="boxx"><?php echo "$totalCountBox12 sinistres"; ?></div>

                <div class="boxx"><?php echo "LE NUMERO DE SINISTRE EXISTE PAS: $existPasCount506"; echo "<br>CODE SITUATION NON COMPATIBLE AVEC UN REGLEMENT: $codeSituationCount506"; ?></div>

                <div class="boxx">-</div>

                <div class="boxx"><?php echo "NUMERO DE POLICE NON TROUVE: $numeroPoliceCount"; echo "<br>GARANTIE NON OUVERTE SUR LE SINISTRE: $garantieNonOuvertCount"; ?></div>

                <div class="boxx"><?php echo "Total 506 : "; echo $numeroPoliceCount + $existPasCount506 + $codeSituationCount506 + $garantieNonOuvertCount; ?></div>

            </div>

        </div>

    </div>

   

 

    <!-- Include jQuery and Bootstrap JS -->

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

</body>

</html>