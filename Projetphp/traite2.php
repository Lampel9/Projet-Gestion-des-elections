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
if($_SERVER["REQUEST_METHOD"]== "POST")
{
    $email=$_POST['email'];
    $mdp1=$_POST['mdp1'];
    if($email !="" && $mdp1!="")
    {
        //conection a la bdd
       $req=$bdd->query("SELECT* FROM utilisateurs WHERE email='$email' AND mdp='$mdp1' " ); 
        //on execute
        $rep=$req->fetch();
       // $a=$req->count();
        if ($rep['email']==$email)
       // if ($a>0)

        {
            //cest ok
            echo "ok $a";
            header("Location: SaisieScore.php");
            exit();
           
        }else{
         $error_msg="Email ou mdp incorect";
          // echo "non ok $a";


        }
    }
}
if($error_msg){
    ?>
    <p><?php echo $error_msg;?>
    <?php
}
?>
<a href="login.php">Retour</a>
