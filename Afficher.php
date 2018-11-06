<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Afficher</title>

  <style media="screen">
    td, th {
      border: 1px solid black;
      padding: 5px 8px;
    }
  </style>
</head>

<body>
  <?php
    include("Parametres.php");
    include("Fonctions.inc.php");

    // Connection
    $mysqli = mysqli_connect($host, $user, $pass) or die("Problème de création de la base : ".mysqli_error());
    mysqli_select_db($mysqli, $base) or die("Impossible de sélectionner la base : $base");

    // Variables
    $list_eleve = isset($_POST['ListeEleves']) ? $_POST['ListeEleves'] : '';
    $list_matiere = isset($_POST['ListeMatieres']) ? $_POST['ListeMatieres'] : '';
    $tri = isset($_POST['tri']) ? $_POST['tri'] : '';

    // Functions
    // Escapes injected MySQL queries for all elements of the array
    function escape_array($mysqli, &$array) {
      return array_walk($array, function(&$string) use ($mysqli) {
        $string = mysqli_real_escape_string($mysqli, $string);
      });
    }

    // Test if lists are checked
    if(empty($list_eleve) || empty($list_matiere)) {
      echo "Veuillez sélectionner au moins un élève et une matière s'il vous plaît.";
    } else {

      escape_array($mysqli, $list_eleve);
      escape_array($mysqli, $list_matiere);

      // Add to each value of array the given string
      $list_eleve = implode("','", $list_eleve);
      $list_matiere = implode("','", $list_matiere);

      // Query
      $stmt_show_students_grades =  "SELECT E.eleve, M.matiere, R.note FROM Eleve E, Matiere M, Resultat R
      WHERE R.id_eleve = E.id_eleve AND R.id_matiere = M.id_matiere
      AND R.id_eleve IN('$list_eleve') AND R.id_matiere IN('$list_matiere')
      ORDER BY $tri;";

      // Execute query
      $result = query($mysqli, $stmt_show_students_grades);
  ?>

  <table>
    <tr>
      <th>Élève</th>
      <th>Matière</th>
      <th>Note</th>
    </tr>
    <?php
      while($row = mysqli_fetch_assoc($result)) {
        echo "
    <tr>
      <td>".$row['eleve']."</td>
      <td>".$row['matiere']."</td>
      <td>".$row['note']."</td>
    </tr>
        ";
      }
      echo "\n";
    } // End else
    ?>
  </table>

</body>
</html>
