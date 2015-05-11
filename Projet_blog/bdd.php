<?php

function Connect_db(){

      $host="127.0.0.1"; // ou sql.hebergeur.com
      //http://iutdoua-webetu.univ-lyon1.fr/phpMyAdmin/
      $user="root";      // ou login
      $password="root";      // ou xxxxxx
      $dbname="BEER";
  
  try {
       
       $bdd=new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8',$user,$password);

      }catch (Exception $e){

       die('Erreur : '.$e->getMessage());

      }

      return $bdd ;
 }

?>