<?php
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


// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nbureau = $_POST['nbureau'];
    $nbd = $_POST['nbd'];
    $cv = $_POST['cv'];
    $commune = $_POST['commune'];
    $departement = $_POST['departement'];
    $region = $_POST['region'];

    try {
        // Vérification des informations dans la base de données
        $sqlCheckInfo = "SELECT * FROM SaisieScoreCandidat WHERE NBureauVote = :nbureau AND BureauVote = :nbd AND CentreVote = :cv AND commune = :commune AND Departement = :departement AND Region = :region";

        $stmt = $bdd->prepare($sqlCheckInfo);
        $stmt->bindParam(':nbureau', $nbureau);
        $stmt->bindParam(':nbd', $nbd);
        $stmt->bindParam(':cv', $cv);
        $stmt->bindParam(':commune', $commune);
        $stmt->bindParam(':departement', $departement);
        $stmt->bindParam(':region', $region);
        $stmt->execute();

      

        if ($stmt->rowCount() > 0) {
            // Informations valides, rediriger vers la page de saisie des scores
            header("Location: saisieScore2.php");
            exit();
        } else {
            echo "Les informations ne correspondent pas. Veuillez réessayer.";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

// Fermeture de la connexion à la base de données
$bdd = null;


























/*
$nbureau=$_POST['nbureau'];
$nbd=$_POST['nbd'];
$cv=$_POST['cv'];
$commune=$_POST['commune'];
$departement=$_POST['departement'];
$region=$_POST['region'];
        
            $requete= $bdd->prepare("INSERT INTO SaisieScoreCandidat VALUES (:NBureau, :BureauVote, :CentreVote, :Commune, :Departement, :Region,0)");
            $requete->execute(
                array(
                    "NBureau"=>$nbureau,
                    "BureauVote"=>$nbd,
                    "CentreVote"=>$cv,
                    "Commune"=>$commune,
                    "Departement"=>$departement,
                    "Region"=>$region,
                 


                )
                );
                echo "Conextion reussi";
                echo "Envoyer avec succes";*/


       
            


           
        
   // }

        ?>
    







