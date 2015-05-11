		<header>
				<nav>
					<h1> BEEEER !!!</h1>
					<ul><li><a href="index.php">Accueil</a></li>
						<li><a href="liste_articles.php">Articles</a></li>
						<?php if( !empty($_SESSION['statut'] )){
							
							if( $_SESSION['statut']=="webmaster" ) echo ("<li><a href=\"ajout_article.php\">Ajouter un article</a></li>");
						}?>
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

				if (!empty($_POST['deco'])){

					session_destroy();
					header("Refresh:0");

				}

				if( empty($_SESSION['pseudonyme'])){

					if( !empty($_POST['ID']) && !empty($_POST['MDP']) ){
						
						include_once("bdd.php");

						$bdd=Connect_db(); //connexion à la BDD

 						$query0=$bdd->prepare('SELECT T1.IDUtilisateur, T1.Pseudonyme, T1.Mot_passe, T1.Webmaster, T1.DateCreationUtilisateur
 						  					  FROM Utilisateur AS T1
 						  					  WHERE lower(T1.Pseudonyme)=lower(?)
 						  					  AND lower(T1.Mot_passe)=lower(?)'
 						  					  );

 						$query1=$bdd->prepare('SELECT COUNT(T2.Commentaire)
 						  					  FROM Utilisateur AS T1
 						  					  INNER JOIN Commentaire AS T2
 						  					  ON T1.IDUtilisateur=T2.IDUtilisateur
 						  					  WHERE lower(T1.Pseudonyme)=lower(?)'
 						  					  );

 						$query2=$bdd->prepare('SELECT COUNT(T2.IDArticle)
 						  					  FROM Utilisateur AS T1
 						  					  INNER JOIN Article AS T2
 						  					  ON T1.IDUtilisateur=T2.IDUtilisateur
 						  					  WHERE lower(T1.Pseudonyme)=lower(?)'
 						  					  );

 						$query0->execute(array($_POST['ID'],$_POST['MDP']));
 						$data0 = $query0->fetch();

 						if( empty($data0['Pseudonyme']) && empty($data0['Mot_passe']) ){
 							echo (	
 									'<div> 
									L\'identifiant ou le mot de passe est incorrect								
									</div>'
								);
 							header("Refresh:3");

 						}else{

 							$_SESSION['IDUtilisateur']= $data0['IDUtilisateur'];
 							$_SESSION['pseudonyme']= $data0['Pseudonyme'];
							if ( $data0['Webmaster']==1 ) $_SESSION['statut']="webmaster";
							else $_SESSION['statut']="utilisateur";
							$_SESSION['date']=$data0['DateCreationUtilisateur'];

							$query1->execute(array($_POST['ID']));
							$data1 = $query1->fetch();
							$_SESSION['nb_commentaire']=$data1[0];

							$query2->execute(array($_POST['ID']));
							$data2 = $query2->fetch();
							$_SESSION['nb_article']=$data2[0];

							$query1->closeCursor();
 							$query2->closeCursor();
 							
 							header("Refresh:0");

 						}
 						$query0->closeCursor();
 								


					}else{
						
						echo(	'<div>
							<form action=# method="post" >
							<h3>Se connecter</h3>
							<input type="text" placeholder="Identifiant" name="ID">
							<input type="password" placeholder="Mot de passe" name="MDP">
							<button>Connexion</button><a href="creation_compte.php"><button type="button">S\'enregister</button></a>
							</form>
							</div>'
						);
					}

				}else{

					echo(
									'<div>
									<form action=# method="post" >
									<h3>Se déconnecter</h3>
									<input type="submit" name="deco" value="Déconnexion">
									</form>
									</div>

									<div>
									<ul><li> Nom = '.$_SESSION['pseudonyme'].'</li>
									 <li> Enregistré depuis = '.$_SESSION['date'].'</li>
									 <li> En tant que = '.$_SESSION['statut'].'</li>
									 <li> Nombre commentaire = '.$_SESSION['nb_commentaire'].'</li>
									 <li> Nombre article = '.$_SESSION['nb_article'].'</li>
									 </ul>
									</div>'
								);
				}
					
			?>