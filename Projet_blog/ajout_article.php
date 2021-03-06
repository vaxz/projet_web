﻿<?php session_start() ?>

<!DOCTYPE HTML>
<html>

	<head>
		<meta name="viewport" content="width=device-width" charset="utf-8"/>
		<link rel="stylesheet" type="text/css" media="screen and (min-width:750px)" href="assets/style_ajout_article.css" />
		<link rel="stylesheet" type="text/css" media="screen and (max-width:750px)" href="assets/style_ajout_article750.css" />
		<title> BEEEER !!! </title>
	</head>

	<body>

		<?php require_once("element_principal.php"); ?>

		<article>

			<?php

					if ( !empty($_POST['valider']) ){

						if( empty($_POST['titre']) ){

							echo ( "<section>
									Vous avez oublier de mettre un titre
									</section>"
								 );


						}else if ( empty($_POST['article']) ){

							echo ( "<section>
									Vous n'avez pas écrit d'article
									</section>"
								 );


						}else if ( empty($_POST['resume']) ){

							echo ( "<section>
									Vous n'avez pas écrit de resumé
									</section>"
								 );

						}else if ( $_FILES['fichier']['error'] != 0  ) {

							echo ( "<section>
									Vous n'avez pas mis d'illustration
									</section>"
								 );

						}else{

								if ( $_FILES['fichier']['size'] <= 1048576 ) {  // 1Mo
		   							
		   								$infosfichier = pathinfo($_FILES['fichier']['name']);
		   								$ext_upload = $infosfichier['extension'];
		   								$ext_autorisees = array('jpg', 'jpeg', 'gif', 'png');
		   		
		   							if (in_array($ext_upload, $ext_autorisees)) {
		    								
		    								require_once("bdd.php");
											$bdd=Connect_db(); //connexion à la BDD

											$query0=$bdd->prepare('SELECT COUNT(T1.IDArticle)
			 									 				   FROM Article AS T1
		 										 			 	   ');
											$query0->execute();
											$data0 = $query0->fetch();									
											$urlImage="articles/assets/image".( $data0[0]+1 );
											$urlArticle="articles/article".( $data0[0]+1 );									
											$query0->closeCursor();

											if ( move_uploaded_file( $_FILES['fichier']['tmp_name'], 
																	'articles/assets/'.basename($_FILES['fichier']['name']) ) AND 
												 rename ( 'articles/assets/'.basename($_FILES['fichier']['name']), $urlImage ) ){

			    								$fichierArticle=fopen($urlArticle,'w+');

								 				if ( $fichierArticle!=NULL ) {

								 					fputs( $fichierArticle, $_POST['article'] );


								 					$query1=$bdd->prepare('INSERT INTO Article (Titre, DateCreation, URLArticle, URLImage, Resume, IDUtilisateur)
																	  	   VALUES (?, CURRENT_TIME(), ?, ?, ?, ?)' 
																	  	   );
													$query1->execute( array( $_POST['titre'], $urlArticle, $urlImage, $_POST['resume'], $_SESSION['IDUtilisateur'] ) );

													$query2=$bdd->prepare('SELECT T1.IDArticle
													 						FROM Article AS T1
													 						WHERE T1.Titre=?
																			');
												 	$query2->execute( array($_POST['titre']) );
												 	$data2 = $query2->fetch();
												 	$lien[]=array(	'idArticle' => $data2['IDArticle'] );
												 	$query2->closeCursor();

												 	echo ( "<section>
															Vous pouvez accéder à votre
															<a href=article.php?id=".$lien[0]['idArticle']."> article </a>
															</section>"
								 	 		  			 );

								 				}else{

								 					echo ( "<section>
															La création du fichier article a échoué
															</section>"
								 	 		  			 );
								 				}

								 				fclose($fichierArticle);

											}else{

												echo ( "<section>
														L'envoi du fichier image a échoué
														</section>"
								 	 		  		);

											}    								
		   							
		   							}else {

		   								echo ( "<section>
												L'extension de fichier n'est pas autorisé.
												</section>"
								 	 		  );
		   							}

		   						}else{

		   							echo ( "<section>
											La taille du votre fichier est supérieur à 1 MO.
											</section>"
								 	 	 );
		   						}
							}
					}else{

						echo ( "<section>
							   Si vous souhaitez ajouter vos articles, n'hésitez pas.
							   </section>"
							  );

					}

			?>			

		  <form action=# method="post" enctype="multipart/form-data">
		  	<input placeholder="Titre de votre article" name="titre">
		  	<textarea rows="40" placeholder="Rédiger votre article" name="article"></textarea>
		  	<textarea rows="40" placeholder="Rédiger votre resume" name="resume"></textarea>
		  	<p>Ajouter votre illustration (Taille max 1 MO, extensions autorisées : jpg, jpeg, gif, png )
		  		<input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
		  		<input type="file" name="fichier" >
		  	</p>		  	
			<input type="submit" name="valider" value="Valider">
		  </form>
		</article>

		<footer>
			Site réalisé par : Florian Coindet et Xavier Sottiaux
		</footer>

	</body>
</html>