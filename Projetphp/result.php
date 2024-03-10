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

// Récupération de tous les candidats
$sqlAllCandidates = "SELECT id, Nom, Prenom, Partie, CNI, Score FROM Candidat";
$stmtAllCandidates = $bdd->prepare($sqlAllCandidates);
$stmtAllCandidates->execute();
$allCandidates = $stmtAllCandidates->fetchAll(PDO::FETCH_ASSOC);

// Récupération du nombre de candidats
$sqlCountCandidats = "SELECT COUNT(*) AS nbCandidats FROM Candidat";
$stmtCountCandidats = $bdd->prepare($sqlCountCandidats);
$stmtCountCandidats->execute();
$rowCountCandidats = $stmtCountCandidats->fetch(PDO::FETCH_ASSOC);
$nbCandidats = $rowCountCandidats['nbCandidats'];

// Vérification si un candidat a obtenu plus de 50% des votes
$sqlTopCandidates = "SELECT id, Nom, Prenom, Partie, CNI, Score FROM Candidat ORDER BY Score DESC LIMIT 2";
$stmtTopCandidates = $bdd->prepare($sqlTopCandidates);
$stmtTopCandidates->execute();
$topCandidates = $stmtTopCandidates->fetchAll(PDO::FETCH_ASSOC);

// Calcul du total des scores
$sqlTotalScores = "SELECT SUM(Score) AS totalScores FROM Candidat";
$stmtTotalScores = $bdd->prepare($sqlTotalScores);
$stmtTotalScores->execute();
$rowTotalScores = $stmtTotalScores->fetch(PDO::FETCH_ASSOC);
$totalScores = $rowTotalScores['totalScores'];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <title>Résultats des élections</title>
    <div id="nav">
	<div id="logo"></div>
	<ul id="menu">
		<li><a href="form.php">Inscription</a></li>
		<li><a href="login.php">Login</a></li>
        <li><a href="result.php"> Resultat</a></li>

	</ul>
</div>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .candidates-list {
            list-style-type: none;
            padding: 0;
        }

        .candidate-item {
            background-color: #e6e6e6;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 4px;
        }

        .status {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .elected {
            color: #2ecc71;
        }

        .ballottage {
            color: #e67e22;
        }

        .runoff {
            color: #3498db;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Résultats de tous les candidats :</h2>
        <ul class="candidates-list">
            <?php foreach ($allCandidates as $candidate) : ?>
                <li class="candidate-item">
                    <strong><?php echo $candidate['Nom'] . ' ' . $candidate['Prenom'] . " (" . $candidate['Partie'] . "):"; ?></strong>
                    Score : <?php echo $candidate['Score']; ?><br>
                    CNI : <?php echo $candidate['CNI']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="container">
        <h2>Résultats du premier tour :</h2>
        <ul class="candidates-list">
            <?php foreach ($topCandidates as $candidate) : ?>
                <li class="candidate-item">
                    <?php
                    $candidateName = $candidate['Nom'] . ' ' . $candidate['Prenom'];
                    $candidateParty = $candidate['Partie'];
                    $candidateScore = $candidate['Score'];
                    $percentageCandidate = $candidateScore / $totalScores * 100;
                    ?>
                    <span class="status <?php echo ($percentageCandidate >= 50) ? 'elected' : 'ballottage'; ?>">
                        <?php echo ($percentageCandidate >= 50) ? 'Élu dès le premier tour :' : 'Ballottage :'; ?>
                    </span>
                    <strong><?php echo $candidateName . ' (' . $candidateParty . '):'; ?></strong>
                    Score : <?php echo $candidateScore; ?><br>
                    CNI : <?php echo $candidate['CNI']; ?><br>
                    Score : <?php echo number_format($percentageCandidate, 2) . '%'; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="container">
        <h2>Résultat final :</h2>
        <ul class="candidates-list">
            <?php if ($nbCandidats > 0) : ?>
                <?php if ($percentageCandidate >= 50) : ?>
                    <li class="candidate-item">
                        <span class="status elected">Élu dès le premier tour :</span>
                        <?php echo $candidateName . ' (' . $candidateParty . ')'; ?>
                    </li>
                <?php else : ?>
                    <?php
                    // S'il n'y a pas de gagnant au premier tour, déterminez les candidats pour le second tour
                    $sqlTop2Candidates = "SELECT id, Nom, Prenom, Partie, CNI, Score FROM Candidat ORDER BY Score DESC LIMIT 2";
                    $stmtTop2Candidates = $bdd->prepare($sqlTop2Candidates);
                    $stmtTop2Candidates->execute();
                    $top2Candidates = $stmtTop2Candidates->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <?php foreach ($top2Candidates as $candidate) : ?>
                        <li class="candidate-item">
                            <span class="status runoff">Participera au second tour :</span>
                            <?php echo $candidate['Nom'] . ' ' . $candidate['Prenom'] . ' (' . $candidate['Partie'] . ')'; ?>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php else : ?>
                <li class="candidate-item">Aucun candidat enregistré.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
   