<?php
	function chercher_clients($nom, $pays, $page){
			$dsn = "mysql:host=localhost;dbname=basescc";
			$user = "root";
			$passwd = "";
			$pdo = new PDO($dsn, $user, $passwd);
      $query = 'SELECT * from client';
	    $stm = $pdo->query($query);
      return $stm->fetchAll(PDO::FETCH_ASSOC);
  }

  $recherche = $_POST['recherche'];
  $nom = "";
  if(isset($_POST['nom']))
    $nom = $_POST['nom'];

  $pays = "";
    if(isset($_POST['pays']))
  $pays = $_POST['pays'];

  $page = "";
  if(isset($_POST['page']))
    $page = $_POST['page'];

  $format = "html";
    if(isset($_POST['format']))
  $format = $_POST['format'];

  if($recherche == "client")
    $rows = chercher_clients($nom, $pays, $page);
  else if($recherche == "conseiller")
    $rows = chercher_conseiller($nom, $page);

  print_r($rows);
?>
