<?php
	function chercher_clients($nom, $pays, $page, $format){
		try {
			$dsn = "mysql:host=localhost;dbname=basescc";
			$user = "root";
			$passwd = "";
			$pdo = new PDO($dsn, $user, $passwd);
		    foreach($pdo->query('SELECT * from client') as $row) {
		        print_r($row);
		    }
		    $dbh = null;
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    die();
		}
	}

  $nom = $_POST['nom'];
  $pays = $_POST['pays'];
  $page = $_POST['page'];
  $format = $_POST['format'];


?>
