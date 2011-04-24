/*
@1 - Prototype extensions
@2 - Global Functions
@3 - Tab specific functions
*/

//@1 Prototype extensions

//adds commas in the correct places of a number string
String.prototype.addCommas = function(){
	var rgx = /(\d+)(\d{3})/,
		x,
		x1,
		x2,
		nStr = this;
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	while(rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

//gets the max in an Array
Array.prototype.getMax = function(){
    return Math.max.apply(Math,this);
};
//gets the min in an Array
Array.prototype.getMin = function(){
    return Math.min.apply(Math,this);
};


/* function byteSize()	= returns human readable KB/MB/GB size
 *	byte	= int
 */
function byteSize(byte){
	var sz = (parseInt(byte)) /1024;
	if(sz < 1024){
		sz = sz.toFixed(2);
		sz += ' KB';
	} else {
		if(sz/1024 < 1024){
			sz = (sz/1024).toFixed(2);
			sz += ' MB';
		} else {
			(sz/1024/1024).toFixed(3);
			sz = addCommas(sz);
			sz += ' GB';
		}
	}
	return sz;
}

function byteSizeTick(v,axis){
	return byteSize(v.toFixed(axis.tickDecimals));
}

function numAxes(flotO,n,data){
	var ax = {};
	flotO.yaxis = {};
	if(!flotO.yaxes){
		flotO.yaxes = {};
	}
	ax.max = data.getMax();
	ax.min = data.getMin();
	flotO.yaxes[n] = [];
	flotO.yaxes[n].push(ax);
//	flotO.yaxis.
	return flotO;
}

function chartData(flotD,what){
	var $t = what,
		td = $t.data();
	$t.addClass('graphed');
	
	flotD['label'] = $t.html();
	flotD['data'] = td.chartdata;
	flotD['color'] = td.chartcolor;
	flotD[td.charttype] = {show:true};				
	return flotD;
}


/* pieClick(event, position clicked, chart-obj)	- click event for Pie charts - creates a donut shaped chart out of the minor detail data
 *
 */
function pieClick(event, pos, obj) {
	if(!obj || obj.series.label == 'All Others') {
		return;
	}
	var percent = parseFloat(obj.series.percent).toFixed(2),
		baseColor = $.color.parse(obj.series.color),
		mv = $.parseJSON($("#browser .minorHolder").html()),
		rg = '',
		minorDD = [],
		diff = 0;
		
	$.each(mv, function(nm, dd){
		rg = new RegExp(obj.series.label);
		if(nm.match(rg)){
			diff += 10;
			if(obj.series.label == 'msie' || obj.series.label == 'chrome'){
				diff = -diff;
			}
			newHue = $.color.newHue(baseColor, diff);
			minorDD.push({
				label:nm,
				data:dd,
				color:newHue
			});
		}
	});
	return $.plot($("#browser .minorPlot"),minorDD,flotOps.browserMinor);
}
function osPieClick(event,pos,obj){
	if(!obj || obj.series.label == 'All Others') {
		return;
	}
	var percent = parseFloat(obj.series.percent).toFixed(2),
		baseColor = $.color.parse(obj.series.color),
		mv = $.parseJSON($("#os .minorHolder").html()),
		rg = '',
		minorDD = [],
		diff = 0;
		
	$.each(mv, function(nm, dd){
		rg = new RegExp(obj.series.label);
		if(nm.match(rg)){
			diff += 5;
			newHue = $.color.newHue(baseColor, diff);
			minorDD.push({
				label:nm,
				data:dd,
				color:newHue
			});
		}
	});
	$.plot($("#os .minorPlot"), minorDD, flotOps.osMinor);
}
//@3 Tab specific functions
var oFlot = [];
var tabFuns = {
	browser: {
		sec: 'browser',
		plot: {},
		minorPlot: {},
		startUp: function(){
			var sec = this.sec,
				plot = {};
			$("#" +sec+ " .nStats td:first-child").each(function(i,v){
				var $t = $(this),
					td = $t.data(),
					rd = [];
				oFlot[i] = {
					label:td.piename,
					data:td.pieval,
					color:td.piecolor
					};
				plot = $.plot($("#"+sec+"Plot"),oFlot,flotOps.browser);
			});
			
			$("#"+sec+"Plot").bind("plotclick", pieClick);

			return this.plot = plot;
		}
	},
	hourly: {
		sec: 'hourly',
		startUp: function(){
			var sec = this.sec;
			
		}
		
	},
	monthly: {
		sec:'monthly',
		startUp:function(){
				var sec = '#monthly';
				$(sec+" .nStats th").each(function(i,v){
					var $t = $(this),
						td = $t.data(),
						rd = [],
						day = '',
						flot = {},
						b = {};
					if(td.charton == true){
						$t.addClass('graphed');
						flot = {
							label:$t.html(),
							yaxis:td.chartyaxis,
							color:td.chartcolor,
							data:[]
						};
						if(td.charttype == 'bars'){
							flot.bars = { show:true };
							flot.lines = { show:false };
							flot.points = { show:false };
						}
						console.log(td);
						$(sec +' .nStats td:nth-child('+td.chartid+')').each(function(ind,val){
							day = parseInt(val.parentElement.children[0].dataset.chartdata)*1000;
							rd.push([day, parseInt(val.dataset.chartdata)]);
						});
						flot.data = rd;
						oFlot.push(flot);
					}
				});
				$.plot($("#monthlyFlot"),oFlot,flotOps.monthly);
		}
	},
	searches: {
		sec:'searches',
		startUp: function(sec){
			var sec = this.sec;
			$("#"+sec+" .wordCloud span").each(function(i){
				var $t = $(this),
					td = $t.data(),
					tc = '',
					y = Math.floor(Math.random()*90),	//random number between 0 and 90 [90 choosen so that the max the word will be is 90%, otherwise it shows up outside the box]
					x = Math.floor(Math.random()*90);
				if(!$t.hasClass('wordCloud-max')){
					$t.css({
						bottom:y+'%',	//these are set as percentages so that you can resize the box as you see fit
						left:x+'%'
					});
				}
				//builds the tip content and puts it into the span's .data() attribute
				if(!td['tip-content']){
					var word = $t.html();
					tc = 'The word: <span class="searchTipWord">'+ word +'</span> has been searched for: <span class="searchTipVal">'+ td.searchvalue.toString().addCommas() +'</span> times';
					tc += '<br>Representing <span class="searchTipVal">'+ td.searchpercent + '%</span> of the total search terms';
					td['tip-content'] = tc;
				}
				else {
					tc = td['tip-content'];
				}
				$t.JSONtip({
					'tip-class':'wordCloudTip',		//the wordCloud tip uses a smaller font, and wider tip
					'tip-position':'bottomCenter',	//always want the tip to show up on the bottom center
					'no-close':true,				//we don't want to see the close icon since we're doing a mouse enter event
					'tipbody':tc,					//set the tip body to be the text we built above
					'tip-show-event':'hover'		//we want a hover event for the word cloud
				});
			});
		}
	}
}
