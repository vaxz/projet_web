<!DOCTYPE HTML>
<html>

	<?php

		if( !empty($_GET['id']) ){

					$valeur=$_GET['id'];

					include("bdd.php");
					$bdd=Connect_db(); //connexion à la BDD

 					$query=$bdd->prepare('SELECT T1.Titre, T1.DateCreation, T1.URL, T1.Resume, T2.Commentaire, T2.DateCommentaire, T3.Pseudonyme
 						 				  FROM Article AS T1
 						 			 	  INNER JOIN Commentaire AS T2
 						 			 	  ON T1.IDArticle=T2.IDArticle
 						 			 	  INNER JOIN Utilisateur AS T3
 						 			  	  ON T2.IDUtilisateur=T3.IDUtilisateur
 						  			  	  WHERE T1.IDArticle=?
 						  			  	  ORDER BY T1.DateCreation DESC');
 					//requete permettant de récupérer les infos sur un article, commentaire, pseudonyme de l'utilisateur

 					$query->execute( array($valeur) );

 					while($data = $query->fetch()){
 						$article[]=array(
								'titre' => $data['Titre'],
								'date' => $data['DateCreation'],
								'url' => $data['URL'],
								'resume' => $data['Resume'],
								'commentaire' => $data['Commentaire'],
								'dateCommentaire' => $data['DateCommentaire'],
								'pseudonyme' => $data['Pseudonyme']
								);
 					}
	?>

	<head>
		<meta name="viewport" content="width=device-width" charset="utf-8"/>
		<link rel="stylesheet" type="text/css" media="screen and (min-width:750px)" href="articles/assets/style_articles.css" />
		<link rel="stylesheet" type="text/css" media="screen and (max-width:750px)" href="articles/assets/style_articles750.css" />
		<title> <?php echo ($article[0]['titre']) ?></title>
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
		<!--<div>
			<form action="" method="post">
				<h3>Authentification</h3>
				<textarea placeholder="Saisir votre recherche" name="recherche"></textarea>
				<button>Valider</button>
			</form>
		   </div>
		-->

		<?php
			
 				$fichier=fopen($article[0]['url'],'r');

 				if ( $fichier!=NULL ){

 					$ligne=fgets($fichier);
 					echo $ligne;
 						while($ligne){
 							$ligne=fgets($fichier);
 							echo $ligne;
 						}


 				}else echo 'Le fichier spécifié n\'a pas été trouvé';

 				fclose($fichier);

			}else echo "erreur d'identifiant de la page";
		?>

		<div>
			<form action=# method="post">
				<h1>Commentaire</h1>
				<?php

					for ($i=0; $i<count($article); $i++) {
						echo (
							  "<section>".$article[$i]['pseudonyme']." Date : ".$article[$i]['date']."<p>".$article[$i]['commentaire'].
							  "</p></section>"
							  );
					}
				?>
				<textarea placeholder="Votre commentaire" name="commentaire"></textarea>
				<button>Valider</button>
				<?php if( !empty($_POST['commentaire']) ) include ("ajout_commentaire.php") ?>
			</form>
		</div>

		<footer>
			Site réalisé par : Florian Coindet et Xavier Sottiaux
		</footer>
	</body>
</html>

