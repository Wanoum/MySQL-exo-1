<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Supprimer</title>
</head>

<body>
  <?php
    include("Parametres.php");
    include("Fonctions.inc.php");

    // Connexion au serveur MySQL
    $mysqli = mysqli_connect($host, $user, $pass) or die("Problème de création de la base : ".mysqli_error());
    mysqli_select_db($mysqli, $base) or die("Impossible de sélectionner la base : $base");

    // Variables
    $id_eleve = isset($_POST['eleve']) ? $_POST['eleve'] : '';
    $id_matiere = isset($_POST['matiere']) ? $_POST['matiere'] : '';

    $esp_id_eleve = mysqli_real_escape_string($mysqli, $id_eleve);
    $esp_id_matiere = mysqli_real_escape_string($mysqli, $id_matiere);

    // Queries
    $stmt_delete_grade = "DELETE FROM `Resultat` WHERE `id_eleve` = $esp_id_eleve AND `id_matiere` = $esp_id_matiere;";
    $stmt_show_students = "SELECT eleve FROM Eleve WHERE `id_eleve` = $esp_id_eleve;";
    $stmt_show_course = "SELECT matiere FROM Matiere WHERE `id_matiere` = $esp_id_matiere;";

    $result = query($mysqli, $stmt_delete_grade);

    // If no one is concerned, then display error
    if(mysqli_affected_rows($mysqli) == 0) {
      $result = query($mysqli, $stmt_show_students);
      $row = mysqli_fetch_assoc($result);
      echo "Pas de note pour l'élève ".$row["eleve"]." dans la matière ";

      $result = query($mysqli, $stmt_show_course);
      $row = mysqli_fetch_assoc($result);
      echo $row["matiere"].".";

    } else { // Someone has a grade in this course
      $result = query($mysqli, $stmt_show_students);
      $row = mysqli_fetch_assoc($result);
      echo "Note supprimée pour l'élève ".$row["eleve"]." dans la matière ";

      $result = query($mysqli, $stmt_show_course);
      $row = mysqli_fetch_assoc($result);
      echo $row["matiere"].".";
    }
  ?>
</body>
</html>
