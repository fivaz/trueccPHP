<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title></title>
	</head>
	<body>
		<form action="recherche.php" method="post">
			<input type="text" name="name" placeholder="nom">
			<input type="text" name="pays" placeholder="pays">
			<input type="text" name="page" placeholder="page">
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