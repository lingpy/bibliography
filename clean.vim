"This script cleans bibtex-entries which are 
"encoded in Latex-style into unicode-style
"entries.
"@author: Johann-Mattis List
"@date: 2010/09/22

%s/PR\\"UFEN;*//ge
%s/\\url//ge
%s/NICHT\~GESICHTET;*//ge
%s/GESICHTET;*//ge
%s/\\"{*a}*/ä/ge
%s/\\"{*e}*/ë/ge
%s/\\"{*u}*/ü/ge
%s/\\"{*o}*/ö/ge
%s/\\"{*A}*/Ä/ge
%s/\\"{*E}*/Ë/ge
%s/\\"{*i}*/ï/ge
%s/\\"{*I}*/Ï/ge
%s/\\"{*U}*/Ü/ge
%s/\\"{*O}*/Ö/ge
%s/\\'{*a}*/á/ge
%s/\\'{*e}*/é/ge
%s/\\'{*i}*/í/ge
%s/\\'{*o}*/ó/ge
%s/\\'{*u}*/ú/ge
%s/\\'{*A}*/Á/ge
%s/\\'{*E}*/É/ge
%s/\\'{*I}*/Í/ge
%s/\\'{*O}*/Ó/ge
%s/\\'{*U}*/Ú/ge
%s/\\'{*y}*/ý/ge
%s/\\'{*Y}*/Ý/ge
%s/\\`{*a}*/à/ge
%s/\\`{*e}*/è/ge
%s/\\`{*i}*/ì/ge
%s/\\`{*o}*/ò/ge
%s/\\`{*u}*/ù/ge
%s/\\`{*A}*/À/ge
%s/\\`{*E}*/È/ge
%s/\\`{*I}*/Ì/ge
%s/\\`{*O}*/Ò/ge
%s/\\`{*U}*/Ù/ge
%s/\\`{*y}*/ỳ/ge
%s/\\`{*Y}*/Ỳ/ge
%s/\\v{a}/ǎ/ge
%s/\\v{e}/ě/ge
%s/\\v{i}/ǐ/ge
%s/\\v{o}/ǒ/ge
%s/\\v{u}/ǔ/ge
%s/\\v{A}/Ǎ/ge
%s/\\v{E}/Ě/ge
%s/\\v{I}/Ǐ/ge
%s/\\v{O}/Ǒ/ge
%s/\\v{U}/Ǔ/ge
%s/''/"/ge
%s/``/"/ge
%s/\\&/\&/ge
%s/\\v{s}/š/ge
%s/\\v{c}/č/ge
%s/\\v{S}/Š/ge
%s/\\v{C}/Č/ge
%s/\\v{z}/ž/ge
%s/\\v{Z}/Ž/ge
%s/--/-/ge
%s/\\pounds/£/ge
%s@Eprint\s* = {\\url{\([^}]*\)}@url = {\1
%s@Eprint\s* = {http\([^}]*\)}@url = {http\1}
%s@Eprint\s* = {\(.*\)},\n  Eprinttype\s* = {JSTOR}@url = {http://www.jstor.org/stable/\1}
%s@Eprint\s* = {\(.*\)},\n  Eprinttype\s* = {GoogleBooks}@url = {http://books.google.de/books?id=\1}
%s@Eprint\s* = {\(.*\)},\n  Eprinttype\s* = {googlebooks}@url = {http://books.google.de/books?id=\1}
%s@Eprint\s* = {\(.*\)},\n  Eprinttype\s* = {ia}@url = {http://archive.org/details/\1}
%s/{\([A-Z]+\)}/\1/ge
%s/Reference/Book/
%s/Mvbook/Book/
%s/Online/Misc/
g/Owner\s* = /d
g/Timestamp\* = /d
%s@  Title\s* = {\(.*\)},\n  Subtitle\s* = {@  Title = {\1. 
%s@  Mainsubtitle = {\(.*\)},\n  Maintitle = {\(.*\)}@  Maintitle = {\2. \1}
%s/Software/Book/
%s/Set/

" %s/Customa/Book/
" %s/Customb/Book/

%s/Mvcollection/Collection/
%s/Date\s* = /Year = /
%s/@Collection/@Book/
%s/Bookinbook/Incollection/
%s/?\./?/ge
%s/Eventtitle/Booktitle/
%s/Maintitle/Booktitle/
g/Keywords = .*XXX/d

%s/\\hana //ge
%s/\\hanb //ge
%s/_url/url/




