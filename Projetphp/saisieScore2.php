<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style3.css">
    <title>Saisie des Scores</title>
</head>
<body>
<div id="nav">
	<div id="logo"></div>
	<ul id="menu">
		<li><a href="form.php">Inscription</a></li>
		<li><a href="login.php"> Login</a></li>
        <li><a href="result.php"> Resultat</a></li>

	</ul>
</div>
    <h1>Saisie des Scores</h1>

    <!-- Formulaire de saisie des scores -->
    <form method="post" action="traitement_scores.php">
        <?php
        //Conexion a la base de donnée
        $servername = "localhost";
        $username = 'root';
        $password = '';
        try {
            $bdd = new PDO("mysql:host=$servername;dbname=users", $username, $password);
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "connexion réussie à MySQL avec PDO";
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
        
        // ici je recupere dynamiquement les candidats depuis la base de données
        $candidats = $bdd->query("SELECT * FROM Candidat")->fetchAll(PDO::FETCH_ASSOC);
       //la boucle pour parcourir la table
        foreach ($candidats as $candidat) {
            echo '<label for="score_candidat_' . $candidat['id'] . '">' . $candidat['Nom'] . ' ' . $candidat['Prenom'] . ' (' . $candidat['Parti'] . '):</label>';
            echo '<input type="number" name="score_candidat_' . $candidat['id'] . '" required>';
            echo '<input type="text" name="cni_candidat_' . $candidat['id'] . '" placeholder="CNI du candidat" required><br>';
        }
        ?>

        <!-- Bouton de soumission -->
        <input type="submit" value="Enregistrer les Scores">
    </form>
</body>
</html>
