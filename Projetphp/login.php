<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="style1.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>conexion</title>
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
<h1>Ici vous devez vous connecter grace a vos Identifiant</h1>

    <form action="traite2.php" method="POST">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" placeholder="Entrez votre e-mail..." required>
        <label for="mdp1">Password</label>
        <input type="password" name="mdp1" id="mdp1" placeholder="Entrez votre password.." required>
        <input type="submit" value="Conexion" name="ok">
    </form>
</body>
</html>