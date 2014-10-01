<html><head><meta http-equiv="content-type" content="text/html; charset=utf-8"></head><body>
<?php
if(isset($_GET['key'])){
  $dsn = "sqlite:evobib.sqlite3";
  $conn = new PDO ($dsn);
  $key = $_GET['key'];
  $abfrage = $conn->query('select bibtex from bibliography where key like "'.$key.'";');
  $result = $abfrage->fetch();
  echo '<pre id="bibtex" style="white-space:pre-wrap">'.$result['bibtex'].'</pre>';
}
else if(isset($_POST['key'])){
  $dsn = "sqlite:evobib.sqlite3";
  $conn = new PDO ($dsn);
  $key = $_GET['key'];
  $abfrage = $conn->query('select bibtex from bibliography where key like "'.$key.'";');
  $result = $abfrage->fetch();
  echo '<pre id="bibtex" style="white-space:pre-wrap">'.$result['bibtex'].'</pre>';
}
else{
  echo 'SELECT A KEY...';
}
?>
</body></html>
