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

// Récupération de toutes les lignes de la table SaisieScoreCandidat
$sqlSaisieScores = "SELECT * FROM SaisieScoreCandidat";
$stmtSaisieScores = $bdd->prepare($sqlSaisieScores);
$stmtSaisieScores->execute();
$saisieScores = $stmtSaisieScores->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="style1.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaisieScore</title>
</head>
<body>
    <div id="nav">
        <div id="logo"></div>
        <ul id="menu">
            <li><a href="form.php">Inscription</a></li>
            <li><a href="login.php"> Login</a></li>
        </ul>
    </div>
    <h1>Ici vous devez remplir ce formulaire pour avoir accès au formulaire de saisie des scores des candidats</h1>
    <h2>NB: Si les informations ne correspondent pas à la base de données, vous ne pourrez pas accéder à la page de saisie des scores</h2>

    <p>Cependant, voici les informations insérées dans la base de données :</p>

    <?php
    // Affiche les informations dans un tableau
    echo "<table border='1'>";
    echo "<tr><th>Numero Bureau de Vote</th><th>Nom Bureau de Vote</th><th>Centre de Vote</th><th>Commune</th><th>Departement</th><th>Region</th></tr>";
    foreach ($saisieScores as $score) {
        echo "<tr>";
        echo "<td>" . $score['NBureauVote'] . "</td>";
        echo "<td>" . $score['BureauVote'] . "</td>";
        echo "<td>" . $score['CentreVote'] . "</td>";
        echo "<td>" . $score['Commune'] . "</td>";
        echo "<td>" . $score['Departement'] . "</td>";
        echo "<td>" . $score['Region'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>

    <form action="trate3.php" method="POST">
      
    <label for="nbureau">Numero de bureau de vote:</label>
        <input type="number" name="nbureau" id=""><br>
        <label for="nbd">Nom Bureau de vote:</label>
        <input type="text" name="nbd" id=""><br>
        <label for="cv">Centre de vote:</label>
        <input type="text" name="cv" id=""><br>
        <label for="commune">Commune:</label>
        <input type="text" name="commune" id=""><br>
        <label for="departement">Departement</label>
        <input type="text" name="departement" id=""><br>
        <label for="Region">Region</label>
        <input type="text" name="region" id=""><br>
    
        <input type="submit" value="Ajouter" name="ok"><br>
    </form>
</body>
</html>
