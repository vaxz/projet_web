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

		<?php require_once("element_principal.php"); ?>

		<article>
			<section>
				Bienvenue sur ce site dont l'objectif est de faire découvrir la bière dans toute sa noblesse.
				Voici la liste des articles récents sur ce site.
			</section>

		  <section>
		  	<?php

					require_once("bdd.php");

					$bdd=Connect_db(); //connexion à la BDD

				 	$query0=$bdd->prepare('SELECT T1.IDArticle, T1.Titre, T1.DateCreation, T1.URLArticle, T1.Resume
				 						  FROM Article AS T1
				 						  ORDER BY T1.DateCreation DESC');
				 	$query0->execute();
				 	$data0 = $query0->fetch();
				 	$article[]=array(	
				 						'id' => $data0['IDArticle'],
										'titre' => $data0['Titre'],
										'date' => $data0['DateCreation'],
										'url' => $data0['URLArticle'],
										'resume' => $data0['Resume']
									);
				 	$query0->closeCursor();

				 	$query1=$bdd->prepare('SELECT T1.Commentaire, T1.DateCommentaire, T2.Pseudonyme
				 						  FROM Commentaire AS T1
				                          INNER JOIN Utilisateur AS T2
				                          ON T1.IDUtilisateur=T2.IDUtilisateur
				                          WHERE T1.IDArticle=?
				 						  ORDER BY T2.DateCommentaire DESC');
				 	$query1->execute( array($article[0]['id']) );
				 	if ( ( $data1 = $query1->fetch() ) != NULL ){ 
						 	$commentaire[]=array(
												'commentaire' => $data1['Commentaire'],
												'dateCommentaire' => $data1['DateCommentaire'],
												'pseudonyme' => $data1['Pseudonyme']
												);
					}
				 	$query1->closeCursor();

			 ?>
		  	<h1><?php echo ( "<a href=article.php?id=".$article[0]['id'].">".$article[0]['titre']."</a> ".$article[0]['date'] ); ?></h1>
			<?php echo $article[0]['resume']; ?></section>

			<section>
					<?php 

						  if ( empty($commentaire) ) echo "<p> Il n'y a pas de commentaire associer à cet article</p>" ;
						  else{

						  		echo $commentaire[0]['pseudonyme']." ".$commentaire[0]['dateCommentaire'];
						  		echo "<p>".$commentaire[0]['commentaire']."</p>";
						  }
					?>
					
			</section>
		</article>

		<footer>
			Site réalisé par : Florian Coindet et Xavier Sottiaux
		</footer>

	</body>
</html>