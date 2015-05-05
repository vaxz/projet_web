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
						<li><a href="ajout_article.php">Ajouter un article</a></li>
						<li><a href="a_propos.php">A propos</a></li>
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
		
			<?php

				if( !empty($_SESSION['ID']) && !empty($_SESSION['MDP']) ){

					echo(	'<div>
							<form action=# method="post" >
							<h3>Se connecter</h3>
							<input type="text" placeholder="Identifiant" name="ID">
							<input type="password" placeholder="Mot de passe" name="MDP">
							<button>Connexion</button>
							</form>
							</div>'
						);

					if( !empty($_POST['ID']) && !empty($_POST['MDP']) ){
						//tester le mot de passe et idnetifiant de l'utilisateur
						$_SESSION['ID']=$_POST['ID'];
						$_SESSION['MDP']=$_POST['MDP'];
					}else{
						//afficher le message d'erreur
						echo "L'identifiant ou le mot de passe sont incorrects";
					}

				}else{



				}
					
			?>


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