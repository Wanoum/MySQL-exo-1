<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Enregistrer</title>
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
    $grade = isset($_POST['note']) ? $_POST['note'] : '';
    // test if empty == true

    $esp_id_eleve = mysqli_real_escape_string($mysqli, $id_eleve);
    $esp_id_matiere = mysqli_real_escape_string($mysqli, $id_matiere);
    $esp_grade = mysqli_real_escape_string($mysqli, $grade);

    // Queries
    $stmt_change_grade = "REPLACE INTO Resultat VALUES ($esp_id_eleve, $esp_id_matiere, $esp_grade);";
    $stmt_show_students = "SELECT eleve FROM Eleve WHERE `id_eleve` = $esp_id_eleve;";
    $stmt_show_course = "SELECT matiere FROM Matiere WHERE `id_matiere` = $esp_id_matiere;";

    // If input grade is empty and grade is not between 0-20, display error
    if(empty($_POST['note']) || ($grade > 20) || ($grade < 0)) {
      echo "Veuillez entrer une note valide comprise entre 0 et 20 pour l'élève s'il vous plaît.";

    } else { // If everything's good...
      $result = query($mysqli, $stmt_change_grade);

      // Test if grade was modified or added
      $insert_or_modify = mysqli_affected_rows($mysqli);
      if($insert_or_modify == 1) { // Grade added
        // Execute query after other is executed, otherwise result will alter mysqli_affected_rows
        $result = query($mysqli, $stmt_show_students);
        $row = mysqli_fetch_assoc($result);
        echo "Note de l'élève ".$row["eleve"]." ajoutée avec succès en ";

        $result = query($mysqli, $stmt_show_course);
        $row = mysqli_fetch_assoc($result);
        echo $row["matiere"].". Nouvelle note: $grade/20.";

      } else { // If grade is modified
        $result = query($mysqli, $stmt_show_students);
        $row = mysqli_fetch_assoc($result);
        echo "Note de l'élève ".$row["eleve"]." modifée avec succès en ";

        $result = query($mysqli, $stmt_show_course);
        $row = mysqli_fetch_assoc($result);
        echo $row["matiere"].". Nouvelle note: $grade/20.";
      }
    }
  ?>
</body>
</html>
