/* jQuery plugin JSONtip 
	version: 2.0 - March 26, 2011
	author: stephen giorgi
	author email: stephen.giorgi@alphavega.com
	URL: http://www.alphavega.com/json-tip

	Copyright (C) 2011 alpha vega

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

(function($){
$.fn.JSONtip = function(options){
	var dds = $.extend({}, $.fn.JSONtip.defaults, options),
		tip = $(".JSONtip");
	
	//appends the tip markup to the end of the body only once
	if(tip.length == 0){
		$('body').append(makeTip());
	}
	
	//Run the plugin for each element and maintain chainability of command
	return this.each(function(){
		var $t = $(this),
			o = dds,
			tip = $(".JSONtip"),
			tipVals = {};
		//if inline-parse is true parse the element to find the specific settings to use
		if(dds['inline-parse'] == true) {
			o = $.extend({}, dds, $t.data());
		}
		
		if(o['preload'] == true && o['url']){
			loadJSON($t,o);
		}
		
		if(o['tip-show-event'] == 'hover'){
			$t.mouseenter(function(e){
				e.preventDefault();
				e.stopPropagation();
				o['fade-in-speed'] = 0;
				finishedTip($t,o);
			});
			$t.mouseleave(function(e){
				e.preventDefault();
				e.stopPropagation();
				$.fn.JSONtip.tipHide(0);
			});
		}
		else {
			$t.click(function(e){
				e.preventDefault();		//prevents following link if it is one
				e.stopPropagation();	//prevents the fade out on body click since technically, the element is a child of the body
				finishedTip($t,o);
			}); //end $t.click()
		}
		
		//allows you to click inside of the tip without it fading out
		tip.click(function(e){
			e.stopPropagation();
		});	//end tip.click()
		
		//fadeOut events
		//fade out tip on when the user hits escape (only on keyup)
		$("body").keyup(function(k){
			if(k.keyCode == 27){	//keycode 27 is escape
				$.fn.JSONtip.tipHide(o['fade-out-speed']);
			}
		});
		
		//fades out the tip when you click anywhere in the body
		if(o['body-close'] == true){
			$("body").click(function(){
				$.fn.JSONtip.tipHide(o['fade-out-speed']);
			}); //closes $(body).click()
		}
		
		//fades out the tip when you click the X
		$(".JSONtipClose").click(function(){
			$.fn.JSONtip.tipHide(o['fade-out-speed']);
		});	//closes $(.JSONtipClose).click()
		
	});
	
	//Private Functions
	//debugging function
	function debug(what){
		console.log(what);
	}
	
	//makeTip() builds the tip HTML
	function makeTip(){
		var tip =	'<div class="JSONtip tipRight "'+dds['tip-class']+'>'+
						'<span class="JSONtipClose">x</span>'+
						'<div class="JSONtipArrow">'+
							'<div class="inArrow"></div>'+
						'</div>'+	
						'<h4></h4>'+
						'<p class="JSONtipBody"></p>'+
						'<img src="/img/loading.gif" alt="loading" class="JSONloading" />'+
					'</div>';
		return tip;
	}

	//loadJSON($(this),o) - load the JSON from the passed URL and store it in the element's data.json object
	function loadJSON(what,o){
		var url = o['url'],
			code = what.data('jsondata') ? what.data('jsondata') : o['jsonData'];
		if(what.data('json')) { return; } //if the JSON call was made already return, no need to make it again
		if(dds.preload == false){	//if preload is set to false show the loading icon
			$(".JSONloading").fadeIn('fast');
		}
		$.getJSON(url,{
			code:code
		},function(js){
			//store the JSON in the element's data.json object
			what.data('json',js);
		});
	}
	
	//tipFill($(this)) - fills in the h4 and p of the tip with the returned JSON/embedded JSON/title tag
	function tipFill(what,op){
		var td = what.data(),
			tipH = $(".JSONtip h4"),
			tipS = $(".JSONtip .JSONtipBody");
			if(op['url']){
				tipS.html(what.data('json').tipbody);
				if(td.json.tiphead){
					tipH.html(what.data('json').tiphead);
				}
			}
			else if(td.tipbody || op['tipbody']){
				var ttipc = {};
				ttipc.bod = td.tipbody ? td.tipbody : op['tipbody'];
				tipS.html(ttipc.bod);
				if(td.tiphead || op['tiphead']){
					ttipc.head = td.tiphead ? td.tiphead : op['tiphead'];
					tipH.html(ttipc.head);
				}
			}
			else {
				tipS.html(what.title);
			}
			showHead();
			$(".JSONloading").fadeOut();
	}
	
	//showHead() - is the h4 empty?  If so make it display none;
	function showHead(){
		var yes = 'block',
			tipH = $(".JSONtip h4");
		if(tipH.html() == '') {
			yes = 'none';
		}
		tipH.css({'display':yes});
	}
	
	//tipPlace($(this),defaults) - positions the tip in the correct place relative to the element
	function tipPos(what,op){
		var eOff = what.offset(),
			eLeft = eOff.left,
			eTop = eOff.top,
			eHeight = what.outerHeight(),
			eWidth = what.outerWidth(),
			defX = op['x-offset'],
			defY = op['y-offset'],
			xTip = (eHeight + eLeft) + defX,
			yTip = (eTop) - defY,
			userTip = op['tip-position'].toLowerCase(),
			tipVals = {},
			tipDms = $(".JSONtip"),
			tipClass = '';

		//if the user overrides it to be certain position
		switch (userTip) {
			case 'left':
				xTip = (eLeft - tipDms.width()) - defX;
				tipClass = 'tipLeft';		//move the arrow to face right
				break;
			case 'topleft':
				xTip = (eLeft) - defX;
				yTip = (eTop - tipDms.height()) - defY;
				tipClass = 'tipTopLeft';
				break;
			case 'topright':
				xTip = (eLeft - tipDms.width())+ eWidth - defX;
				yTip = (eTop - tipDms.height()) - defY;
				tipClass = 'tipTopRight';
				break;
			case 'topcenter':
				xTip = (eLeft + eWidth /2) - (tipDms.width() / 2) - defX;
				yTip = (eTop - tipDms.height()) - defY;
				tipClass = 'tipTopCenter';
				break;
			case 'bottomleft':
				xTip = (eLeft) - defX;
				yTip = (eTop + eHeight) + defY;
				tipClass = 'tipBottomLeft';
				break;
			case 'bottomright':
				xTip = (eLeft - tipDms.width())+ eWidth - defX;
				yTip = (eTop + eHeight) + defY;
				tipClass = 'tipBottomRight';
				break;
			case 'bottomcenter':
				xTip = (eLeft + (eWidth / 2)) - (tipDms.width() / 2) - defX;
				yTip = (eTop + eHeight) + defY;
				tipClass = 'tipBottomCenter';
				break
			default:
				xTip = (eLeft + eWidth) + defX;
				tipClass = 'tipRight';
				break;
		}

		return tipVals = {
					left:xTip,
					top:yTip,
					c:tipClass
				};
	}
	
	//tipMovePos(tipVals) - move the tip left/right based on screen size
	function tipPosMove(vals,what,op){
		var wL = window.innerWidth,
			eOff = what.offset(),
			defX = op['x-offset'],
			tipDms = $(".JSONtip"),
			x = vals.left,
			cl = vals.c,
			valsV = {};
			
			if(vals.x < 0 ) {
				//if the left side of the tip is off the screen, reverse it to be right
				switch (vals.c){
					case 'tipBottomCenter':
						//if it's in the center, move it to be the x-offset from the edge of the screen
						x = 0 + defX;
						break;
					case 'tipTopCenter':
						//if it's in the center, move it to be the x-offset from the edge of the screen
						x = 0 + defX;
						break;
					case 'tipTopRight':
						x = eOff.left + defX;
						cl = 'tipTopLeft';
						break;
					case 'tipBottomRight':
						x = eOff.left + defX;
						cl = 'tipBottomLeft';
						break;
					default:
						x = eOff.left + what.width() + defX;
						cl = 'tipRight';
						break;
				}
			}
			else if((vals.x + tipDms.width()) > wL) {
				//if the right side of the tip is off the screen, reverse it to be left
				switch (vals.c){
					case 'tipBottomCenter':
						//if it's in the center, move it to be the x-offset from the edge of the screen
						x = wL - what.width() - defX;
						break;
					case 'tipTopCenter':
						//if it's in the center, move it to be the x-offset from the edge of the screen
						x = wL - what.width() - defX;
						break;
					case 'tipTopLeft':
						xl = (eOff.left - tipDms.width() + what.width()) - defX;
						cl = 'tipTopRight';
						break;
					case 'tipBottomLeft':
						x = (eOff.left - tipDms.width() + what.width()) - defX;
						cl = 'tipBottomRight';
						break;
					default:
						x = eOff.left - what.width() + defX;
						cl = 'tipLeft';
						break;
				}
			}
			vals.left = x;
			vals.c = cl;
			
			return vals;
		}

	//tipHeightAdjust($(this),o) - moves the height if the tip is on the top of the element
	function tipHeightAdjust(what,op,vals){
		var tip = $(".JSONtip"),
			tipH = tip.outerHeight(),
			tipT = tip.offset(),
			eOff = what.offset();

			vals.top = eOff.top - tipH - op['y-offset'];
			return vals;
	}
	
	function finishedTip($t,o){
		$.fn.JSONtip.tipReset(o['tip-class']);
		if(o['tip-x'] && o['tip-y']){
			tipVals = {};
			tipVals.left = o['tip-x'];
			tipVals.top = o['tip-y'];
			tipVals.c = o['tip-position'];
		}
		else {
			tipVals = tipPos($t,o);
			$(".JSONloading").fadeIn();
			if(o['auto-position'] == true){
				tipVals = tipPosMove(tipVals,$t,o);
			}
		}
		if(o['tip-width']) {
			tipVals.width = o['tip-width'];
		}
		
		$.fn.JSONtip.tipPlace(tipVals);
		$.fn.JSONtip.tipShow(o['fade-in-speed']);
		if(o['no-close'] == true) {
			tip.addClass('noClose');
		}
	
		if(o['preload'] == false && o['url'] && !$t.data('json')){
			loadJSON($t,o);
			//wait till the AJAX call is complete before filling in the content otherwise we're left with a blank tip
			$t.ajaxComplete(function(){
				tipFill($t,o);
				/* when the tip is on the top of the element, the position is based off of the tip's height.
				 * Since the height is auto based on the content, the position of it will be off,
				 * so we have to move it after it get's its content 
				 */
				if(tip.is('.tipTopRight, .tipTopLeft, .tipTopCenter')) {
					tipVals = tipHeightAdjust($t,o,tipVals);
					$.fn.JSONtip.tipPlace(tipVals);
				}
			});
		}
		else {
			tipFill($t,o);
			/* when the tip is on the top of the element, the position is based off of the tip's height.
			 * Since the height is auto based on the content, the position of it will be off,
			 * so we have to move it after it get's its content 
			 */
			if(tip.is('.tipTopRight, .tipTopLeft, .tipTopCenter')) {
				tipVals = tipHeightAdjust($t,o,tipVals);
				$.fn.JSONtip.tipPlace(tipVals);
			}
		}
	}
}


