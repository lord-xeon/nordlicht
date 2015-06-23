# Functions #
List of functions and how to use them


## List ##
**Function - drawTable()** draws a table for the section of the array.  Takes an associative array of arguments
```
'section' 	= > section of the stats array file	(Required)
'meta'		= > meta data for headers to draw	(Required)
'limit'		= > the limit to print out
'offSet'	= > when to offset the begining of the table - for Dual Tables ex: Hours 0-11, and Hours 12-23
'sort'		= > how to sort the table
'tableID'	= > id to give the <table> element (table[random 5-500] default)
'cc'		= > array of information relative to one of the sections to display ex: turning US into United States
```