/* jQuery plugin JSONtip 
	version: 1.0
	author: stephen giorgi
	author email: stephen.giorgi@alphavega.com
	URL: http://www.alphavega.com/json-tip

Copyright (C) 2011 stephen giorgi

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
	var dds = {
		fadeInSpeed: 500,		//the fade in speed, can take any argument accepted by jQuery.fadeIn()
		fadeOutSpeed: 200,		//the fade out speed, can take any argument accepted by jQuery.fadeOut()
		xOffSet: 12,			//how far away from the element in the X direction to place the tip - can be any integer
		yOffSet: 12,			//how far away from the element in the Y direction to place the tip - can be any integer
		tipPosition: 'right',	//position of the tip relative to the element - string - left; right; topright; topleft; topcenter; bottomright; bottomleft; bottomcenter
		autoPosition: true,		//will move the tip to be left or right facing if the tip content is off the screen
		bodyClose: true,		//clicking on the body closes the tip
		tipClass: '',			//custom themeing class(s) to add to the markup
		json: null,				//url to get the JSON data from
		jsonData: null,			//data to pass to the URL - one paramater only
		inlineParse: false		//parse the element for inline HTML5 data-[option]="value"
	}
	var options =$.extend(dds,options);
	
	//builds the tip HTML
	makeTip = function(){
		var tip =	'<div class="JSONtip tipRight '+dds.tipClass+'">'+
						'<span class="JSONtipClose">x</span>'+
						'<div class="JSONtipArrow">'+
							'<div class="inArrow"></div>'+
						'</div>'+
						'</span>'+
						'<h4></h4>'+
						'<p class="JSONtipBody"></p>'+
					'</div>';
		return tip;
	}
	//appends the tip markup to the end of the body only once
	if($('.JSONtip').length == 0){
		$('body').append(makeTip());
	}
	//return this to maintain chainability
	return this.each(function(){
		var t = $(this),
			tipTime = $('body').data('timer'),
			tip = $(".JSONtip"),
			tipD = tip.css('display'),
			tipH = $(".JSONtip h4"),
			tipS = $(".JSONtip .JSONtipBody"),
			tipA = $(".JSONtip .JSONtipArrow"),
			off = t.offset(),	//the offset of the element
			yOff = off.top,		//the y offset
			xOff = off.left,	// the x offset
			eH = t.outerHeight(),	//the outer height of the element
			eW = t.outerWidth(),	//the outer width of the element
			tData = t.data();
		
		//makes the AJAX call to get the JSON data for the tip
		if(dds.json){ JSONcall(); }
		
		/*@Events
		 * this.click - main function that builds the whole tip
		 * tip.click - lets you click inside the tip
		 * body.keyup - escape key fade out
		 * body.click - click anywhere to fade out
		 * JSONtipClose.click - click on the close icon to close tip
		 */
		t.click(function(e){
			e.preventDefault();		//prevents following link if it is one
			e.stopPropagation();	//prevents the fade out on body click since technically, the element is a child of the body
			tipS.html(tipFill(this,tData,'body'));	//set the body of the tip
			tipH.html(tipFill(this,tData,'head'));	//set the header of the tip
			tipPlace(eH,eW,this);	//place the tip around the parent
			tipShow(this);			//fade in the tip
		});
		tip.click(function(e){
			e.stopPropagation();	//allows you to click inside of the tip without it fading out
		});
		$("body").keyup(function(k){
			if(k.keyCode == 27){	//keycode 27 is escape, fade out tip on escape
				tipHide();
			}
		});
		if(dds.bodyClose == true){
			$("body").click(function(){tipHide();});	//fades out the tip when you click anywhere in the body
		}
		$(".JSONtipClose").click(function(){tipHide();});	//fades out the tip when you click the X

		//Fills in the tip with the correct information
		tipFill = function(tt,tData,sec){
			var tBody = '',
				td = $(tt).data();
			if(sec == 'body'){	//sets the body of the tip
				if(td.json){
					tBody = td.json.tipbody;
				}
				else if(tData.tipbody){
					tBody = tData.tipbody; //will try the passed HTML5 data attribute of the element if it's there
				}
				else {	//if no embedded data attribute, will fallback to the title of the element
					tBody = tt.title;
				}
			}
			else {	//sets the header of the tip - if no passed attr, or obj, will be empty
				if(td.json){
					tBody = td.json.tiphead;
				}
				else if(tData.tipbody){
					tBody = tData.tiphead; //will try the passed HTML5 data attribute of the element if it's there
				}
			}
			return tBody;
		}
		
		//if the header is empty, it makes that display none, so that it doesn't mess anything up
		isHeader = function(){
			var yes = 'block';
			if(tipH.html() == '') {
				yes = 'none';
			}
			tipH.css({'display':yes});
		}
		
		//places the tip in the correct place on the screen based on the tipPosition value, defaults to right side
		tipPlace = function(eHeight,eWidth,tt){
			var topOff = tip.height(),
				defX = dds.xOffSet,
				defY = dds.yOffSet,
				tOff = $(tt).offset(),
				xTip = (eWidth + tOff.left) + defX,
				yTip = (tOff.top) - defY,
				userTip = dds.tipPosition.toLowerCase();
				if(dds.inlineParse == true){	//if inlineParse is true, look inside the element's data object for values, if they exist, use them, otherwise fall back to the defaults
					var $t = $(tt).data();
					if($t.tipposition){
						userTip = $t.tipposition.toLowerCase();
					}
					if($t.xoffset){
						defX = $t.xoffset;
					}
					if($t.yoffset){
						defY = $t.yoffset;
					}
				}

			tip.removeClass().addClass('JSONtip tipRight '+dds.tipClass);		//reset the tip to dds -|- Right side of element

			//if the user overrides it to be certain position
			switch (userTip) {
				case 'left':
					xTip = (tOff.left - tip.width()) - defX;
					tip.removeClass('tipRight').addClass('tipLeft');	//move the arrow to face right now
					break;
				case 'topleft':
					xTip = (tOff.left) + defX;
					yTip = (tOff.top - topOff) - defY;
					tip.removeClass('tipRight').addClass('tipTopLeft');
					break;
				case 'topright':
					xTip = (tOff.left - tip.width())+ eWidth - defX;
					yTip = (tOff.top - topOff) - defY;
					tip.removeClass('tipRight').addClass('tipTopRight');
					break;
				case 'topcenter':
					xTip = (tOff.left + eWidth /2) - (tip.width() / 2) - defX;
					yTip = (tOff.top - topOff) - defY;
					tip.removeClass('tipRight').addClass('tipTopCenter');
					break;
				case 'bottomleft':
					xTip = (tOff.left) + defX;
					yTip = (tOff.top + eHeight) + defY;
					tip.removeClass('tipRight').addClass('tipBottomLeft');
					break;
				case 'bottomright':
					xTip = (tOff.left - tip.width())+ eWidth - defX;
					yTip = (tOff.top + eHeight) + defY;
					tip.removeClass('tipRight').addClass('tipBottomRight');
					break;
				case 'bottomcenter':
					xTip = (tOff.left + eWidth /2) - (tip.width() / 2) - defX;
					yTip = (tOff.top + eHeight) + defY;
					tip.removeClass('tipRight').addClass('tipBottomCenter');
					break
				default:
					xTip = (tOff.left + eWidth) + defX;
					break;
			}
			
			tip.css({
				'top':yTip,
				'left':xTip,
				'dispaly':'block'
			});
		}
		
		//if the position of the tip puts the right edge of the tip off the screen, it moves the tip to be left aligned
		tipMovePos = function(tt){
			var ap = dds.autoPosition;
			if($(tt).data('autoposition') != dds.autoPosition){
				if($(tt).data('autoposition') == true || $(tt).data('autoposition') == false){
					ap = $(tt).data('autoposition');
				}
			}
			if(ap == false) {
				//if the user sets auto positioning of the tip to false, just return
				return;
			}
			var tPos = tip.offset(),
				newLeft = tPos.left,	//current left position of tip
				newTop = tPos.top,	//current top position of tip
				wL = window.innerWidth,		//window width
				wH = window.innerHeight,	//window height
				tW = tip.outerWidth(),		//width of the tip (include margin + border
				tH = tip.outerHeight(),		//height of the tip (include margin + border
				tR = tPos.left + tW,		//right position of the tip
				tL = newLeft,				//left position of the tip
				tB = tPos.top + tH,			//bottom position of the tip
				tT = newTop,				//top position of the top
				defX = dds.xOffSet,			//default offset X
				defY = dds.yOffSet;			//default offset Y
				if(dds.inlineParse == true){	//if inlineParse is true, look inside the element's data object for values, if they exist, use them, otherwise fall back to the defaults
					var $t = $(tt).data();
					if($t.xoffset){
						defX = $t.xoffset;
					}
					if($t.yoffset){
						defY = $t.yoffset;
					}
				}

			if(tR > wL){	//if the right side of the tip is off the screen, move the tip to be on the left side of the element
				newLeft = (xOff - tW) - defX;	//new left position of the tip
				if(tip.hasClass('tipBottomLeft')) {
					newLeft = (xOff - tW) + defX;
					tip.removeClass('tipBottomLeft').addClass('tipBottomRight');
				}
				else if(tip.hasClass('tipTopLeft')){
					newLeft = (xOff - tW) + defX;
					tip.removeClass('tipTopLeft').addClass('tipTopRight');
				}
				else if(tip.hasClass('tipRight')){
					tip.removeClass('tipRight').addClass('tipLeft');
				}
			}
			else if(newLeft < 0){	//if left side of the tip is off the screen, move the tip to be on the right side of the element
				newLeft = (tt.offsetWidth - defX);
				if(tip.hasClass('tipTopRight')){
					tip.removeClass('tipTopRight').addClass('tipTopLeft');
				}
				else if(tip.hasClass('tipBottomRight')){
					tip.removeClass('tipBottomRight').addClass('tipBottomLeft');
				}
				else if(tip.hasClass('tipLeft')){
					newLeft = (tt.offsetWidth + eW + defX);
					tip.removeClass('tipLeft').addClass('tipRight');
				}
			}
			tip.css({
				'left':newLeft,
				'top':newTop
			});
		}
		
		//sets the position of the top if it needs to move, and fades it in
		tipShow = function(tt){
			isHeader();
			tip.css({
				'zIndex':9000,
				'display':'block'
			});
			tipMovePos(tt);
			tip.fadeIn(dds.fadeInSpeed);
		}
		
		//fades out the tip
		function tipHide(){tip.fadeOut(dds.fadeOutSpeed);}
		
		//makes an AJAX call to return JSON formatted data to populate the tip
		function JSONcall(){
			var code = tData.code ? tData.code : dds.jsonData,
				url = dds.json;
			$.getJSON(url,{
					code: code
				},
				function(js){
					t.data('json',js);
				}
			);
		}
	});
}
})(jQuery, document, this);