//JSONtip defaults
$.fn.JSONtip.defaults = {
	'fade-in-speed': 500,		//the fade in speed, can take any argument accepted by jQuery.fadeIn()
	'fade-out-speed': 200,		//the fade out speed, can take any argument accepted by jQuery.fadeOut()
	'x-offset': 22,				//how far away from the element in the X direction to place the tip - can be any integer
	'y-offset': 22,				//how far away from the element in the Y direction to place the tip - can be any integer
	'tip-position': 'right',	//position of the tip relative to the element - string - left; right; topright; topleft; topcenter; bottomright; bottomleft; bottomcenter
	'tipbody': null,
	'tiphead': null,
	'tip-x': null,
	'tip-y': null,
	'tip-width': null,
	'tip-show-event': 'click',
	'auto-position': true,		//will move the tip to be left or right facing if the tip content is off the screen
	'body-close': true,			//clicking on the body closes the tip
	'no-close': false,			//hides the close icon to make a cleaner tip
	'tip-class': '',			//custom themeing class(s) to add to the markup [CANNOT BE PASSED INLINE]
	'url': null,				//url to get the JSON data from
	'jsondata': null,			//data to pass to the URL - one paramater only
	'inline-parse': false,		//parse the element for inline HTML5 data-[option]="value"	[CANNOT BE PASSED INLINE]
	'preload': true				//preload the JSON for each Tip (speeds up showing of the tip, slows down loading of the page)
};


