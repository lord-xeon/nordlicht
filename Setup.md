## How to Use ##
Using nordlicht couldn't be easier.  Simply download the [latest archive](http://code.google.com/p/nordlicht/downloads/list), and unzip it to the directory on your server.

Setup might require a few changes, but those are simple.


---

The variables you may need to change are located in `funn/config.php`:

  * The absolute server path to your awstats directory
> > `$stsP = '/var/lib/awstats/';`
  * The file name convention awstats uses for it's data files
> > `$stsF = $stsP.'awstats'.$dayR.'.'.$statsURL.'.txt';`

  * Year to date functionality - on by default
> > `$year2Date = true;`

  * Directory where you want to keep the year to date files
> > `$y2dDir = '/home/alphavega/demo/ph/nordlicht/funn/y2d/'.date('Y');`