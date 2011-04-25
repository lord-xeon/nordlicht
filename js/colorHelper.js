/* Plugin for jQuery for working with colors.
  
  Version 2.0
  Modified flot.colorhelper.js to be more universally usefull
  Released under the MIT license by Ole Laursen, October 2009.
  Inspiration from jQuery color animation plugin by John Resig.
 
  Released under the MIT license by Stephen Giorgi (c) 2011.
  
  Takes a variety of color values and returns a object with the H,S,L,R,G,B,A, & HEX values for it
  Accepts a string or object.

	========================
			Usage:
	========================
	$.colorHelp.parse() understands the following input values:
		#fff | fff | #3d3d3d | 3d3d3d
		rgba(255,255,255,1)
		rgba(100%,100%,100%,1)
		rgb(0,0,0,1)
		rgb(0%,0%,0%,1)
		hsla(0,0%,20%,1)
		hsl(0,0%,20%)
		(almost)any named color
		
		===============
			Notes:
		===============
		 + these must all be strings
		 + the # is not required for a hex value, but it understands it either way
		 + if you give it a full hex, or a half hex it will understand it and give the correct value
		 + there can be any number of spaces between the values & ()'s, so long as the commas exist
		 + the full list of named colors is at the end of this flie in the namedColors obj
	
	$.colorHelp.parse("#AB2164")
	returns = {
		a: 1
		b: 100
		g: 33
		h: 331
		hex: "AB2164"
		l: 40
		original: "AB2164"
		r: 171
		s: 68
		type: "fullHex"
	}

	The returned object from $.colorHelp.parse() also has 3 functions on it:
	lighter(int), darker(int), opposite();
	
	Those functions will return a new color object:
	that's 10% [or your choice] lighter
	that's 10% [or your choice] darker
	that's the opposite color of the given
	
	You can also calculate the colors 
  
*/ 
(function($) {
    $.colorHelp = {};
	
	$.colorHelp.make = function(color){
		var co = {};
		co = color;
		
		/* lighter(int)	- makes the color 10% or [diff] lighter
		 * returns new color obj 10% lighter with new r,g,b,&hex values
		 */
		co.lighter = function(diff){
			dif = diff ? diff : 10;
			return $.colorHelp.newHue(this,diff);
		};
		
		/* darker(int)	- makes the color 10% or [diff] darker
		 * returns new color obj 10% lighter with new r,g,b,&hex values
		 */
		co.darker = function(diff){
			dif = diff ? diff : 10;
			return $.colorHelp.newHue(this,-dif);
		};
		/* opposite()	- gets the opposite color from the current one
		 * returns new color obj with all the new values
		 */
		co.opposite = function(){
			return $.colorHelp.getOpposite(this);
		}
		
		return co;
	};
	
	$.colorHelp.parse = function(color){
		var c = {},
			r = {
				rgbaNum:/rgba\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]+(?:\.[0-9]+)?)\s*\)/,
				rgbNum:/rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/,
				rgbaPer:/rgba\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\s*\)/,
				rgbPer:/rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/,
				hslaNum:/hsla\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\%*\s*,\s*([0-9]{1,3})\%*\s*,\s*([0-9]+(?:\.[0-9]+)?)\s*\)/,
				hslNum:/hsl\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\%*\s*,\s*([0-9]{1,3})\%*\s*\)/,
				fullHex:/([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/,
				halfHex:/([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/
			},
			hsl = rgb = null;
			
		if(typeof(color) == 'string'){
			$.each(r,function(i,v){
				var pl = v.exec(color);
				if(pl){
					switch(i){
						case 'fullHex':
							c.r = parseInt(pl[1], 16);
							c.g = parseInt(pl[2], 16);
							c.b = parseInt(pl[3], 16);
							c.hex = color;
							c.type = i;
							break;
						case 'halfHex':
							c.r = parseInt(pl[1]+pl[1], 16);
							c.g = parseInt(pl[2]+pl[2], 16);
							c.b = parseInt(pl[3]+pl[3], 16);
							c.hex = color;
							c.type = i;
							break;
						case 'hslaNum':
							c.h = Math.round(parseFloat(pl[1]));
							c.s = Math.round(parseFloat(pl[2]));
							c.l = Math.round(parseFloat(pl[3]));
							c.l = Math.round(parseFloat(pl[4]));
							break;
						case 'hslNum':
							c.h = Math.round(parseFloat(pl[1]));
							c.s = Math.round(parseFloat(pl[2]));
							c.l = Math.round(parseFloat(pl[3]));
							c.type = i;
							break;
						default:
							var m = 1;
							if(i.match('Per')){
								m = 2.55;
							}
							c.r = Math.round(parseFloat(pl[1])*m);
							c.g = Math.round(parseFloat(pl[2])*m);
							c.b = Math.round(parseFloat(pl[3])*m);
							c.a = parseFloat(pl[4]);
							c.type = i;

							//convert the color to HSL format
							hsl = $.colorHelp.RGBtoHSL(c);
							
							//calculate the HEX code of the color
							c.hex = $.colorHelp.RGBtoHEX(c);
					}	//end switch statement
					return false;
				}
			});
		}
		else if(typeof(color) == 'object'){
			c = color;
			if(!c.r && c.h) {
				rgb = $.colorHelp.HSLtoRGB(c);
				c.r = rgb.r;
				c.g = rgb.g;
				c.b = rgb.b;
			}
			if(!c.hex){
				c.hex = $.colorHelp.RGBtoHEX(c);
			}
			c.type = 'colorObj';
		}
		
		if(c.type == 'halfHex' || c.type== 'fullHex'){
			hsl = $.colorHelp.RGBtoHSL(c);
		} else if(c.type == 'hslaNum' || c.type == 'hslNum') {
			rgb = $.colorHelp.HSLtoRGB(c);
			c.hex = $.colorHelp.RGBtoHEX(rgb);
			c.r = rgb.r;
			c.g = rgb.g;
			c.b = rgb.b;
		} else if(!c.type) {
			c.type = 'named';
			$.each(namedColors, function(i,v){
				if(i == color.toLowerCase()){
					c.r = v.r;
					c.g = v.g;
					c.b = v.b;
					c.hex = v.hex;
					hsl = $.colorHelp.RGBtoHSL(c);
					return false;
				}
			});
		}
					
		//Set the HSL colors only if there's something in hsl
		if(hsl){
			c.h = hsl.h;
			c.s = hsl.s;
			c.l = hsl.l;
		}
		
		//set the original color given
		c.original = color;
		
		//if no alpha channel is given set it to 1
		c.a = c.a ? c.a : 1;
		
		//if the alpha channel is set to more then 1 for some reason, lower it to 1
		c.a = (c.a > 1) ? 1: c.a;
		
		return $.colorHelp.make(c);
		
	};

	/* HSLtoRGB(obj) - Converts an HSL color value to RGB.
	 * adapted from: http://mjijackson.com/2008/02/rgb-to-hsl-and-rgb-to-hsv-color-model-conversion-algorithms-in-javascript
	 * Conversion formula adapted from http://en.wikipedia.org/wiki/HSL_color_space
	 * 
	 * returns color object with r,g,b values
	 */
	$.colorHelp.HSLtoRGB = function(color){
		var r, g, b, a =1,
			h = color.h / 360,
			s = color.s / 100,
			l = color.l / 100;
		
		if(s == 0){
			r = g = b = l; // achromatic
		} else {
			function hue2rgb(p, q, t){
				if(t < 0) t += 1;
				if(t > 1) t -= 1;
				if(t < 1/6) return p + (q - p) * 6 * t;
				if(t < 1/2) return q;
				if(t < 2/3) return p + (q - p) * (2/3 - t) * 6;
				return p;
			}
		
			var q = l < 0.5 ? l * (1 + s) : l + s - l * s;
			var p = 2 * l - q;
			r = hue2rgb(p, q, h + 1/3);
			g = hue2rgb(p, q, h);
			b = hue2rgb(p, q, h - 1/3);
		}
		rgba = {
			r:Math.round(r*255),
			g:Math.round(g*255),
			b:Math.round(b*255),
			a:a
		}
		return rgba;
	}

	/* RGBtoHSL(obj)	-  Converts an RGB color calue to HSL
	 *	adapted from: http://mjijackson.com/2008/02/rgb-to-hsl-and-rgb-to-hsv-color-model-conversion-algorithms-in-javascript
	 * Converts an RGB color value to HSL
	 * Conversion formula adapted from http://en.wikipedia.org/wiki/HSL_color_space
	 * 
	 * returns color object with h,s,l values
	 */
	$.colorHelp.RGBtoHSL = function(color){
		var r = color.r,
			g = color.g,
			b = color.b,
			hsla = {},
			a = 1;
		
		r /= 255, g /= 255, b /= 255;
		var max = Math.max(r, g, b), min = Math.min(r, g, b);
		var h, s, l = (max + min) / 2;
	
		if(max == min){
			h = s = 0; // achromatic
		}else{
			var d = max - min;
			s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
			switch(max){
				case r: h = (g - b) / d + (g < b ? 6 : 0); break;
				case g: h = (b - r) / d + 2; break;
				case b: h = (r - g) / d + 4; break;
			}
			h /= 6;
		}
		hsla = {
			h:Math.round(h*360),
			s:Math.round(s*100),
			l:Math.round(l*100),
			a:a
		}
	
		return hsla;
	}
	
	/* RGBtoHEX(obj)	- turns an r,g,b color object into it's HEX value
	 * returns the HEX value of the given color - note there is no # symbol attached to it
	 */
	$.colorHelp.RGBtoHEX = function(color){
		function toHex(n) {
			n = parseInt(n,10);
			if(isNaN(n)){
				return "00";
			}
			n = Math.max(0,Math.min(n,255));
			return "0123456789ABCDEF".charAt((n-n%16)/16) + "0123456789ABCDEF".charAt(n%16);
		}

		return toHex(color.r)+toHex(color.g)+toHex(color.b);
	}
	
	/* newHue(obj,int)	- turns the color lighter/darker based on the diff
	 * returns new color object with new r,g,b,h,s,l&hex values set
	 */
	$.colorHelp.newHue = function(color,diff){
		var t = color,
			dif =  diff ? diff : 10,
			rgb = null;
		t.l  = Math.round(parseInt(t.l + dif));
		rgb = $.colorHelp.HSLtoRGB(t);
		t.r = rgb.r;
		t.g = rgb.g;
		t.b = rgb.b;
		t.hex = $.colorHelp.RGBtoHEX(t);
		return t;
	}
	
	/* getOpposite(obj)	- gets the opposite color on the color wheel and returns a $.colorHelp obj with the new values
	 * returns obbosite color obj
	 */
	$.colorHelp.getOpposite = function(color){
		var c = $.colorHelp.getColor(color),
		hsl = '';
		//the opposite color
		c.h = c.h +180;
		
		hsl = 'hsl('+c.h+','+c.s+'%,'+c.l+'%)';

		return $.colorHelp.parse(hsl);
	};
	 
	/*getColor(obj||str)	- helper function - takes a string, or object and converts it to the color object to be used throughout the plugin
	 * return c, or color object
	 */
	$.colorHelp.getColor = function(color){
		var c = color;
		//if we are passed an object - such as one from $.colorHelp.opposite() then we don't need to parse the string
		if(typeof (color) == 'object'){
			/* All of the interesting calculations are done on the HSL values
			* If there's no h value we can assume it's missing the stuff we need
			* So turn it into one
			*/
			if(!color.h) {
				c = $.colorHelp.parse(color);
			}
		//if it's not an object it must be a color string
		} else {
			c = $.colorHelp.parse(color);
		}
		
		return c;
	}

	/* extract()	- gets the CSS color property from an element
	 * if it's "transparent" continue up the DOM until one is found
	 */
    $.colorHelp.extract = function (elem, css) {
        var c;
        do {
            c = elem.css(css).toLowerCase();
            // keep going until we find an element that has color, or
            // we hit the body
            if (c != '' && c != 'transparent')
                break;
            elem = elem.parent();
        } while (!$.nodeName(elem.get(0), "body"));

        // catch Safari's way of signalling transparent
        if (c == "rgba(0, 0, 0, 0)")
            c = "transparent";
        
        return $.colorHelp.parse(c);
    }
	
	/* Named Colors object
	 * Since these colors are known we can set the r,g,b & hex values without any math
	 *
	 * TODO - add h,s,l values to colors so that no math needs to be done
	 * TODO - add missing colors
	 */
    var namedColors = {
        aqua:		{ r:0,	g:255,	b:255,	hex:'00ffff' },
        azure:		{ r:240,g:255,	b:255,	hex:'f0ffff' },
        beige:		{ r:245,g:245,	b:220,	hex:'f5f5dc' },
        black:		{ r:0,	g:0,	b:0,	hex:'000'	},
        blue:		{ r:0,	g:0,	b:255,	hex:'00f'},
        brown:		{ r:165,g:42,	b:42,	hex:'A52A2A' },
        cyan:		{ r:0,	g:255,	b:255,	hex:'00FFFF' },
        darkblue:	{ r:0,	g:0,	b:139,	hex:'00008B' },
        darkcyan:	{ r:0,	g:139,	b:139,	hex:'008B8B' },
        darkgray:	{ r:169,g:169,	b:169,	hex:'A9A9A9' },
        darkgrey:	{ r:169,g:169,	b:169,	hex:'A9A9A9' },
        darkgreen:	{ r:0,	g:100,	b:0,	hex:'006400' },
        darkkhaki:	{ r:189,g:183,	b:107,	hex:'BDB76B' },
        darkmagenta:{ r:139,g:0,	b:139,	hex:'8B008B' },
        darkolivegreen:	{ r:85,	g:107,	b:47,	hex:'556B2F' },
        darkorange:	{ r:255,g:140,	b:0,	hex:'FF8C00' },
        darkorchid:	{ r:153,g:50,	b:204,	hex:'9932CC' },
        darkred:	{ r:139,g:0,	b:0,	hex:'8B0000' },
        darksalmon:	{ r:233,g:150,	b:122,	hex:'E9967A' },
        darkviolet:	{ r:148,g:0,	b:211,	hex:'9400D3' },
        fuchsia:	{ r:255,g:0,	b:255,	hex:'FF00FF' },
        gold:		{ r:255,g:215,	b:0,	hex:'FFD700' },
		gray:		{ r:128,g:128,	b:128,	hex:'808080' },
		grey:		{ r:128,g:128,	b:128,	hex:'808080' },
        green:		{ r:0,	g:128,	b:0,	hex:'008000' },
        indigo:		{ r:75,	g:0,	b:130,	hex:'4B0082' },
        khaki:		{ r:240,g:230,	b:140,	hex:'F0E68C' },
        lightblue:	{ r:173,g:216,	b:230,	hex:'ADD8E6' },
        lightcyan:	{ r:224,g:255,	b:255,	hex:'E0FFFF' },
        lightgray:	{ r:211,g:211,	b:211,	hex:'D3D3D3' },
        lightgrey:	{ r:211,g:211,	b:211,	hex:'D3D3D3' },
        lightgreen:	{ r:144,g:238,	b:144,	hex:'90EE90' },
        lightpink:	{ r:255,g:182,	b:193,	hex:'FFB6C1' },
        lightyellow:{ r:255,g:255,	b:224,	hex:'FFFFE0' },
        lime:		{ r:0,	g:255,	b:0,	hex:'00FF00' },
        magenta:	{ r:255,g:0,	b:255,	hex:'FF00FF' },
        maroon:		{ r:128,g:0,	b:0,	hex:'800000' },
        navy:		{ r:0,	g:0,	b:128,	hex:'000080' },
        olive:		{ r:128,g:128,	b:0,	hex:'808000' },
        orange:		{ r:255,g:165,	b:0,	hex:'FFA500' },
        pink:		{ r:255,g:192,	b:203,	hex:'FFC0CB' },
        purple:		{ r:128,g:0,	b:128,	hex:'800080' },
        red:		{ r:255,g:0,	b:0,	hex:'FF0000' },
        silver:		{ r:192,g:192,	b:192,	hex:'C0C0C0' },
        violet:		{ r:128,g:0,	b:128,	hex:'EE82EE' },
        white:		{ r:255,g:255,	b:255,	hex:'fff' },
        yellow:		{ r:255,g:255,	b:0,	hex:'FFFF00' }
    };
})(jQuery);
