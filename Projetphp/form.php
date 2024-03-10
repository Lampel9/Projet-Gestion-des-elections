<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style1.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
</head>
<body>
<div id="nav">
	<div id="logo"></div>
	<ul id="menu">
		<li><a href="form.php">Inscription</a></li>
		<li><a href="login.php">Login</a></li>
        <li><a href="result.php"> Resultat</a></li>

	</ul>
</div>

 <h1>Ici vous devez inscrire chaque president de bureau de vote</h1>
 <h2>NB:Retenez bien l-Email et le Password</h2>
    <div class="main">
    <form action="traite1.php" method="POST" >
    <label  for="nom">Nom:*</label>
    <input type="text" name="nom" id="nom" required placeholder="Entrez votre nom">
    
    <label for="prenom">Prenom:</label>
    <input type="text" name="prenom" id="prenom"placeholder="Entrez votre prenom">
    <label for="">Pseudo:</label>
    <input type="text" name="pseudo" id="pseudo" placeholder="Entrez votre Pseudo">
    <label for="datenaiss">date de naissance:</label>
    <input type="date" name="datenaiss" id="datenaiss" placeholder="Entrez votre date naiss">
    <label for="email">E-mail:</label>
    <input type="email" name="email" id="email"required placeholder="Entrez votre E-mail">
    <label for="mdp">Password:</label>
    <input type="password" name="mdp" id="mdp" required placeholder="Entrez votre Password"><br>
    <input type="submit" value="Envoyer" name="ok">
   
</form>
    </div>
  
</body>
</html>