//JSONtip public functions
//tipShow(speed) - fades in the tip at the selected speed - if no speed is given, 500ms is default
$.fn.JSONtip.tipShow = function(speed){
	var s = speed ? speed : '500'
	$(".JSONtip").fadeIn(s);
}

//tipHide(speed) - fades out the tip at the selected speed - if no speed is given, 300ms is default
$.fn.JSONtip.tipHide = function(speed){
	var s = speed ? speed : '300'
	$(".JSONtip").fadeOut(s);
}

//tipReset(classes) - reset the tip to defaults - tipRight + [classes], empties out the h4, and p.JSONtipBody tags 
$.fn.JSONtip.tipReset = function(classes) {
	$(".JSONtip").removeClass().addClass('JSONtip tipRight '+classes);		//reset the tip to dds -|- Right side of element
	$(".JSONtip h4").html('');
	$(".JSONtip .JSONtipBody").html('');
}

/*tipPlace(obj) - places the tip on the screen in the location in the object:
 * obj = {
	 	left: [the X position of the tip]	- defaults 0
		top: [the Y position of the tip]	- defaults 0
		zIndex: [the z-index of the tip]	- defaults to 9000
		display: [the display property]		- defaults to block
		c: [the class of the tip]			- defaults to tipRight
	 }
*/
$.fn.JSONtip.tipPlace = function(where){
	var here = {
		left:0,
		top:0,
		zIndex:9000,
		display:'block',
		c:'tipRight'
	}
	here = $.extend({}, here, where);
	$(".JSONtip").css(here).removeClass('tipRight').addClass(here.c);
}

})(jQuery);