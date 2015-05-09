<?php session_start() ?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta name="viewport" content="width=device-width" charset="utf-8"/>
		<link rel="stylesheet" type="text/css" media="screen and (min-width:750px)" href="assets/style_index.css" />
		<link rel="stylesheet" type="text/css" media="screen and (max-width:750px)" href="assets/style_index750.css" />
		<title> BEEEER !!! </title>
	</head>

	<body>

		<?php include("element_principal.php"); ?>

		<article>
			<section>
				Bienvenue sur ce site dont l'objectif est de faire découvrir la bière dans toute sa noblesse.
				Voici la liste des articles récents sur ce site.
			</section>

		  <section>
		  	<?php include ("requete_index.php") ?>
		  	<h1><?php echo ( "<a href=article.php?id=".$article[0]['id'].">".$article[0]['titre']."</a> ".$article[0]['date'] ); ?></h1>
			<?php echo $article[0]['resume']; ?></section>

			<section><?php echo $article[0]['pseudonyme']." ".$article[0]['dateCommentaire']; ?>
					<p><?php echo $article[0]['commentaire']; ?></p></section>
		</article>

		<footer>
			Site réalisé par : Florian Coindet et Xavier Sottiaux
		</footer>

	</body>
</html>