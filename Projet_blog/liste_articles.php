<?php session_start() ?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta name="viewport" content="width=device-width" charset="utf-8"/>
		<link rel="stylesheet" type="text/css" media="screen and (min-width:750px)" href="assets/style_liste_articles.css" />
		<link rel="stylesheet" type="text/css" media="screen and (max-width:750px)" href="assets/style_liste_articles750.css" />
		<title> BEEEER !!! </title>
	</head>

	<body>

		<?php require_once("element_principal.php"); ?>

		<article>
		  
  			<?php

  				if( !empty($_POST['recherche']) ){
				
					include ("requete_liste_articles.php");

		  		}else{

		  			echo "<section>Veuillez effectuer une recherche</section>";
		  		}
		  	?>
		  				
		</article>

		<footer>
			Site réalisé par : Florian Coindet et Xavier Sottiaux
		</footer>

	</body>
</html>