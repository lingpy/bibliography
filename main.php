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
    <!--<h2> <a href="main.php">Home</a></h2>-->


 </div>
 <div id="contentwrapper" class="clearfix">
     <div id="content">    
	 <!-- SIDEBAR home -->

<script>
  var url_parts = window.location.href.split('/');
  var last_part = url_parts[url_parts.length-1];
  if(last_part.indexOf('?key=') != -1) {
    var very_last_part = last_part.split('?')[1];
    if (very_last_part.indexOf('&view=raw') != -1) {
      window.location.href= 'http://bibliography.lingpy.org/raw.php?'+very_last_part;
    }
    else {
      window.location.href = 'http://bibliography.lingpy.org/evobib.php?'+very_last_part;
    }
  }
</script>
<div id="mainpic"><?php include('figures/evobib.svg'); ?></div>
<h3 style="text-align:center;padding-left:20px;">A Bibliographic Database for Historical Linguistics</h3>

<!--<h3 style="text-align:center;padding-right:30px;">Bibliographical Database for Historical Linguistics</h3>-->


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
 <p>Last updated on Oct. 01, 2014, 09:31 CET</p>
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
