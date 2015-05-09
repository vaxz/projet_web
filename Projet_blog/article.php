<?php session_start() ?>
	<?php

		if( empty($_GET['id']) OR !is_numeric($_GET['id']) OR $_GET['id']<1 ) header('Location: erreur.php');
		else{

					$valeur=$_GET['id'];

					include_once("bdd.php");

					$bdd=Connect_db(); //connexion à la BDD

					if( !empty($_POST['commentaire']) ){

 							$query=$bdd->prepare('INSERT INTO Commentaire VALUES (?, ?, CURRENT_TIME(), ?) ');
 							$query->execute( array($_SESSION['IDUtilisateur'],$valeur, $_POST['commentaire']) );

 							$_POST['commentaire']="";

					}					

 					$query=$bdd->prepare('SELECT T1.Titre, T1.DateCreation, T1.URL, T1.Resume, T2.Commentaire,
 												 T2.DateCommentaire, T3.Pseudonyme
 						 				  FROM Article AS T1
 						 			 	  INNER JOIN Commentaire AS T2
 						 			 	  ON T1.IDArticle=T2.IDArticle
 						 			 	  INNER JOIN Utilisateur AS T3
 						 			  	  ON T2.IDUtilisateur=T3.IDUtilisateur
 						  			  	  WHERE T1.IDArticle=?
 						  			  	  ORDER BY T2.DateCommentaire DESC');
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

 					if ( !isset($article) ) header('Location: erreur.php');
	?>
	<!DOCTYPE HTML>
	<html>

	<head>
		<meta name="viewport" content="width=device-width" charset="utf-8"/>
		<link rel="stylesheet" type="text/css" media="screen and (min-width:750px)" href="articles/assets/style_articles.css" />
		<link rel="stylesheet" type="text/css" media="screen and (max-width:750px)" href="articles/assets/style_articles750.css" />
		<title> <?php echo ($article[0]['titre']) ?></title>
	</head>

		<?php include("element_principal.php"); ?>

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
		?>

		<div>
			<form action=# method="post">
				<h1>Commentaire</h1>
				<?php

						for ($i=0; $i<count($article); $i++) {
							echo (
								  "<section>".$article[$i]['pseudonyme']." Date : ".$article[$i]['dateCommentaire']."<p>".$article[$i]['commentaire'].
							  	"</p></section>"
							  	);
						}
					}
				?>
				<textarea placeholder="Votre commentaire" name="commentaire"></textarea>
				<button>Valider</button>
			</form>
		</div>

		<footer>
			Site réalisé par : Florian Coindet et Xavier Sottiaux
		</footer>
	</body>
</html>

