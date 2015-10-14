<?php 
/*
* Coded by Loïc Parent
* 14 / 10 / 2015
* www.loic-parent.be
*/
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="Author" content="Loïc Parent">
	<meta name="Description" content="Changer les valeurs de millisecondes dans le but de modifier l’apparition des sous-titre">
	<title>Et changerrr</title>
</head>
<body>
	<h1>Modifions ce petit fichier :D … on y croit</h1>
	<p>But&nbsp;: Changer les valeurs de millisecondes dans le but de modifier l’apparition des sous-titre</p>
	<form action="#" method="post" enctype="multipart/form-data">
		<input type="file" name="fichier" id="fichier">
		<br>
		<br>
		<label for="nombre">préciser le nombre de milliseconde à ajouter</label>
		<input type="number" name="nombre" id="nombre">
		<br>
		<br>
		<input type="submit" name="submit">
	</form>

	<?php 
	if( isset( $_POST['submit'] ) ){
		if ( isset( $_POST['nombre'] ) ) {
			if( isset( $_FILES['fichier'] ) && !empty($_FILES['fichier']['tmp_name']) ) {
				$monFichier = file($_FILES['fichier']['tmp_name']);
				foreach ( $monFichier as $lineNumber => $lineContent )
					{
						$subject = $lineContent;
						$pattern = '/(\d{2}):(\d{2}):(\d{2}),(\d+)/m';
						$replace = '$1';
						$subject = preg_replace_callback( $pattern, function( $matches ) {
							$addNumber = intval($_POST['nombre']);
							$h = $matches[1];
							$m = $matches[2];
							$s = $matches[3];
							$ms = $matches[4];
							$total = $ms + ( $s * 1000 ) + ( $m * ( 1000 * 60 ) ) + ( $h * ( 1000 * 60 * 60 ) ) + $addNumber;
							$nh = ( $total / ( 1000 * 60 * 60 ) ) % 24;
							$nm = ( $total / ( 1000 * 60 ) ) % 60;
							$ns = ( $total / 1000 ) % 60;
							$nms = ( $total % 1000 );
							if ( $nms < 100 ) {
								$nms = '0'.$nms;
								if ( $nms < 10 ) {
									$nms = '0'.$nms;
								}
							}
							return $nh.':'.$nm.':'.$ns.','.$nms;
						}, $subject );
						echo '<pre>';
				  		echo $subject;
				  		echo '</pre>';
					}
			} else {
				die( 'Vous devez entrer un fichier de sous-titre' );	
			}
		} else {
			die( 'Vous devez entrer un nombre compris entre 1 et 999' );
		}
	}
	?>

</body>
</html>