<?php
$servername="localhost";
$username='root';
$password='';
try{
    $bdd=new PDO("mysql:host=$servername;dbname=users",$username,$password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    // echo "conexion reussi a MyDQL avec PDO";
}catch(PDOException $e)
{
    echo "Erreur de conexion" .$e->getMessage();
}




//if(isset($_POST['ok'])){

$nom=$_POST['nom'];
$prenom=$_POST['prenom'];
$pseudo=$_POST['pseudo'];
$datenaiss=$_POST['datenaiss'];
$email=$_POST['email'];
$mdp=$_POST['mdp'];
$requete= $bdd->prepare("INSERT INTO utilisateurs VALUES (0,:nom, :prenom, :pseudo, :datenaiss, :email, :mdp)");
$requete->execute(
    array(
        "nom"=>$nom,
        "prenom"=>$prenom,
        "pseudo"=>$pseudo,
        "datenaiss"=>$datenaiss,
        "email"=>$email,
        "mdp"=>$mdp
        
    )
    );
    echo "Conextion reussi";
    header("Location: login.php");
   

 //}
?>