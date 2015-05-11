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
				
					$liste=str_split( strtolower($_POST['recherche']) ); //conversion de la chaîne de caractère en tableau de caractères nommé "liste"
					$indice=0; //indice permettant de parcourir le tableau "tabmot" qui contiendra les mots issus de "liste"
					$temp='';  //initialisation de la variable temporaire permettant de stocker chaque caractère issu du tableau "liste"

					for($c=0; $c<count($liste) ;$c++){
					//parcours du tableau "liste"
					
						if( $liste[$c]!=" " AND $liste[$c]!="\n" ){
						//tant que le caractère courant issu du tableau "liste" n'est pas un espace, il est ajouté dans "temp"
					
							if(empty($temp)) $temp=$liste[$c];
							else $temp=$temp.$liste[$c];
					
						}else{
						//ajout du contenu de la variable "temp" dans "tabmot" et "temp" est purgée
							$tabmot[$indice]=$temp;
							$temp='';
							$indice++;
					
						}
					}

					$tabmot[$indice]=$temp;
					//ajout dernier contenu de la variable "temp" dans "tabmot"

					include ("bdd.php");
					$bdd=Connect_db(); //connexion à la BDD
					
					$query=$bdd->prepare('SELECT IDArticle, Titre, DateCreation
										  FROM Article 
										  WHERE lower(Titre) LIKE ? ');
					//requete permettant de vérifier si les mots contenus dans "tabmot" font partie de la table "mot-clefs" de la base de donnée
					//améliorer la requête avec une recherche par motif

					$init_tab=0;
				 	//varibale permettant de savoir si le tableau "resultat" est initialisé
				 	foreach($tabmot as $mot){
				 	//boucle permettant de parcourir "tabmot". Pour chaque mot contenu dans le tableau, la requête SQL est exécuté

				 		$query->execute(array('%'.$mot.'%'));

				 		while( $data = $query->fetch() ){

				 			if($init_tab==0){

				 				$resultat[]=array(
				 							'ID' => $data['IDArticle'],
											'titre' => $data['Titre'],
											'date' => $data['DateCreation']
											);
				 				$init_tab=1;

				 			}else{
				 			//si le tableau est initialisé, il faut éviter d'insérer des doublons dans le tableau "resultat"
				 				for( $i=0; $i<count($resultat) && $resultat[$i]['titre']!= $data['Titre']; $i++  );

				 				if( $i==count($resultat) ){

				 					$resultat[]=array(
				 										'ID' => $data['IDArticle'],
														'titre' => $data['Titre'],
														'date' => $data['DateCreation']
													);
				 				}
				 			}
				 		}
				 	}

				 	$query->closeCursor();

				 	if(empty($resultat)) echo "<section>Votre requête n'a pas abouti</section>";
				 	//vérifier si le tableau de resultat contient des valeurs et effectuer l'affichage adéquate.
				  	else{

				  		echo (
				  				"<section>Voici la liste des articles présents sur ce site correspondant à votre recherche.</section>
				  				<table>
				  				<tr><th>Nom de l'article</th><th>Date</th></tr>"
				  			 );

				  		for($i=0; $i<count($resultat);$i++){
				  			echo("	<tr><td><a href= article.php?id=".$resultat[$i]['ID'].">".$resultat[$i]['titre']."</a></td><td>".$resultat[$i]['date']."</td>
				  					</tr>"
								);
				  		}

				  		echo "</table>";


				  	}

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