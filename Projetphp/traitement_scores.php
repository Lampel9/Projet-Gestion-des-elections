<?php
// Connexion à la base de données
$servername = "localhost";
$username = 'root';
$password = '';

try {
    $bdd = new PDO("mysql:host=$servername;dbname=users", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Initialisation des variables
$formulaireEnvoye = false;
$messageErreur = '';

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cniInvalides = [];

    foreach ($_POST as $key => $value) {
        if (preg_match('/^score_candidat_(\d+)$/', $key, $matches)) {
            $candidatId = $matches[1];
            $scoreCandidat = $value;

            // Récupération du CNI du candidat
            $cniCandidat = $_POST['cni_candidat_' . $candidatId];

            // Recherche de l'ID du candidat en fonction du CNI
            $sqlGetIdCandidat = "SELECT id FROM Candidat WHERE CNI = :cniCandidat";
            $stmtGetIdCandidat = $bdd->prepare($sqlGetIdCandidat);
            $stmtGetIdCandidat->bindParam(':cniCandidat', $cniCandidat);
            $stmtGetIdCandidat->execute();

            // Vérification si le candidat existe
            if ($stmtGetIdCandidat->rowCount() > 0) {
                $row = $stmtGetIdCandidat->fetch(PDO::FETCH_ASSOC);
                $idCandidat = $row['id'];

                // Mise à jour du score pour le candidat
                $sqlUpdateCandidat = "UPDATE Candidat SET Score = Score + :score WHERE id = :idCandidat";
                $stmtUpdateCandidat = $bdd->prepare($sqlUpdateCandidat);
                $stmtUpdateCandidat->bindParam(':score', $scoreCandidat, PDO::PARAM_INT);
                $stmtUpdateCandidat->bindParam(':idCandidat', $idCandidat, PDO::PARAM_INT);
                $stmtUpdateCandidat->execute();
            } else {
                $cniInvalides[] = $cniCandidat;
            }
        }
    }

    // Vérification des CNIs invalides
    if (empty($cniInvalides)) {
        $formulaireEnvoye = true;
    } else {
        $messageErreur = "Erreur : Les CNIs suivants ne sont pas valides : " . implode(', ', $cniInvalides);
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .erreur-message {
            color: red;
            margin-bottom: 20px;
        }
    </style>
      <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }

        button:hover {
            background-color: #45a049;
        }

        .erreur-message {
            color: red;
            margin-bottom: 20px;
        }

        .succes-message {
            color: #2ecc71;
            margin-bottom: 20px;
        }

        .lien {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <?php if ($formulaireEnvoye) : ?>
        <p class="succes-message">Formulaire envoyé avec succès.</p>
        <p class="succes-message">Merci d'avoir soumis vos scores !</p>
        <a class="lien" href='result.php'>Voir les résultats</a> | <a class="lien" href='login.php'>Quitter définitivement</a>
    <?php else : ?>
        <div class="erreur-message"><?php echo $messageErreur; ?></div>
        <button onclick="window.location.href='saisieScore2.php'">Retour</button>
    <?php endif; ?>
</body>
</html>
