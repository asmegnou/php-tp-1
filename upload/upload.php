<!DOCTYPE html>
<html>
<head>
<title>Téléversement de fichier</title>
</head>
<body>
	<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post"
		enctype="multipart/form-data">
		<fieldset>
			<legend>
				<b>Transférez un fichier ZIP</b>
			</legend>
			<table border="1">
				<tr>
					<td>Choisissez un fichier</td>
					<td><input type="file" name="fich" accept="application/zip" /></td>
					<td><input type="hidden" name="MAX_FILE_SIZE" value="1000000" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" value="ENVOI" /></td>
				</tr>
			</table>
		</fieldset>
	</form>

<?php
// A COMPLETER
	//var_dump($_FILES);
	//verrifier que le fichier a bien etait envoyé et que y'a pas d'erreur de telechargement 
	if( isset($_FILES['fich'])  && $_FILES['fich']['error'] == 0 ){
		$size = $_FILES['fich']['size'] / (1024*1024);
		//$type = $_FILES5['fich']['type'];  apres je peux faire if $type == application/zip
		if($size<=1 ){
			$filename = $_FILES['fich']['name'];
			echo '<b>Vous avez bien transféré le fichier</b>';
			echo '<hr>';
			echo "<p>le nom du fichier est : $filename </p>";
			echo '<hr>';
			echo "<p>Votre fichier a une taille de : ". round($size,2)." Mo</p>";

		}
	}

?>

</body>
</html>