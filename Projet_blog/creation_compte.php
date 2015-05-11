<?php session_start() ?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta name="viewport" content="width=device-width" charset="utf-8"/>
		<link rel="stylesheet" type="text/css" media="screen and (min-width:750px)" href="assets/style_creation.css" />
		<link rel="stylesheet" type="text/css" media="screen and (max-width:750px)" href="assets/style_creation750.css" />
		<title> BEEEER !!! </title>
	</head>

	<body>		
		<?php require_once("element_principal.php"); ?>
		
		<div class="content">
			<h2>Création de compte</h2>
				<?php
					if(empty($_SESSION['pseudonyme'])) {
						if(empty($_POST['creation'])) {
							echo('<form action="#" method="post">
									<input type="hidden" name="creation" value="1"/>
									<p>Identifiant de longueur comprise entre 1 et 20 caractères</p>
									<input type="text" name="pseudo" placeholder="Identifiant" pattern=".{1,20}" required/>
									<p>Mot de passe de longueur comprise entre 5 et 20 caractères</p>
									<input type="password" name="mdp" placeholder="Mot de passe" pattern=".{5,20}" required/>
									<button>Soumettre</button>
									</form>');
						} else {
							require_once("bdd.php");
							$db = Connect_db();
							$query = $db -> prepare('SELECT count(Pseudonyme) FROM Utilisateur WHERE Utilisateur.Pseudonyme=?;');
							$query -> execute(array($_POST['pseudo']));
							$data = $query -> fetch();
							if($data[0] >= 1) {
								echo('<p>Identifiant déjà utilisé, veuillez en choisir un autre !</p>
										<form action="#" method="post">
										<input type="hidden" name="creation" value="1"/>
										<input type="text" name="pseudo" placeholder="Identifiant" required"/>
										<input type="password" name="mdp" placeholder="Mot de passe" required/>
										<button>Soumettre</button>
										</form>');
							}
							else {
								$query_i = $db -> prepare('INSERT INTO Utilisateur(Pseudonyme,Mot_passe,Webmaster) VALUES(?,?,0);');
								$query_i -> execute(array($_POST['pseudo'],$_POST['mdp']));
								$query_g = $db -> prepare('SELECT * FROM Utilisateur WHERE Pseudonyme=?;');
								$query_g -> execute(array($_POST['pseudo']));
								$data_g = $query_g -> fetch();

								$_SESSION['IDUtilisateur']= $data_g['IDUtilisateur'];
	 							$_SESSION['pseudonyme']= $data_g['Pseudonyme'];
								if ( $data_g['Webmaster']==1 ) $_SESSION['statut']="webmaster";
								else $_SESSION['statut']="utilisateur";
								$_SESSION['date']=$data_g['DateCreationUtilisateur'];

								$query1=$db->prepare('SELECT COUNT(T2.Commentaire)
 						  					  FROM Utilisateur AS T1
 						  					  INNER JOIN Commentaire AS T2
 						  					  ON T1.IDUtilisateur=T2.IDUtilisateur
 						  					  WHERE lower(T1.Pseudonyme)=lower(?)'
 						  					  );

 								$query2=$db->prepare('SELECT COUNT(T2.IDArticle)
 						  					  FROM Utilisateur AS T1
 						  					  INNER JOIN Article AS T2
 						  					  ON T1.IDUtilisateur=T2.IDUtilisateur
 						  					  WHERE lower(T1.Pseudonyme)=lower(?)'
 						  					  );

 								$query1->execute(array($_POST['pseudo']));
								$data1 = $query1->fetch();
								$_SESSION['nb_commentaire']=$data1[0];

								$query2->execute(array($_POST['pseudo']));
								$data2 = $query2->fetch();
								$_SESSION['nb_article']=$data2[0];

								$query1 -> closeCursor();
								$query2 -> closeCursor();
								$query_g -> closeCursor();
								$query_i -> closeCursor();

								echo('<p>Création réussie, connexion en tant que : '.$_POST['pseudo'].'</p>');
								header('Refresh:3;index.php');
								/*header('Location:index.php');*/
							}
							$query -> closeCursor();
						}
					} else {
						echo('<p>Pour créer un compte, il faut d\'abord être déconnecté ! </p>');
					}
				?>
		</div>


		<footer>
			Site réalisé par : Florian Coindet et Xavier Sottiaux
		</footer>
	</body>
</html>