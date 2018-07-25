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
// function checks whether a string ends with another string
function EndsWith($FullStr, $EndStr)
{
  // Get the length of the end string
  $StrLen = strlen($EndStr);
  // Look at the end of FullStr for the substring the size of EndStr
  $FullStrEnd = substr($FullStr, strlen($FullStr) - $StrLen);
  // If it matches, it does end with EndStr
  return $FullStrEnd == $EndStr;
}

//connect the db
$dsn = "sqlite:evobib.sqlite3";
$conn = new PDO ($dsn);

//make the query
if(isset($_POST['content'])){

?>
<style>
  table td{padding:4px;}
  table th {padding: 4px;}
</style>
<table align=center width="100%" border=1 >
<tr>
<td colspan=4 align="center" width="50%">
<p><b>Select the fields you want to search</b></p>
<td width="35%" align="center">
<b>Select the Content</b>
</td>
<td width="15%" align="center">
<p><b>Submit</b></p>
</td>
</tr>
<tr>
<td  align="center">
<form action='evobib.php' method='post'>
<p>
<input type="checkbox" name="author" value="author" /> Author <br>
</p></td>
<td  align="center">
<p>
<input type="checkbox" name="year" value="year" /> Year <br>
</p></td><td  align="center">
<p>
<input type="checkbox" name="title" value="title" /> Title <br>
</p>
</td><td  align="center">
<p>
<input type="checkbox" name="fulltext" value="bibtex" /> Full Text <br>
</p>
</td>
<td width="35%" align="center">
<p>
<input type="text" name="content" width="35%" />
</p>
</td>
<td align=center width="15%">
<p>
<input type="submit" value="OK"/>
</p>
</td>
</form>
</tr>
</table>

<?php
  if(isset($_POST['author']) == False){
    $_POST['author'] = '';
  }
  if(isset($_POST['year']) == False){
    $_POST['year'] = '';
  }
  if(isset($_POST['title']) == False){
    $_POST['title'] = '';
  }
  if(isset($_POST['keywords']) == False){
    $_POST['keywords'] = '';
  }
  if(isset($_POST['bibtex']) == False){
    $_POST['bibtex'] = '';
  }




  $field_array = array($_POST['author'],$_POST['year'],$_POST['title'],$_POST['keywords'],$_POST['bibtex']);
  $contents = explode(' ',$_POST['content']);
  //array contains all the fields which shall be queried
  $fields = array();
  $query_string = '';
  //push every non-empty field into $fields
  foreach($field_array as &$field){
    if($field != ''){
      array_push($fields,$field);
    }
  }
  $field_string = '';
  foreach($fields as &$field){
    if($field_string != ''){
      $field_string = $field_string.'||'.$field;
    }
    else{
      $field_string = $field_string.$field;
    }
  }
  //check the length of $fields
  if(count($fields) != 0){
    //echo "field == 1";
    $query_string = '';
    $field = $field_string;
    foreach($contents as &$value){
      if($value != ''){
        if($query_string == ''){

          $query_string = $query_string.'select * from bibliography where '.$field.' like "%'.$value.'%"';
        }
        else{
          $query_string = $query_string.' and '.$field.' like "%'.$value.'%"';
        }
      }}
        if($query_string != ''){
          $query_string = $query_string.' order by year desc,key;';}
      //echo $query_string;
  }
  else{
    $query_string = '';
    $field = 'bibtex';
    foreach($contents as &$value){
      if($value != ''){
        if($query_string == ''){
          $query_string = $query_string.'select * from bibliography where '.$field.' like "%'.$value.'%"';
        }
        else{
          $query_string = $query_string.' and '.$field.' like "%'.$value.'%"';
        }
      }}
        if($query_string != ''){
          $query_string = $query_string.' order by year desc,key;';}
      //echo $query_string;
  }
  // check for bad input
  if($query_string == ''){$query_string='select * from bibliography where title == "xxxxxxxx";';}
  $abfrage = $conn->query($query_string);
  $results = array();
  $next_result = $abfrage->fetch();
  $check = $next_result;
  //echo $check['author'];
  while($check['key'] != ''){
    $results[] = $next_result;
    $next_result = $abfrage->fetch();
    $check = $next_result;
  }
  if(count($results) == 0){
    echo '<p align="left"><font color=red> <b>No results for your query found.</b></font></p>';
  }
  else{
    include('print_bib.php');
  }
}
elseif(isset($_GET['key'])){

?>

<?php

$query_string = 'select * from bibliography where key = "'.$_GET['key'].'";';
$abfrage = $conn->query($query_string);
$results = array();
$next_result = $abfrage->fetch();
$check = $next_result;
//echo $check['author'];
while($check['key'] != ''){
$results[] = $next_result;
$next_result = $abfrage->fetch();
$check = $next_result;
}
if(count($results) == 0){
echo '<p align="center"><font color=red> <b>No results for your query found.</b></font></p>';
}
else{
  include('print_bib.php');
echo '</table>';

}
}

else {
?>
<table align=center border=1 width="100%">
<tr>
<td colspan=4 align="center" width="50%">
<p><b>Select the fields you want to search</b></p>
<td width="35%" align="center">
<b>Select the Content</b>
</td>
<td width="15%" align="center">
<p><b>Submit</b></p>
</td>
</tr>
<tr>
<td  align="center">
<form action='evobib.php' method='post'>
<p>
<input type="checkbox" name="author" value="author" /> Author <br>
</p></td>
<td  align="center">
<p>
<input type="checkbox" name="year" value="year" /> Year <br>
</p></td><td  align="center">
<p>
<input type="checkbox" name="title" value="title" /> Title <br>
</p>
</td><td  align="center">
<p>
<input type="checkbox" name="fulltext" value="bibtex" /> Full Text <br>
</p>
</td>
<td width="35%" align="center">
<p>
<input type="text" name="content" width="35%" />
</p>
</td>
<td align=center width="15%">
<p>
<input type="submit" value="OK"/>
</p>
</td>
</form>
</tr>
</table>
<p></p>
<?php
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
