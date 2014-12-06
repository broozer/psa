<?php
	header('location: controller.php');
	exit;
?>

Changelog for psa

version :

todolist 11.08.2012

- show all performed queries and also hold result (can be done by dumping queries table of base)
- create table : UNIQUE (Foreign key)
- pragma values : check set
- version via exec (which options are available eg WAL)
- goto record by (ROW)id

[2013.12.19]
- login added (admin - asp)

[2013.07.28]
- number of rows in table view
- stay at current rowview in table (add bottom_table in table_view) - alter number of rows shown (fixed on 20 now)
- cleanup comments in files
- performed queries hold result
- table dump : result in textarea
- tabel csv : result in textarea
- export CSV , xml , sql create table
- set default number of rows to display
- preserve row value for browsing

[2012.12.17]
- small bug in table_browse previous solved (always view)

[2012.12.14]
- view browse links with view=true

[2012.12.07]
- add d'ieteren (binder used)

[2012.12.05]
- default number of rows
- layout
- if integer primary is chosen NO size -> otherwise column does not act as autoicrement

[2012.11.07]
CSV export

current version 0.02.1
[2012.08.12]
- table browse : odd problem of size = limit and no records solved
- views : no edit/delete possible

current version 0.02
[2012.03.15]
- indexes
- views

[2012.02.06]
- record add
- table drop
- menu hide

[2012.02.06]
- issue 7 : debugging on table create - wrong table creation (left colsize out of table definition)

[2012.01.31]
- table_add finished (draft version) - in local branch table_add

[2012.01.26]
- table add continue working : needs a temporary table fields table
- drop column : if only 1 field -> drop table
- queries : escaped " sign
- cleanup faulty css declarations

[2012.01.21]
- drop_column.php added

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
