README
nordlicht version 0.4.1
copyright 2011 alpha vega llc

Licesned under the GNU GENERAL PUBLIC LICENSE Version 2

nordlicht is a new front end for AWStats

Instlation:
	1. Put all files into a directory on your server.
	2. Update the path to the AWStats  data files
	3. Navigate to the directory on your domain adding stats-YOUR.DOMAIN.COM to the URL
		3.1 To change the subdomain of your site, simple replace the YOUR.DOMAIN.COM with the one you wish to view
		3.2 To change the date add -MMYYYY after stats-YOUR.DOMAIN.COM
		3.3 You might need to modify the .htaccess file to reflect your setup if that's the case you can use these:
			3.3.1 ?stats=YOUR.DOMAIN.COM&time=MMYYYY
	4. Enjoy

=Resources:==
nordlicht comes with the following resources that have been made available under the following licenses

==jQuery Plugins:==
  * Colorbox 1.3.15 - under the MIT license
  * jQuery ScrollTo - Dual licensed under MIT and GPL
  * Date picker for jQuery v4.0.4 - Dual licensed under MIT and GPL
  * MSDropDown v2.36 - Dual licensed under MIT and GPL
  * DataTables v1.7.5 - Dual licensed under GPL & BSD3

==Images and Icons:==
  * The Ultimate Free Web Designer’s Icon Set (750 icons, 48x48px) - http://www.smashingmagazine.com/2010/04/15/the-ultimate-free-web-designer-s-icon-set-750-icons-incl-psd-sources/ 
  * FamFamFam Flag icons - http://www.famfamfam.com/lab/icons/flags/
  * nordlicht northern lights photo from http://en.wikipedia.org/wiki/File:Polarlicht_2.jpg - part of the Public Domain
  
=Changelog=
==nordlicht v0.5==
===Feb. 27, 2011===
  * Fixed bug 3 - Full list functionality now avaliable on:
    * IP
	* Domain
	* File Types
	* Page Referals
  * Added each individual jQuery plugin file, compressed, and uncompressed
  * Made ultra.js just include my javascript
  * Created venona.js to include all the minified jQuery plugins, and venona.min.js to include minified plugins, with no comments
  * Changed to modernizer 1.7 custom build
  * Added global javascript variables for date, and surl
  * fixed the layout of the tables
  
==nordlicht v0.4.3==
===Feb. 20, 2011===
  * updated the colors to be more northern lighty
  * updated the header to be not so IN YOUR FACE
  * updated the layout of the Browser/OS section
  * added global javascript variables for URL & time
  * begun work on bug 3, not done yet
==nordlicht v0.4.1==
===Feb. 06, 2011===
  * finished bug 8 - made the splash page fucking ace
  * added custom theme to date picker and MSDropDown
  * removed lots of CSS from MSDropDown
  * limited date picker to 2001 till current day
  * cleaned up the HTML output of drawTable()
  * centered the Y2D table
  * added a favicon - looks like crap but better then nothing right now
==nordlicht v0.4==
===Feb. 05, 2011===
  * added the Year to Date info
  * fixed bug 10 - added padding to charts
  * fixed bug 2
  * started bug 8 - added a splash page, it looks like crap
==nordlicht v0.3.1.1==
===Jan 27, 2011===
  * added magnifing glass icon
  * seperated the search and refferals sections
  * changed the sorting on Refferals to be by Page
  * cleaned up the CSS alittle

==nordlicht v0.2.1==
===Jan 13, 2011===
  * added licenses and readmes for jQuery plugins
  * updated the file type icons
  * updated the "other" browser icon

==nordlicht v0.2==
===Jan 08, 2011===
  * Made all tables made with the drawTable function that takes an associative array of values
  * Removed old code from funnns.php
  * Updated footer to include correct links

==nordlicht v0.1==
===Jan 01, 2011===
  * Inital release