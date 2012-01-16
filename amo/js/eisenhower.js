require([
	"d3/d3",
	"jquery/jquery.ui.selectmenu",
	"patton",
	"Enigma"
	],
	function(){
		require.urlArgs = "cache="+(new Date().getTime());
		nordlicht.updateSite(1);
		nordlicht.initNordlicht();
		nordlicht.initTab();
    	console.log("all files loaded");
});
