<html>
<head>
	<title>Initialisation de la base de données</title>
	<meta charset="utf-8" />
</head>

<body>
<?php

  include("Parametres.php");
  include("Fonctions.inc.php");

  // Connexion au serveur MySQL
  $mysqli = mysqli_connect($host, $user, $pass) or die("Problème de création de la base : ".mysqli_error());

  // Suppression / Création / Sélection de la base de données : $base
  query($mysqli, 'DROP DATABASE IF EXISTS '.$base);
  query($mysqli, 'CREATE DATABASE '.$base);

	mysqli_select_db($mysqli, $base) or die("Impossible de sélectionner la base : $base");

	query($mysqli, "CREATE TABLE `Resultat` (
		`id_eleve` int(11) NOT NULL,
		`id_matiere` int(11) NOT NULL,
		`note` int(11) NOT NULL,
		PRIMARY KEY (`id_eleve`,`id_matiere`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

	query($mysqli, "CREATE TABLE `Partiels`.`Eleve` (
		`id_eleve` INT NOT NULL AUTO_INCREMENT,
		`eleve` VARCHAR(60) NOT NULL,
		PRIMARY KEY (`id_eleve`)
	) ENGINE = InnoDB;");

	query($mysqli, "CREATE TABLE `Partiels`.`Matiere` (
		`id_matiere` INT NOT NULL AUTO_INCREMENT,
		`matiere` VARCHAR(120) NOT NULL,
		PRIMARY KEY (`id_matiere`)
	) ENGINE = InnoDB;");

	query($mysqli, "INSERT INTO `Eleve` (`id_eleve`, `eleve`) VALUES (NULL, 'Pierre'), (NULL, 'Paul'), (NULL, 'Jean'), (NULL, 'Jacques');");
	query($mysqli, "INSERT INTO `Matiere` (`id_matiere`, `matiere`) VALUES (NULL, 'Maths'), (NULL, 'Bases de données'), (NULL, 'PHP');");

	mysqli_close($mysqli);
?>

Initialisation réussie
</body>
</html>
