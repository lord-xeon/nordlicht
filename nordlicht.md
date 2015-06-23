# Introduction #

Nordlicht is a new front end for the AWStats.  I grew tired of seeing the ancient interface of AWstats, while the rest of the web evoloved, and embraced new technologies such as HTML5, CSS2 & CSS3, and new charting abilities.

So, I went about redesigning the front end, and this is what I came up with.

# How does it work? #

With lots, and lots of PHP.

Well, that's the unfortunate outcome of a single person working on this in their spare time.  There's lots that is duplicated code.

The back end is all PHP, but still uses AWStats to analyze the Apache server logs, but that's all that AWStats does, create the output log file, nordlicht goes through that log file and puts it in a nice front end design.

The graphs are made using the excellent Google Charting API.  However there are limits.  I decided that for the first version I would go with the easier to use, and better on the system, static charts.  Perhaps in a future version I might change to the more user-friendly interactive charts.