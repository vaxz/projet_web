<?php session_start() ?>
	<?php

		if( empty($_GET['id']) OR !is_numeric($_GET['id']) OR $_GET['id']<1 ) header('Location: erreur.php');
		else{

					$valeur=$_GET['id'];

					require_once("bdd.php");

					$bdd=Connect_db(); //connexion à la BDD

					if( !empty($_POST['commentaire']) ){

 							$query0=$bdd->prepare('INSERT INTO Commentaire VALUES (?, ?, CURRENT_TIME(), ?) ');
 							$query0->execute( array($_SESSION['IDUtilisateur'],$valeur, $_POST['commentaire']) );

 							$_POST['commentaire']="";

					}					

 					$query1=$bdd->prepare('SELECT T1.Titre, T1.DateCreation, T1.URLArticle, T1.URLImage
 						 				  FROM Article AS T1
 						 			 	  WHERE T1.IDArticle=?');
 					$query1->execute( array($valeur) );
 					if ( ( $data1 = $query1->fetch() ) != NULL ){

 						$article[]=array(
								'titre' => $data1['Titre'],
								'date' => $data1['DateCreation'],
								'url' => $data1['URLArticle'],
								'urlImage' => $data1['URLImage']
								);
 					}

 					if ( !isset($article) ) header('Location: erreur.php');

 					$query2=$bdd->prepare('SELECT T1.Commentaire, T1.DateCommentaire, T2.Pseudonyme
 						 				  FROM Commentaire AS T1
 						 			 	  INNER JOIN Utilisateur AS T2
 						 			  	  ON T1.IDUtilisateur=T2.IDUtilisateur
 						  			  	  WHERE T1.IDArticle=?
 						  			  	  ORDER BY T1.DateCommentaire DESC');
 					$query2->execute( array($valeur) );
 					while($data2 = $query2->fetch()){

 						$commentaire[]=array(
								'commentaire' => $data2['Commentaire'],
								'dateCommentaire' => $data2['DateCommentaire'],
								'pseudonyme' => $data2['Pseudonyme']
								);
 					}
	?>
	<!DOCTYPE HTML>
	<html>

	<head>
		<meta name="viewport" content="width=device-width" charset="utf-8"/>
		<link rel="stylesheet" type="text/css" media="screen and (min-width:750px)" href="articles/assets/style_articles.css" />
		<link rel="stylesheet" type="text/css" media="screen and (max-width:750px)" href="articles/assets/style_articles750.css" />
		<title> <?php echo ($article[0]['titre']) ?></title>
	</head>

		<?php require_once("element_principal.php"); ?>

		<?php
			
 				$fichier=fopen($article[0]['url'],'r');

 				if ( $fichier!=NULL ){

 					if ($valeur == 1) {

 						$ligne=fgets($fichier);
						echo $ligne;
						while($ligne){
							$ligne=fgets($fichier);
							echo $ligne;
						}

					}else{

						echo "<article><h1>".$article[0]['titre']."</h1>";

						$ligne=fgets($fichier);
						echo  "<div>".$ligne;
						while($ligne){
							$ligne=fgets($fichier);
							echo $ligne;
						}
						echo  "</div>";
						echo "<aside><img src=".$article[0]['urlImage']." alt=Image : ".$article[0]['titre']."></aside>";
						echo "</article>";
					}

 				}else echo "<article> Le fichier demandé n'a pas pas été trouvé à l'adresse correspondante".$article[0]['url']."</article>";

 				fclose($fichier);
		?>

		<div>
			<form action=# method="post">
				<h1>Commentaire</h1>
				<?php

						if( empty($commentaire) ){

							echo (
									 "<section><p>
									  Il n'y a pas de commentaire associé à cet article 
								  	 </p></section>"
								 );

						}else{

							for ($i=0; $i<count($commentaire); $i++) {
								echo (
									  "<section>".$commentaire[$i]['pseudonyme']." Date : ".$commentaire[$i]['dateCommentaire']."<p>"
									  .$commentaire[$i]['commentaire'].
								  	"</p></section>"
								  	);
							}
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

