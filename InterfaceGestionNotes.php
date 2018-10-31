<!DOCTYPE html>
<html>

<head>
  <title>Interface de gestion de notes</title>
	<meta charset="utf-8"/>
	<style type="text/css">
  	input[type='submit'] {width: 120px}
  	select {width: 150px}
	</style>
</head>

<body>
  <?php
    include("Parametres.php");
    include("Fonctions.inc.php");

    // Connection
    $mysqli = mysqli_connect($host, $user, $pass) or die("Problème de création de la base : ".mysqli_error());
    mysqli_select_db($mysqli, $base) or die("Impossible de sélectionner la base : $base");

    // Queries
    $stmt_select_eleve = "SELECT * FROM Eleve;";
    $stmt_select_matiere = "SELECT * FROM Matiere;";

  ?>

  <h1>Gestion de notes</h1>
  <h2>Fonctionnalités d'accès</h2>

  <!-- 1ere ligne -->
  <fieldset>
      <legend>Initialisation de la base de données</legend>
  	<form target="Resultat" action="Initialiser.php">
  	    <input type="submit" value="Initialiser">
  	</form>
  </fieldset>
  <br/>

  <!-- 2eme ligne -->
  <fieldset>
      <legend>Enregistrement d'une note</legend>
  	<form method="post" target="Resultat" action="Enregistrer.php">
  	<select name="eleve" size="1">
      <?php
        $result = query($mysqli, $stmt_select_eleve);
        while($row = mysqli_fetch_assoc($result)) {
          echo "<option value=".$row['id_eleve'].">".$row['eleve']."</option>";
        }
      ?>
  	</select>
  	<br/>
  	<select name="matiere" size="1">
      <?php
        $result = query($mysqli, $stmt_select_matiere);
        while($row = mysqli_fetch_assoc($result)) {
          echo "<option value=".$row['id_matiere'].">".$row['matiere']."</option>";
        }
      ?>
  	</select>
  	<br/>
  	Note : <input type="text" size="2" maxlength="2" name="note"/>
  	<br/> <input type="submit" value="Enregistrer">
  	</form>
  </fieldset>
  <br/>

  <!-- 3eme ligne -->
  <fieldset>
      <legend>Suppression d'une note</legend>
  	<form method="post" target="Resultat" action="Supprimer.php">
  	<select name="eleve" size="1">
      <?php
        $result = query($mysqli, $stmt_select_eleve);
        while($row = mysqli_fetch_assoc($result)) {
          echo "<option value=".$row['id_eleve'].">".$row['eleve']."</option>";
        }
      ?>
  	</select>
  	<br/>
  	<select name="matiere" size="1">
      <?php
        $result = query($mysqli, $stmt_select_matiere);
        while($row = mysqli_fetch_assoc($result)) {
          echo "<option value=".$row['id_matiere'].">".$row['matiere']."</option>";
        }
      ?>
  	</select>
  	<br/>
    <input type="submit" value="Supprimer">
  	</form>
  </fieldset>
  <br/>

  <!-- 4eme ligne -->
  <fieldset>
    <legend>Afficher les résultats</legend>
  	<form method="post" target="Resultat" action="Afficher.php">

  	<strong>&Eacute;lèves :</strong><br/>
    <?php
      $result = query($mysqli, $stmt_select_eleve);
      while($row = mysqli_fetch_assoc($result)) {
        printf('<input type="checkbox" name="ListeEleves[]" value="'.$row['id_eleve'].'"/>'.$row['eleve'].'<br/>');
      }
    ?>
  	<br/>

  	<strong>Matières :</strong><br/>
    <?php
      $result = query($mysqli, $stmt_select_matiere);
      while($row = mysqli_fetch_assoc($result)) {
        printf('<input type="checkbox" name="ListeMatieres[]" value="'.$row['id_matiere'].'"/>'.$row['matiere'].'<br/>');
      }
    ?>
  	<br/>

  	<strong>Trié par :</strong><br/>
  	<input name="tri" type="radio" value="eleve" checked="checked">&Eacute;lèves<br/>
  	<input name="tri" type="radio" value="matiere">Matières<br/>
    <input type="submit" name="submit" value="Afficher">
  	</form>
  </fieldset>

</body>
</html>
