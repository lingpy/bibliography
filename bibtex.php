<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="description" content="EvoBib">
<meta name="keywords" content="homepage, linguistics, historical linguistics, BibTeX">
<meta NAME="resource-type" CONTENT="document,chinese,chinese linguistics,linguistics,historical linguistics">
<meta name="distribution" CONTENT="global">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

<link rel="stylesheet" type="text/css" href="css/main.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/handheld.css" media="screen and (max-device-width: 720px)" />
<link rel="icon" href="figures/favicon.png" type="image/png">  
<script src="http://code.jquery.com/jquery-latest.js"></script>

<title>EvoBib</title>
</head>
<body id="home">
<div id="wrapper">
  <div id="header">
  <a href="http://www.lingulist.de/evobib"><img id="logo" src="figures/evobib2.jpg" height="60px" alt="logo" title="EvoBib" /></a>
  <div id="mainnav">
    <ul id="nav">
    <!--<li>
      <a href="main.php">Home</a>
    </li>-->
    <li>
      <a href="about.php">About</a>
    </li>
    <li>
      <a href="evobib.php">Query</a>
    </li>
    <!--<li>
	<a href="http://lingulist.de">Back2Main</a>
    </li>-->
  </ul>
 </div><!--end mainnav-->
 </div><!-- end header -->  
 <div id="subnav">
    <h2> <a href="evobib.php">Query</a></h2>



 </div>
 <div id="contentwrapper" class="clearfix">
     <div id="content">    
	 <!-- SIDEBAR query -->
<?php

if(isset($_POST['key'])){
  $dsn = "sqlite:evobib.sqlite3";
  $conn = new PDO ($dsn);
  $key = $_POST['key'];
  if(isset($_POST['abstract']) == False){
    $abfrage = $conn->query('select bibtex from bibliography where key like "'.$key.'";');
    $result = $abfrage->fetch();
    echo '<pre style="white-space:pre-wrap">'.$result['bibtex'].'</pre>';
  }
  else{
    $abfrage = $conn->query('select abstract from bibliography where key like "'.$key.'";');
    $result = $abfrage->fetch();
    echo '<table align=left width="80%"><tr><td>'.$result['abstract'].'</td></tr></table>';
  }
}
else if(isset($_GET['key'])){
  $dsn = "sqlite:evobib.sqlite3";
  $conn = new PDO ($dsn);
  $key = $_GET['key'];
  $abfrage = $conn->query('select bibtex from bibliography where key like "'.$key.'";');
  $result = $abfrage->fetch();
  echo '<pre style="white-space:pre-wrap">'.$result['bibtex'].'</pre>';
}
?>


 </div>
 </div>
 <div id="footer" style="display:flex">
<div>
<a href="http://www.hhu.de/">
<img width="120px" src="http://upload.wikimedia.org/wikipedia/commons/0/07/Logo_HHU_DUS.svg" alt="HHUD" /></a>
 </div>
 <div>
<a href="http://www.bmbf.de/"><img width="120px" src="http://upload.wikimedia.org/wikipedia/commons/5/5c/BMBF_Logo.svg" alt="BMBF" /></a>
 </div>
<div>
 <p>Last updated on Jul. 25, 2018, 08:20 CET</p>
 <p>
      <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nc/4.0/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/InteractiveResource" property="dct:title" rel="dct:type">This website</span> by <span xmlns:cc="http://creativecommons.org/ns#" property="cc:attributionName">Johann-Mattis List</span> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/">Creative Commons Attribution-NonCommercial 4.0 International License</a>.
      </p>
</div>
<div>
<a href="http://erc.europa.eu/"><img width="80px" src="http://quanthistling.info/theme/qhl/images/logo_erc.png" alt="ERC" /></a>


</div>
<div>
<a href="http://www.uni-marburg.de/"><img width="120px" src="http://upload.wikimedia.org/wikipedia/commons/9/9c/Uni_Marburg_Logo.svg?uselang=de" alt="PUD" /></a>
</div>
 </div><!-- end footer -->
</div><!-- end wrapper-->
</body>
</html>
