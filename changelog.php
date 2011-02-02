<?php
	header('location: index.php');
	exit;
?>

Changelog for psa

current version 0.02

debug : 
- jade + urldecode-encode
- try catch in qs
- click on queries -> eol

- check valid sqlite3 database file

[2010.12.29]
- edit_do.php : first working trial

[2010.11.30]
- table_browse.php : verwijderen target in delete

[2010.11.27]
- debug query string (## naar ')
- seconden toegevoegd in query string order
- delete record afgewerkt

[2010.10.21]
- create database
- vacuum database
- drop database
- database names in alfabetic order

- some merge shit on asgc.be - continue

[2010.10.20]
- table structure
- table browse with padding


[2010.10.19]
- directory and extension in table
- eerst databank kiezen - dan tabel

[2010.10.06]
- bug : setup script creatie tabel aangepast 

[2010.10.05]
- finally hour and minute OK??
- structure / browgse separate (browse only first 200 lines)
- browse with ROWID (works but needs debugging)

[2010.09.24] 
- query_results full
- debug minutes wrong !!

[2010.09.23] version 0.01b
- based on installation asgc -> queries in database
CREATE TABLE queries (id INTEGER PRIMARY KEY, qs TEXT , datum DATETIME(20), db VARCHAR(128))

[2010.09.22] version 0.01 - tag psa-0.01
initial setup

covered functions
- open database
- list tables
- table structure
- raw queries
