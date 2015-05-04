<?php

			if( !empty($_GET['id']) ){

				$valeur=$_GET['id'];

				include("bdd.php");
				$bdd=Connect_db(); //connexion à la BDD

 				$query=$bdd->prepare('SELECT T1.Titre, T1.DateCreation, T1.URL, T1.Resume
 						 			  FROM Article AS T1
 						  			  WHERE T1.IDArticle=?
 						  			  ORDER BY T1.Titre DESC');
 				//requete permettant de récupérer les infos sur un article, commentaire, Pseudonyme

 				$query->execute( array($valeur) );

 				while($data = $query->fetch()){
 					$article[]=array(
							'titre' => $data['Titre'],
							'date' => $data['DateCreation'],
							'url' => $data['URL'],
							'resume' => $data['Resume']
							);
 				}
 				$query->closeCursor();

 				echo $article[0]['url'];

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

			}

?>