<?php
	
	/*
	utiliser par index.php, article#.php
	*/

	include("bdd.php");

	$bdd=Connect_db(); //connexion à la BDD

 	$query=$bdd->prepare('SELECT T1.Titre, T1.DateCreation, T1.URL, T1.Resume, T2.Commentaire, T2.DateCommentaire, T3.Pseudonyme
 						  FROM Article AS T1
 						  INNER JOIN Commentaire AS T2
 						  ON T1.IDArticle=T2.IDArticle
                          INNER JOIN Utilisateur AS T3
                          ON T3.IDUtilisateur=T2.IDUtilisateur
 						  ORDER BY T1.DateCreation DESC, T2.DateCommentaire DESC');

 	$query->execute();

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
 	$query->closeCursor();

 	/*echo(
 			"<table>
 			<tr>
			<td>".$article[0]['titre']."</td>
			<td>".$article[0]['date']."</td>
			<td>".$article[0]['url']."</td>
			<td>".$article[0]['resume']."</td>
			<td>".$article[0]['commentaire']."</td>
			<td>".$article[0]['dateCommentaire']."</td>
			<td>".$article[0]['pseudonyme']."</td>
			</tr>
			</table>"
		);
	*/

 	/*
 	bdd=Connect_db(); //connexion à la BDD
 	$query=$bdd->prepare('SELECT NAME_PIZZA, PRICE_PIZZA, LABEL_INGREDIENT
 						  FROM pizzas_ingredients AS T1
 						  INNER JOIN pizzas AS T2
 						  ON T1.ID_PIZZA=T2.ID_PIZZA
 						  INNER JOIN ingredients AS T3
 						  ON T1.ID_INGREDIENT=T3.ID_INGREDIENT
 						  ORDER BY NAME_PIZZA asc');

 	$query->execute();

 	$case_tab=0;


 	while($data = $query->fetch()) { 
 			
 			if ($case_tab==0){

 				$Pizzas[]=array(
							'pizza' => $data['NAME_PIZZA'],
							'ingredient' => $data['LABEL_INGREDIENT'],
							'prix' => $data['PRICE_PIZZA']
							);
 				$case_tab++;

 			}else if ($data['NAME_PIZZA']==$Pizzas[($case_tab-1)]['pizza']) {

 				$Pizzas[($case_tab-1)]['ingredient']=$Pizzas[($case_tab-1)]['ingredient'].", ".$data['LABEL_INGREDIENT'];

 			}else{

 				$Pizzas[]=array(
							'pizza' => $data['NAME_PIZZA'],
							'ingredient' => $data['LABEL_INGREDIENT'],
							'prix' => $data['PRICE_PIZZA']
							);

 				$case_tab++;
 			}
 	}

 	$query->closeCursor();
 	*/

 	?>


