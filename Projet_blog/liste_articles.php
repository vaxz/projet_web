<!DOCTYPE HTML>
<html>

	<head>
		<meta name="viewport" content="width=device-width" charset="utf-8"/>
		<link rel="stylesheet" type="text/css" media="screen and (min-width:750px)" href="assets/style_liste_articles.css" />
		<link rel="stylesheet" type="text/css" media="screen and (max-width:750px)" href="assets/style_liste_articles750.css" />
		<title> BEEEER !!! </title>
	</head>

	<body>

		<header>
				<nav>
					<h1> BEEEER !!!</h1>
					<ul><li><a href="index.php">Accueil</a></li>
						<li><a href="liste_articles.php">Articles</a></li>
						<li><a href="ajout_article.php">Ajouter un article</a></li>
						<li><a href="a_propos.php">A propos</a></li>
					</ul>
				</nav>
		</header>
		<div>
			<form action=# method="post">
				<h3>Recherche</h3>
				<textarea placeholder="Saisir votre recherche" name="recherche"></textarea>
				<button>Valider</button>
			</form>
		</div>

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