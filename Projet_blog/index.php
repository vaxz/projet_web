<!DOCTYPE HTML>
<html>

	<head>
		<meta name="viewport" content="width=device-width" charset="utf-8"/>
		<link rel="stylesheet" type="text/css" media="screen and (min-width:750px)" href="assets/style_index.css" />
		<link rel="stylesheet" type="text/css" media="screen and (max-width:750px)" href="assets/style_index750.css" />
		<title> BEEEER !!! </title>
	</head>

	<body>

		<header>
				<nav>
					<h1> BEEEER !!!</h1>
					<ul><li><a href="index.php">Accueil</a></li>
						<li><a href="liste_articles.php">Articles</a></li>
						<li><a href="ajout_article.html">Ajouter un article</a></li>
						<li><a href="a_propos.html">A propos</a></li>
					</ul>
				</nav>
		</header>

		<div>
			<form action="liste_articles.php" method="post">
				<h3>Recherche</h3>
				<textarea placeholder="Saisir votre recherche" name="recherche"></textarea>
				<button>Valider</button>
			</form>
		</div>

		<article>
			<section>
				Bienvenue sur ce site dont l'objectif est de faire découvrir la bière dans toute sa noblesse.
				Voici la liste des articles récents sur ce site.
			</section>

		  <section>
		  	<?php include ("requete_index.php") ?>
		  	<h1><?php echo ( "<a href=".$article[0]['url'].">".$article[0]['titre']."</a> ".$article[0]['date'] ); ?></h1>
			<?php echo $article[0]['resume']; ?></section>

			<section><?php echo $article[0]['pseudonyme']." ".$article[0]['dateCommentaire']; ?>
					<p><?php echo $article[0]['commentaire']; ?></p></section>
		</article>

		<footer>
			Site réalisé par : Florian Coindet et Xavier Sottiaux
		</footer>

	</body>
</html>