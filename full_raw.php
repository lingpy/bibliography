<?php
if(isset($_GET['key'])){
  $dsn = "sqlite:evobib.sqlite3";
  $conn = new PDO ($dsn);
  $key = $_GET['key'];
  $abfrage = $conn->query('select bibtex from bibliography where key like "'.$key.'";');
  $result = $abfrage->fetch();
  echo $result['bibtex'];
}
else if(isset($_POST['key'])){
  $dsn = "sqlite:evobib.sqlite3";
  $conn = new PDO ($dsn);
  $key = $_GET['key'];
  $abfrage = $conn->query('select bibtex from bibliography where key like "'.$key.'";');
  $result = $abfrage->fetch();
  echo $result['bibtex'];
}
else{
  echo 'SELECT A KEY...';
}
?>
