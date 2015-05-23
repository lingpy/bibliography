<?php
echo '<span class="clear"></span>';
echo '<br>';
//echo '<p><b>The following titles match your query:</b> </p>';
echo '<table align=center width="100%" border="1" >';
echo '<tr><th>KEY</th><th width="15%">Author/Editor</th><th width="5%">Year</th><th width="35%">Title</th><th width="30%">Journal/Proceedings/Address</th><th width="10%" >RefType</th><th width="5%">URL/DOI</th></tr>';
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
    if ($value['doi'] != '') {
      $value['url'] = '<a target="_blank" href="'.$value['doi'].'">[DOI]</a> ';
    }
    else {
      $value['url'] = '<font color=white>.</font>';
    }
  }
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
    echo '<td>'.$value['key'].'</td>';
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
    echo '<td>'.$value['key'].'</td>';
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
    echo '<td>'.$value['key'].'</td>';
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
    echo '<td>'.$value['key'].'</td>';
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
    echo '<td>'.$value['key'].'</td>';
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
    echo '<td>'.$value['key'].'</td>'; 
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
    echo '<td>'.$value['key'].'</td>';
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
    echo '<td>'.$value['key'].'</td>';
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
    echo '<td>'.$value['key'].'</td>';
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

?>
