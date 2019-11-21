<?php
  $recherche = $_POST['recherche'];

  $nom = "";
  if(isset($_POST['nom']))
    $nom = $_POST['nom'];

  $pays = "";
    if(isset($_POST['pays']))
  $pays = $_POST['pays'];

  $page = 1;
  if(isset($_POST['page']))
    $page = $_POST['page'];

  $format = "html";
    if(isset($_POST['format']))
  $format = $_POST['format'];

  if($recherche == "client"){
    $rows = chercher_clients($nom, $pays);
    $new_rows = get_page($rows, $page);

   if ($format == "pdf")
       printPDF($new_rows);
   else if ($format == "csv")
       printCSV($new_rows);
   else if ($format == "xml")
       printXML($new_rows);
   else
       printHTML($new_rows);
  }
  else{
    $rows = chercher_conseiller($nom);
    $new_rows = get_page($rows, $page);
    printJSON($new_rows);
  }

  //functions
  function chercher_clients($nom, $pays){
      $dsn = "mysql:host=localhost;dbname=basescc";
      $user = "root";
      $passwd = "";
      $pdo = new PDO($dsn, $user, $passwd);
      $query = 'SELECT * from client';
      if($nom || $pays){
        //c'est 1 = 1 c'est juste pour gérer faciliment le mot réservé AND dans tous les cas
        $query .= " WHERE 1 = 1 ";
        if($nom){
          $query .= "AND nom LIKE '{$nom}%' ";
        }
        if($pays){
          $query .= "AND pays LIKE '{$pays}%' ";
        }
      }
      $stm = $pdo->query($query);
      return $stm->fetchAll(PDO::FETCH_ASSOC);
  }

  function chercher_conseiller($nom){
      $dsn = "mysql:host=localhost;dbname=basescc";
      $user = "root";
      $passwd = "";
      $pdo = new PDO($dsn, $user, $passwd);
      $query = 'SELECT * from conseiller';
      if($nom){
          $query .= " WHERE nom LIKE '{$nom}%'";
      }
      $stm = $pdo->query($query);
      $conseillers = $stm->fetchAll(PDO::FETCH_ASSOC);

      for ($i=0; $i < count($conseillers); $i++) {
        $query = "SELECT * from client WHERE conseiller_id = {$conseillers[$i]['id']}";
        $stm = $pdo->query($query);
        $clients = $stm->fetchAll(PDO::FETCH_ASSOC);
        $conseillers[$i]['clients'] = $clients;
      }
      return $conseillers;
  }

  function get_page($rows, $page){
    if(!$page)
    $page = 1;
    $new_array = array_chunk($rows, 20);
    if(!isset($new_array[$page - 1])){
      echo "la valeur de la page est trop grande\n\n";
    }
    return $new_array[$page - 1];
  }

  //prints
  function printHTML($rows){
    foreach ($rows as $row) {
      echo "<div>".$row['nom']." - ".$row['prenom']." - ".$row['pays']."</div>";
    }
  }

  function printCSV($rows){
    $f = fopen('php://memory', 'w');
    fwrite($f, "id; nom; prenom; email; pays; npa; conseiller_id;\n");
    foreach ($rows as $row) {
        fputcsv($f, $row, ";");
    }
    fseek($f, 0);
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="fichier.csv";');
    fpassthru($f);
  }

  function printPDF($rows){
    require('fpdf.php');
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, "Nom", 1);
    $pdf->Cell(40, 10, "Prénom", 1);
    $pdf->Cell(40, 10, "Pays", 1);
    $pdf->Cell(40, 10, "NPA", 1, 1);
    for ($i = 0; $i < count($rows); $i++) {
        $row = $rows[$i];
        $pdf->Cell(40, 10, $row['nom'], 1);
        $pdf->Cell(40, 10, $row['prenom'], 1);
        $pdf->Cell(40, 10, $row['pays'], 1);
        $pdf->Cell(40, 10, $row['npa'], 1, 1);
    }
    $pdf->Output();
  }

  function printXML($rows){
    $f = fopen('php://memory', 'w');
    foreach ($rows as $row) {
        $string = "<client id=".$row['id'].">
          <nom>".$row['nom']."</nom>
          <prenom>".$row['prenom']."</prenom>
          <email>".$row['email']."</email>
          <pays>".$row['pays']."</pays>
          <npa>".$row['npa']."</npa>
        </client>
        ";
        fwrite($f, $string);
    }
    fseek($f, 0);
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="fichier.xml";');
    fpassthru($f);
  }

  function printJSON($rows){
    echo json_encode($rows);
  }
?>
