<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title></title>
	</head>
	<body>
		<form action="recherche.php" method="post">
			<select name="recherche">
				<option value="client">client</option>
				<option value="conseiller">conseiller</option>
			</select>
			<input type="text" name="nom" placeholder="nom" value="L">
			<input type="text" name="pays" placeholder="pays" value="Rus">
			<input type="text" name="page" placeholder="page" value="1">
			<label>format</label>
			<select name="format">
				<option value="">selectioner une option</option>
				<option value="pdf">pdf</option>
				<option value="csv">csv</option>
				<option value="xml">xml</option>
			</select>
			<button>rechercher</button>
		</form>
	</body>
</html>
