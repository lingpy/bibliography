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
    // Hier müssen jetzt die verschiedenen Angaben für Titel usw. hin
echo '<span class="clear"></span>';
echo '<br>';
//echo '<p><b>The following titles match your query:</b> </p>';
echo '<table align=center width="100%" border="1" >';
echo '<tr><td width="15%"><b>Author/Editor</b></td><td width="5%"><b>Year</b></td><td width="35%"><b>Title</b></td><td width="30%"><b>Journal/Proceedings/Address</b></td><td width="10%" ><b>RefType</b></td><td width="5%"><b>URL/DOI</b></td></tr>';
foreach($results as &$value) {
// vordefinieren der verschiedenen strings für die angaben
if($value['year'] != ''){
$value['year'] = $value['year'];
}
else{
$value['year'] = 'no date ';
}
if($value['title'] != ''){
$value['title'] = $value['title'];
}
if($value['volume'] != '' and $value['number'] != ''){
$value['volume'] = 'Vol. '.$value['volume'];
}
elseif($value['volume'] != '' and $value['number'] == ''){
$value['volume'] = 'Vol. '.$value['volume'].', ';
}
if($value['number'] != ''){
$value['number'] = '('.$value['number'].'), ';
}
if($value['pages'] != ''){
$value['pages'] = 'pp. '.$value['pages'];
}
if($value['url'] != ''){
$value['url'] = '<a target="_blank" href="'.$value['url'].'">[URL]</a> ';
}
else{
$value['url'] = '<font color=white>.</font>';
}
//if($value['doi'] != ''){
//$value['doi'] = '<a target="_blank" href="'.$value['DOI'].'"[DOI]</a> ';
//}
if($value['note'] != ''){
$value['note'] = '('.$value['note'].'). ';
}
if($value['address'] != '' && $value['publisher'] != ''){
    $adpu = $value['address'].': '.$value['publisher'];
}
else if($value['address'] != '' && $value['publisher'] == ''){
    $adpu = $value['address'];
}
else{
    $adput = $value['publisher'];
}
if($value['publisher'] != ''){
$value['publisher'] = $value['publisher'].'. ';
}
if($value['address'] != ''){
$value['address'] = $value['address'].'. ';
}
if($value['howpublished'] != ''){
$value['howpublished'] = '<i>'.$value['howpublished'].'</i>';
}
else{
$value['howpublished'] = '<font color=white>-</font>';
}
if($value['school'] != ''){
$value['school'] = $value['school'].'. ';
}
if($value['booktitle'] != '' and $value['type'] == 'inproceedings' or $value['type'] == 'incollection'){
$value['booktitle'] = '<i>'.$value['booktitle'].'</i> ';
}
elseif($value['booktitle'] != '' and $value['type'] == 'book'){
$value['booktitle'] = $value['booktitle'];
}
if($value['journal'] != ''){
$value['journal'] = '<i>'.$value['journal'].'</i>';
}
if($value['author'] != ''){
$author = explode(' and ',$value['author']);
if(count($author) == 1){
$value['author'] = preg_replace('#, (..).*#',', \1. ',$author[0]);
$value['author'] = preg_replace('#, ([A-Z]).*#',', \1. ',$value['author']);
}
elseif(count($author) == 2){
$author1 = preg_replace('#, (..).*#',', \1. ',$author[0]);
$author2 = preg_replace('#, (..).*#',', \1. ',$author[1]);
$author1 = preg_replace('#, ([A-Z]).*#',', \1. ',$author1);
$author2 = preg_replace('#, ([A-Z]).*#',', \1. ',$author2);
$value['author'] = $author1.'& '.$author2;
}
else{
$value['author'] = '';
//foreach($author as &$wert){
$author1 = preg_replace('#, (..).*#',', \1. ',$author[0]);
$author1 = preg_replace('#, ([A-Z]).*#',', \1. ',$author1);
$value['author'] = $author1.'et al. ';
}
}
if($value['editor'] != ''){
$editor = explode(' and ',$value['editor']);
if(count($editor) == 1){

$value['editor'] = preg_replace('#, (..).*#',', \1. (ed.)',$editor[0]);
$value['editor'] = preg_replace('#, ([A-Z]).*#',' \1. (ed.)',$value['editor']);
}
elseif(count($editor) == 2){
$editor1 = preg_replace('#, (..).*#',', \1. ',$editor[0]);
$editor2 = preg_replace('#, (..).*#',', \1. ',$editor[1]);
$editor1 = preg_replace('#, ([A-Z]).*#',', \1. ',$editor1);
$editor2 = preg_replace('#, ([A-Z]).*#',', \1. ',$editor2);
$value['editor'] = $editor1.'& '.$editor2.' (eds.)';
}
else{
$value['editor'] = '';
//foreach($author as &$wert){
$editor1 = preg_replace('#, (..).*#',', \1. ',$editor[0]); 
$editor1 = preg_replace('#, ([A-Z]).*#',', \1. ',$editor1);  
$value['editor'] = $editor1.'et al. (eds.)';

}
if($value['type'] == 'inproceedings' or $value['type'] == 'incollection'){
$value['editor'] = $value['editor'].': ';
}
else{
$value['editor'] = $value['editor'].' ';
}
}
if($value['author'] == '' and $value['editor'] == ''){
$value['author'] = '<b>unknown author</b>';
$value['editor'] = '<b>unknown editor</b>';
}
  

if($value['type'] == 'article'){
echo '<tr>';
echo '<td>'.$value['author'].'</td>';
echo '<td>'.$value['year'].'</td>';
echo '<td>'.$value['title'];
echo '<table><tr><td><form action="bibtex.php" method="post"> <input type="hidden" name="key" value="'.$value['key'].'" /> <input type="submit" value="BibTex" /></form>';
if($value['abstract'] != ''){
echo '</td><td><form action="bibtex.php" method="post"><input type="hidden" name="key" value="'.$value['key'].'"/><input type="hidden" value="abstract" name="abstract"/><input type="submit" value="Abstract"></form>';
}
echo '</td></tr></table></td>';
echo '<td><p>'.$value['journal'].'</p>';
echo '<p>'.$value['volume'].$value['number'].$value['pages'].'</p></td>';
echo '<td>'.$value['type'].' </td>';
echo '<td>'.$value['url'].'</td></tr>';
}
elseif($value['type'] == 'book'){
echo '<tr>';
echo '<td>'.$value['author'].$value['editor'].'</td>';
echo '<td>'.$value['year'].'</td>';
echo '<td>'.$value['title'];
echo '<table><tr><td><form action="bibtex.php" method="post"> <input type="hidden" name="key" value="'.$value['key'].'" /> <input type="submit" value="BibTex" /></form>';
if($value['abstract'] != ''){
echo '</td><td><form action="bibtex.php" method="post"><input type="hidden" name="key" value="'.$value['key'].'"/><input type="hidden" value="abstract" name="abstract"/><input type="submit" value="Abstract"></form>';
}
echo '</td></tr></table></td>';
echo '<td>'.$adpu.'</td>';
echo '<td>'.$value['type'].'</td>';
echo '<td>'.$value['url'].'</td></tr>';
}
elseif($value['type'] == 'incollection'){
echo '<tr>';
echo '<td>'.$value['author'].'</td>';
echo '<td>'.$value['year'].'</td>';
echo '<td>'.$value['title'];
echo '<table><tr><td><form action="bibtex.php" method="post"> <input type="hidden" name="key" value="'.$value['key'].'" /> <input type="submit" value="BibTex" /></form>';
if($value['abstract'] != ''){
echo '</td><td><form action="bibtex.php" method="post"><input type="hidden" name="key" value="'.$value['key'].'"/><input type="hidden" value="abstract" name="abstract"/><input type="submit" value="Abstract"></form>';
}
echo '</td></tr></table></td>';
echo '<td><p>'.$value['booktitle'].'</p><p>'.$value['pages'].'</p></td>';
echo '<td>'.$value['type'].'</td>';
echo '<td>'.$value['url'].'</td></tr>';
}
elseif($value['type'] == 'inproceedings'){
echo '<tr>';
echo '<td>'.$value['author'].'</td>';
echo '<td>'.$value['year'].'</td>';
echo '<td>'.$value['title'];
echo '<table><tr><td><form action="bibtex.php" method="post"> <input type="hidden" name="key" value="'.$value['key'].'" /> <input type="submit" value="BibTex" /></form>';
if($value['abstract'] != ''){
echo '</td><td><form action="bibtex.php" method="post"><input type="hidden" name="key" value="'.$value['key'].'"/><input type="hidden" value="abstract" name="abstract"/><input type="submit" value="Abstract"></form>';
}
echo '</td></tr></table></td>';
echo '<td>'.$value['booktitle'].' </td>';
echo '<td>'.$value['type'].'</td>';
echo '<td>'.$value['url'].'</td></tr>';
}
elseif($value['type'] == 'phdthesis'){
echo '<tr>';
echo '<td>'.$value['author'].'</td>';
echo '<td>'.$value['year'].'</td>';
echo '<td>'.$value['title'];
echo '<table><tr><td><form action="bibtex.php" method="post"> <input type="hidden" name="key" value="'.$value['key'].'" /> <input type="submit" value="BibTex" /></form>';
if($value['abstract'] != ''){
echo '</td><td><form action="bibtex.php" method="post"><input type="hidden" name="key" value="'.$value['key'].'"/><input type="hidden" value="abstract" name="abstract"/><input type="submit" value="Abstract"></form>';
}
echo '</td></tr></table></td>';
echo '<td><font color=white>.</font></td>';
echo '<td>'.$value['type'].'</td>';
echo '<td>'.$value['url'].'</td></tr>';
}
elseif($value['type'] == 'misc'){
    if($value['author']){
	$author=$value['author'];
    }
    else if($value['editor']){
	$author=$value['editor'];
    }
    else{
	$author="";
    }
echo '<tr>';
echo '<td>'.$author.'</td>';
echo '<td>'.$value['year'].'</td>';
echo '<td>'.$value['title'];
echo '<table><tr><td><form action="bibtex.php" method="post"> <input type="hidden" name="key" value="'.$value['key'].'" /> <input type="submit" value="BibTex" /></form>';
if($value['abstract'] != ''){
echo '</td><td><form action="bibtex.php" method="post"><input type="hidden" name="key" value="'.$value['key'].'"/><input type="hidden" value="abstract" name="abstract"/><input type="submit" value="Abstract"></form>';
}
echo '</td></tr></table></td>';
echo '<td>'.$value['howpublished'].'</td>';
echo '<td>'.$value['type'].'</td>';
echo '<td>'.$value['url'].' </td></tr>';
}
elseif($value['type'] == 'thesis'){
echo '<tr>';
echo '<td>'.$value['author'].'</td>';
echo '<td>'.$value['year'].'</td>';
echo '<td>'.$value['title'];
echo '<table><tr><td><form action="bibtex.php" method="post"> <input type="hidden" name="key" value="'.$value['key'].'" /> <input type="submit" value="BibTex" /></form>';
if($value['abstract'] != ''){
echo '</td><td><form action="bibtex.php" method="post"><input type="hidden" name="key" value="'.$value['key'].'"/><input type="hidden" value="abstract" name="abstract"/><input type="submit" value="Abstract"></form>';
}
echo '</td></tr></table></td>';
echo '<td>'.$value['howpublished'].'</td>';
echo '<td>'.$value['type'].'</td>';
echo '<td>'.$value['url'].' </td></tr>';
}
elseif($value['type'] == 'online'){
echo '<tr>';
echo '<td>'.$value['author'].'</td>';
echo '<td>'.$value['year'].'</td>';
echo '<td>'.$value['title'];
echo '<table><tr><td><form action="bibtex.php" method="post"> <input type="hidden" name="key" value="'.$value['key'].'" /> <input type="submit" value="BibTex" /></form>';
if($value['abstract'] != ''){
echo '</td><td><form action="bibtex.php" method="post"><input type="hidden" name="key" value="'.$value['key'].'"/><input type="hidden" value="abstract" name="abstract"/><input type="submit" value="Abstract"></form>';
}
echo '</td></tr></table></td>';
echo '<td>'.$value['howpublished'].'</td>';
echo '<td>'.$value['type'].'</td>';
echo '<td>'.$value['url'].' </td></tr>';
}
elseif($value['type'] == 'proceedings'){
echo '<tr>';
echo '<td>'.$value['author'].$value['editor'].'</td>';
echo '<td>'.$value['year'].'</td>';
echo '<td>'.$value['booktitle'];
echo '<table><tr><td><form action="bibtex.php" method="post"> <input type="hidden" name="key" value="'.$value['key'].'" /> <input type="submit" value="BibTex" /></form>';
if($value['abstract'] != ''){
echo '</td><td><form action="bibtex.php" method="post"><input type="hidden" name="key" value="'.$value['key'].'"/><input type="hidden" value="abstract" name="abstract"/><input type="submit" value="Abstract"></form>';
}
echo '</td></tr></table></td>';
echo '<td><font color=white>.</font></td>';
echo '<td>'.$value['type'].'</td>';
echo '<td>'.$value['url'].'</td></tr>';
}

else{
echo '<tr><td colspan=6><font color=red>Type '.$value['type'].' not yet implemented!</font></td></tr>';
}
}
echo '</table>';

}
}
elseif(isset($_GET['key'])){

?>

<!--<table align=center border=1 width="100%" >
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
</table>-->

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
// Hier müssen jetzt die verschiedenen Angaben für Titel usw. hin
//echo '<p align="center"> <b>The following titles match your query:</b> </p>';
echo '<table align=center width="100%" border="1" >';
echo '<tr><td width="15%"><b>Author/Editor</b></td><td width="5%"><b>Year</b></td><td width="35%"><b>Title</b></td><td width="30%"><b>Journal/Proceedings/Address</b></td><td width="10%" ><b>RefType</b></td><td width="5%"><b>URL/DOI</b></td></tr>';
foreach($results as &$value) {
// vordefinieren der verschiedenen strings für die angaben
if($value['year'] != ''){
$value['year'] = $value['year'];
}
else{
$value['year'] = 'no date ';
}
if($value['title'] != ''){
$value['title'] = $value['title'];
}
if($value['volume'] != '' and $value['number'] != ''){
$value['volume'] = 'Vol. '.$value['volume'];
}
elseif($value['volume'] != '' and $value['number'] == ''){
$value['volume'] = 'Vol. '.$value['volume'].', ';
}
if($value['number'] != ''){
$value['number'] = '('.$value['number'].'), ';
}
if($value['pages'] != ''){
$value['pages'] = 'pp. '.$value['pages'];
}
if($value['url'] != ''){
$value['url'] = '<a target="_blank" href="'.$value['url'].'">[URL]</a> ';
}
else{
$value['url'] = '<font color=white>.</font>';
}
//if($value['doi'] != ''){
//$value['doi'] = '<a target="_blank" href="'.$value['DOI'].'"[DOI]</a> ';
//}
if($value['note'] != ''){
$value['note'] = '('.$value['note'].'). ';
}
if($value['address'] != '' && $value['publisher'] != ''){
    $adpu = $value['address'].': '.$value['publisher'];
}
else if($value['address'] != '' && $value['publisher'] == ''){
    $adpu = $value['address'];
}
else{
    $adput = $value['publisher'];
}
if($value['address'] != ''){
$value['address'] = $value['address'].'. ';
}
if($value['publisher'] != ''){
$value['publisher'] = $value['publisher'].'. ';
}
if($value['howpublished'] != ''){
$value['howpublished'] = '<i>'.$value['howpublished'].'</i>';
}
else{
$value['howpublished'] = '<font color=white>-</font>';
}
if($value['school'] != ''){
$value['school'] = $value['school'].'. ';
}
if($value['booktitle'] != '' and $value['type'] == 'inproceedings' or $value['type'] == 'incollection'){
$value['booktitle'] = '<i>'.$value['booktitle'].'</i> ';
}
elseif($value['booktitle'] != '' and $value['type'] == 'book'){
$value['booktitle'] = $value['booktitle'];
}
if($value['journal'] != ''){
$value['journal'] = '<i>'.$value['journal'].'</i>';
}
if($value['author'] != ''){
$author = explode(' and ',$value['author']);
if(count($author) == 1){
$value['author'] = preg_replace('#, (..).*#',', \1. ',$author[0]);
$value['author'] = preg_replace('#, ([A-Z]).*#',', \1. ',$value['author']);
}
elseif(count($author) == 2){
$author1 = preg_replace('#, (..).*#',', \1. ',$author[0]);
$author2 = preg_replace('#, (..).*#',', \1. ',$author[1]);
$author1 = preg_replace('#, ([A-Z]).*#',', \1. ',$author1);
$author2 = preg_replace('#, ([A-Z]).*#',', \1. ',$author2);
$value['author'] = $author1.'& '.$author2;
}
else{
$value['author'] = '';
//foreach($author as &$wert){
$author1 = preg_replace('#, (..).*#',', \1. ',$author[0]);
$author1 = preg_replace('#, ([A-Z]).*#',', \1. ',$author1);
$value['author'] = $author1.'et al. ';
}
}
if($value['editor'] != ''){
$editor = explode(' and ',$value['editor']);
if(count($editor) == 1){

$value['editor'] = preg_replace('#, (..).*#',', \1. (ed.)',$editor[0]);
$value['editor'] = preg_replace('#, ([A-Z]).*#',' \1. (ed.)',$value['editor']);
}
elseif(count($editor) == 2){
$editor1 = preg_replace('#, (..).*#',', \1. ',$editor[0]);
$editor2 = preg_replace('#, (..).*#',', \1. ',$editor[1]);
$editor1 = preg_replace('#, ([A-Z]).*#',', \1. ',$editor1);
$editor2 = preg_replace('#, ([A-Z]).*#',', \1. ',$editor2);
$value['editor'] = $editor1.'& '.$editor2.' (eds.)';
}
else{
$value['editor'] = '';
//foreach($author as &$wert){
$editor1 = preg_replace('#, (..).*#',', \1. ',$editor[0]); 
$editor1 = preg_replace('#, ([A-Z]).*#',', \1. ',$editor1);  
$value['editor'] = $editor1.'et al. (eds.)';

}
if($value['type'] == 'inproceedings' or $value['type'] == 'incollection'){
$value['editor'] = $value['editor'].': ';
}
else{
$value['editor'] = $value['editor'].' ';
}
}
if($value['author'] == '' and $value['editor'] == ''){
$value['author'] = '<b>unknown author</b>';
$value['editor'] = '<b>unknown editor</b>';
}
  

if($value['type'] == 'article'){
echo '<tr>';
echo '<td>'.$value['author'].'</td>';
echo '<td>'.$value['year'].'</td>';
echo '<td>'.$value['title'];
echo '<table><tr><td><form action="bibtex.php" method="post"> <input type="hidden" name="key" value="'.$value['key'].'" /> <input type="submit" value="BibTex" /></form>';
if($value['abstract'] != ''){
echo '</td><td><form action="bibtex.php" method="post"><input type="hidden" name="key" value="'.$value['key'].'"/><input type="hidden" value="abstract" name="abstract"/><input type="submit" value="Abstract"></form>';
}
echo '</td></tr></table></td>';
echo '<td><p>'.$value['journal'].'</p>';
echo '<p>'.$value['volume'].$value['number'].$value['pages'].'</p></td>';
echo '<td>'.$value['type'].' </td>';
echo '<td>'.$value['url'].'</td></tr>';
}
elseif($value['type'] == 'book'){
echo '<tr>';
echo '<td>'.$value['author'].$value['editor'].'</td>';
echo '<td>'.$value['year'].'</td>';
echo '<td>'.$value['title'];
echo '<table><tr><td><form action="bibtex.php" method="post"> <input type="hidden" name="key" value="'.$value['key'].'" /> <input type="submit" value="BibTex" /></form>';
if($value['abstract'] != ''){
echo '</td><td><form action="bibtex.php" method="post"><input type="hidden" name="key" value="'.$value['key'].'"/><input type="hidden" value="abstract" name="abstract"/><input type="submit" value="Abstract"></form>';
}
echo '</td></tr></table></td>';
echo '<td>'.$adpu.'</td>';
echo '<td>'.$value['type'].'</td>';
echo '<td>'.$value['url'].'</td></tr>';
}
elseif($value['type'] == 'incollection'){
echo '<tr>';
echo '<td>'.$value['author'].'</td>';
echo '<td>'.$value['year'].'</td>';
echo '<td>'.$value['title'];
echo '<table><tr><td><form action="bibtex.php" method="post"> <input type="hidden" name="key" value="'.$value['key'].'" /> <input type="submit" value="BibTex" /></form>';
if($value['abstract'] != ''){
echo '</td><td><form action="bibtex.php" method="post"><input type="hidden" name="key" value="'.$value['key'].'"/><input type="hidden" value="abstract" name="abstract"/><input type="submit" value="Abstract"></form>';
}
echo '</td></tr></table></td>';
echo '<td><p>'.$value['booktitle'].'</p><p>'.$value['pages'].'</p></td>';
echo '<td>'.$value['type'].'</td>';
echo '<td>'.$value['url'].'</td></tr>';
}
elseif($value['type'] == 'inproceedings'){
echo '<tr>';
echo '<td>'.$value['author'].'</td>';
echo '<td>'.$value['year'].'</td>';
echo '<td>'.$value['title'];
echo '<table><tr><td><form action="bibtex.php" method="post"> <input type="hidden" name="key" value="'.$value['key'].'" /> <input type="submit" value="BibTex" /></form>';
if($value['abstract'] != ''){
echo '</td><td><form action="bibtex.php" method="post"><input type="hidden" name="key" value="'.$value['key'].'"/><input type="hidden" value="abstract" name="abstract"/><input type="submit" value="Abstract"></form>';
}
echo '</td></tr></table></td>';
echo '<td>'.$value['booktitle'].' </td>';
echo '<td>'.$value['type'].'</td>';
echo '<td>'.$value['url'].'</td></tr>';
}
elseif($value['type'] == 'phdthesis'){
echo '<tr>';
echo '<td>'.$value['author'].'</td>';
echo '<td>'.$value['year'].'</td>';
echo '<td>'.$value['title'];
echo '<table><tr><td><form action="bibtex.php" method="post"> <input type="hidden" name="key" value="'.$value['key'].'" /> <input type="submit" value="BibTex" /></form>';
if($value['abstract'] != ''){
echo '</td><td><form action="bibtex.php" method="post"><input type="hidden" name="key" value="'.$value['key'].'"/><input type="hidden" value="abstract" name="abstract"/><input type="submit" value="Abstract"></form>';
}
echo '</td></tr></table></td>';
echo '<td><font color=white>.</font></td>';
echo '<td>'.$value['type'].'</td>';
echo '<td>'.$value['url'].'</td></tr>';
}
elseif($value['type'] == 'misc'){
    if($value['author']){
	$author=$value['author'];
    }
    else if($value['editor']){
	$author=$value['editor'];
    }
    else{
	$author="";
    }
echo '<tr>';
echo '<td>'.$author.'</td>';
echo '<td>'.$value['year'].'</td>';
echo '<td>'.$value['title'];
echo '<table><tr><td><form action="bibtex.php" method="post"> <input type="hidden" name="key" value="'.$value['key'].'" /> <input type="submit" value="BibTex" /></form>';
if($value['abstract'] != ''){
echo '</td><td><form action="bibtex.php" method="post"><input type="hidden" name="key" value="'.$value['key'].'"/><input type="hidden" value="abstract" name="abstract"/><input type="submit" value="Abstract"></form>';
}
echo '</td></tr></table></td>';
echo '<td>'.$value['howpublished'].'</td>';
echo '<td>'.$value['type'].'</td>';
echo '<td>'.$value['url'].' </td></tr>';
}
elseif($value['type'] == 'proceedings'){
echo '<tr>';
echo '<td>'.$value['author'].$value['editor'].'</td>';
echo '<td>'.$value['year'].'</td>';
echo '<td>'.$value['booktitle'];
echo '<table><tr><td><form action="bibtex.php" method="post"> <input type="hidden" name="key" value="'.$value['key'].'" /> <input type="submit" value="BibTex" /></form>';
if($value['abstract'] != ''){
echo '</td><td><form action="bibtex.php" method="post"><input type="hidden" name="key" value="'.$value['key'].'"/><input type="hidden" value="abstract" name="abstract"/><input type="submit" value="Abstract"></form>';
}
echo '</td></tr></table></td>';
echo '<td><font color=white>.</font></td>';
echo '<td>'.$value['type'].'</td>';
echo '<td>'.$value['url'].'</td></tr>';
}

else{
echo '<tr><td colspan=6><font color=red>Type '.$value['type'].' not yet implemented!</font></td></tr>';
}
}
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
 <div id="footer">
<div class="footer_left">
<a href="http://www.hhu.de/"><img width="120px" src="http://upload.wikimedia.org/wikipedia/commons/0/07/Logo_HHU_DUS.svg" alt="HHUD" /></a>
 </div>
 <div class="footer_left">
<a href="http://www.bmbf.de/"><img width="120px" src="http://upload.wikimedia.org/wikipedia/commons/5/5c/BMBF_Logo.svg" alt="BMBF" /></a>
 </div>
<div class="footer_center">
 <p>Last updated on Oct. 01, 2014, 09:20 CET</p>
 <p>
This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/3.0/deed.en_US">Creative Commons Attribution-NonCommercial 3.0 Unported License</a>.</p><br>
<p>
   <a rel="license" href="http://creativecommons.org/licenses/by-nc/3.0/deed.en_US"><img
		alt="Creative Commons License" style="border-width:0;width:80px;"
		src="http://i.creativecommons.org/l/by-nc/3.0/88x31.png" /></a> </p>
</div>
<div class="footer_right">
<a href="http://erc.europa.eu/"><img width="80px" src="http://quanthistling.info/theme/qhl/images/logo_erc.png" alt="ERC" /></a>


</div>
<div class="footer_right">
<a href="http://www.uni-marburg.de/"><img width="120px" src="http://upload.wikimedia.org/wikipedia/commons/9/9c/Uni_Marburg_Logo.svg?uselang=de" alt="PUD" /></a>
</div>
 </div><!-- end footer -->
</div><!-- end wrapper-->
</body>
</html>
