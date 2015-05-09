<?php
	
	/*
	utiliser par index.php, article#.php
	*/

	include_once("bdd.php");

	$bdd=Connect_db(); //connexion à la BDD

 	$query=$bdd->prepare('SELECT T1.IDArticle, T1.Titre, T1.DateCreation, T1.URL, T1.Resume, T2.Commentaire, T2.DateCommentaire, T3.Pseudonyme
 						  FROM Article AS T1
 						  INNER JOIN Commentaire AS T2
 						  ON T1.IDArticle=T2.IDArticle
                          INNER JOIN Utilisateur AS T3
                          ON T3.IDUtilisateur=T2.IDUtilisateur
 						  ORDER BY T1.DateCreation DESC, T2.DateCommentaire DESC');

 	$query->execute();

 	while($data = $query->fetch()){
 		$article[]=array(
 						'id' => $data['IDArticle'],
						'titre' => $data['Titre'],
						'date' => $data['DateCreation'],
						'url' => $data['URL'],
						'resume' => $data['Resume'],
						'commentaire' => $data['Commentaire'],
						'dateCommentaire' => $data['DateCommentaire'],
						'pseudonyme' => $data['Pseudonyme']
						);
 	}
 	$query->closeCursor();

 ?>


