#! /usr/bin/env python
# *-* coding:utf-8 *-*
"""
Script converts BibTex-files into sqlite3 database files.

@author: Johann-Mattis List
@date: 2010/09/22
"""

import sqlite3
from re import sub,findall,DOTALL
from sys import argv
import os
import codecs

# These are the parameters, which are used in the current implementation.
parameters = [
		'Isbn',
		'Author',
		'Series',
		'Abstract',
		'Number',
		'Keywords',
		'Year',
		'Title',
		'Booktitle',
		'Institution',
		'Note',
		'Editor',
		'Howpublished',
		'Journal',
		'Volume',
		'Address',
		'Pages',
		'Publisher',
		'School',
		'Doi',
		'Edition',
		'Url',
                'Crossref'
		]
parameters.sort()

# Connect the database, the name of the database is passed as argv[1]
db_name = argv[1]

os.system('rm '+argv[1]+'.sqlite3')

conn = sqlite3.connect(db_name+'.sqlite3')
c = conn.cursor()

# Create the string that is used in order to create the table "bibliography" in the db
create_table = 'create table bibliography(key text,type text,bibtex text'
for parameter in parameters:
	create_table = create_table + ',' + parameter.lower() + ' text'
create_table = create_table + ');'

# Create the table in the db
c.execute(create_table)

# Read the data from the bibtex-file, the name of the file is the same as db_name
infile = unicode(open(db_name+'.bib','r').read(),'utf-8')

# Find all distinc entries in the db
entries = findall('\n@.*?\n}',infile,DOTALL)

print "First run, searching for crossrefs..."
globaldict = {}
for entry in entries:
	this_type = findall('\n@(.*?){',entry)[0].lower()
	this_key = findall('\n@.*?{(.*?),',entry)[0]
        globaldict[this_key] = {}
        if 'XXX' in this_key or this_type.lower() in ['set',"customa","customb", "lecture"]:
            pass
        else:
	    this_entry_dict = {}
	    for param in parameters:
	    	try:
	    		result = findall(param + '\s*= {(.*?)},*\n',entry, DOTALL)[0]
	    	except:
	    		result = ''
	    	if result != '':

	    	    this_entry_dict[param] = result.replace('\n',' ').replace('}','').replace('{','').replace('\t',' ').replace('  ',' ')
                    globaldict[this_key][param] = this_entry_dict[param]
print "...done."

count = 0
print "Second run, converting to sqlite..."
# Start the main loop
bibout = codecs.open('evobib-converted.bib', 'w', 'utf-8')
etypes = set()
for entry in entries:
	this_type = findall('\n@(.*?){',entry)[0].lower()
	this_key = findall('\n@.*?{(.*?),',entry)[0]
        if 'XXX' in this_key or 'xxx' in this_key or 'submitted' in this_key or this_type.lower() in ['language', 'set','customa','customb', 'lecture'] or 'sole' in this_key or 'lingpy' in this_key or this_key[-1] not in '0123456789abcdefghijklmn':
            pass
        else:
	    this_entry_dict = {}
	    for param in parameters:
	    	try:
	    		result = findall('  '+param + '\s*= {(.*?)},*\n',entry, DOTALL)[0]
	    	except:
	    		result = ''
	    	if result != '':
                    if param == 'crossref':
                        try:
                            tmp_title = globaldict[result]['Maintitle']
                        except:
                            try:
                                tmp_title = globaldict[result]['Mainbooktitle']
                            except:
                                try:
                                    tmp_title = globaldict[result]['Title']
                                except:
                                    tmp_title = "Unknown Booktitle"
                        try:
                            this_entry_dict['Year'] = globaldict[result]['Year']
                        except:
                            pass
                        
                        this_entry_dict[param] = u'<a href="http://lingulist.de/evobib/evobib.php?key={0}">{1}</a>'.format(result,tmp_title)
                    else:
	    		this_entry_dict[param] = result.replace('\n',' ').replace('}','').replace('{','').replace('\t',' ').replace('  ',' ')

                        if param == 'Doi' and param in this_entry_dict:
                            if not this_entry_dict[param].startswith('http'):
                                this_entry_dict[param] = 'http://dx.doi.org/'+this_entry_dict[param]
            if len(this_entry_dict) > 1:
                if this_type.strip() and this_type not in ['unpublished']:
                    etypes.add(this_type)
	            bibtex = '@'+this_type+'{'+this_key+',\n'
	            c.execute('insert into bibliography(key,type) values("'+this_key+'","'+this_type+'");')
	            for key in this_entry_dict.keys():
                        if key != "crossref":
	                    bibtex = bibtex+'    '+key+' = {'+this_entry_dict[key]+'},\n'
	                    c.execute('update bibliography set '+key.lower()+' = ? where key = "'+this_key+'";',(this_entry_dict[key],))
                        else:
                            bibtex = bibtex+'    '+key+' = {'+globaldict[this_key]['crossref']+'},\n'
	            	c.execute('update bibliography set booktitle = ? where key = "'+this_key+'";',(this_entry_dict[key],))


                    bibtex = bibtex[:-2] + '\n}\n'
	            #bibtex = bibtex.replace(',\n}','\n\n}')
	            c.execute('update bibliography set bibtex = ? where key = "'+this_key+'";',(bibtex,))
                    count += 1
                    bibout.write(bibtex+'\n')
conn.commit()
print "Done, data stored in " + db_name + ".sqlite3."		
print "Currently, there are {0} entryies.".format(count)
bibout.close()
for etype in etypes:
    print(etype)
