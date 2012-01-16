String.prototype.truncate = function(vl){
	
};
Array.prototype.max = function(){
	return Math.max.apply({},this)
};
Array.prototype.min = function(){
	return Math.min.apply({},this)
};
// JavaScript Document
function Enigma(obj){
	var me = this,
		def = {
			type:"bars",
			chart:{
				topMargin:20,
				rightMargin:10,
				bottomMargin:20,
				leftMargin:10,
				attrs:{
					width:1000,
					height:500,
					id:"chart-u"
				},
				styles:{
					"font-family":'Georgia, "Times New Roman", Times, serif',
					"font-size":"16px"
				}
			},
			defs:[],
			legend:{
				show:true,
				position:"top",
				layout:"horizontal",
				evenSpaced:true,
				styles:{
					"font-size":"16px"
				}
			}
		},
		calDefs,
		cObj = null;
	
	if(obj.type == "calendar"){
		calDefs = {
			funs:{
				day:d3.time.format("%w"),
			    week:d3.time.format("%U"),
			    format:d3.time.format("%Y-%m-%d")
			},
			dims:{
				width:147,
				height:150,
				cell:20
			},
			title:{
				pos:"bottom",
				show:true,
				align:"center",
				capitalize:true,
				styles:{
					"font-size":"18px",
					"text-anchor":"middle"
				}
			},
			boxes:{
				styles:{
					stroke:"#efefef",
					"stroke-width":"1px",
					cursor:"pointer"
				},
				text:{
					show:true,
					styles:{
						stroke:"none",
						fill:"#efefef",
						"font-size":"4px",
						"text-anchor":"end",
						opacity:0
					}
				},
				showDay:true
			},
			hover:true,
			animate:true,
			zoom:{
				old:""
			}
		};
		def.calendar = applyDefaults(calDefs,obj.calendar);
	}
	me.chartDefaults = applyDefaults(def,obj);
	
	me.scales = [];
	me.chartDiv = obj.chartDiv;
	me.chartData = obj.chartData;
	
	cObj = me.chartDefaults.chart;
	me.chartArea = {
		w:cObj.attrs.width - (cObj.leftMargin + cObj.rightMargin),
		h:cObj.attrs.height - (cObj.topMargin + cObj.bottomMargin)
	};
	me.makeChart();
	return me;
};

Enigma.prototype.getSVGBounds = function(){
	var me = this,
		cdc = me.chartDefaults.chart,
		bounds = me.vis[0][0].getBBox();
		
	bounds.height += cdc.topMargin + cdc.bottomMargin;
	bounds.width += cdc.leftMargin + cdc.rightMargin;
	
	me.chartArea.bounds = bounds;
	
	return me;
};

Enigma.prototype.setSVGBounds = function(bounds){
	var me = this,
		h = null,
		w = null;
	
	if(!me.chartArea.bounds){
		me.getSVGBounds();
	}
	w = me.chartArea.bounds.width;
	h = me.chartArea.bounds.height;
	if(bounds){
		if(bounds[0]){
			w = bounds[0];
		}
		if(bounds[1]){
			h = bounds[1];
		}
	}

	me.vis.attr("width",w).attr("height",h);
	
	return me;
};

/* makeChart()	- builds the chart object
 */
Enigma.prototype.makeChart = function(){
	var me = this,
		chartVis = null,
		opts = me.chartDefaults;
	console.log("new chart is being made...");
	
	me.vis = d3.select(me.chartDiv).append("svg:svg");
	
	//apply the attributes & styles to the svg node
	applyAttrs(me.vis,opts.chart.attrs);
	applyStyles(me.vis,opts.chart.styles);
	
	opts.defs.forEach(function(val,ind){
		if(val.type == "gradient"){
			me.addGradient(val.options);
		}
	});
	if(opts.type == "map"){
		return;
	} else if(opts.type == "tree"){
		if(typeof(me._treeBuilder) == "undefined"){
			console.log("You must include Enigma.tree.js in order to use the tree setting");
		} else {
			me._treeBuilder();
		}
		return;
	} else if(opts.type == "calendar"){
		if(typeof(me._calenderBuilder) == "undefined"){
			console.log("You must include Enigma.calender.js in order to use the calender setting");
		} else {
			me._calenderBuilder();
		}
		return;
	}
	
	me.calcScales();
	chartVis = 	me.vis.append("svg:g").attr("class","chart-holder");
	me.chartHolderVis = chartVis;
	
	if(opts.legend.show){
		me.addLegend();
	}

	me.chartDefaults.series.forEach(function(val,ind){
		val.id = ind;
		val.vis = chartVis;
		if(val.type == "bar"){
			me.buildBars(val);
		} else if(val.type == "line"){
			me.buildLine(val);
		}
	});
	
	if(opts.legend.show){
		me.addTooltip(chartVis);
	}
	setTimeout(function(){
		me.getSVGBounds();
		me.setSVGBounds();
	},1000);
	
	return me;
};

Enigma.prototype.addTooltip = function(vis){
	var me = this,
		bh = me.chartArea.h - me.chartDefaults.chart.topMargin,
		barW = d3.scale.ordinal()
					.domain(d3.range(me.chartData.length))
					.rangeBands([0,(me.chartArea.w - me.chartDefaults.chart.leftMargin)],0.35),
		tooltip = vis.append("svg:g").attr("class","tooltip-holder");
		
	tooltip.selectAll("g.nothing")
		.data(me.chartData).enter()
		.append("svg:rect")
		.attr("class","tooltip-rect")
		.attr("x",function(d,i){
			return barW(i);
		})
		.attr("y",me.chartDefaults.chart.topMargin)
		.attr("height",bh).attr("width",barW.rangeBand())
		.style("fill","rgba(0,0,0,0)")
		.call(me.hoverBar,me);
};

Enigma.prototype.addLegend = function(){
	var me = this,
		opts = me.chartDefaults,
		lopts = opts.legend,
		lTop = 0, lLeft = 0,
		lWidth = 0, lHeight = 0,
		lFSize = parseInt(lopts.styles["font-size"]),
		dx = 10,
		legendVis = me.chartHolderVis.append("svg:g")
						.attr("class","legend");
	
	lHeight = parseInt(lopts.styles["font-size"]) * 1.2;
	lWidth = me.chartArea.w;
	me.chartArea.h -= lHeight;
				
	if(lopts.position == "top"){
			lTop = 0;
	} else if(lopts.position == "bottom"){
		lTop = opts.chart.attrs.height - lHeight;
	}
	if(opts.type == "calendar"){
		lWidth = me.chartArea.w - opts.calendar.dims.width;
	}
	
	legendVis.append("svg:rect")
			.attr("y",lTop)
			.attr("x",lLeft)
			.attr("width",lWidth)
			.attr("height",lHeight)
			.style("fill","none");
	var tip = 	legendVis.append("svg:g")
					.attr("class","tip-holder")
					.append("svg:text")
					.attr("x",lLeft + 10)
					.attr("y",lTop + lHeight);

	lopts.tips.forEach(function(val,ind){
		var color = "#2a2a2a",
			tspan = null;
		opts.series.map(function(vv,ii){
			if(vv.dataType == val.dataType){
				color = vv.color;
			}
		});
		if(lopts.evenSpaced && ind != 0 && opts.type != "calendar"){
			dx += (val.name.length * lFSize) + 10 + (6 * lFSize);
		}
		if(opts.type == "calendar"){
			dx += opts.calendar.dims.width;
		}
		tspan = tip.append("svg:tspan")
					.attr("class",val.dataType +" tip-metric")
					.attr("x",dx)
					.attr("y",lTop + lHeight)
					.text(val.name)
					.style("fill",color)
					.append("svg:tspan")
					.attr("class","tip-value")
					.attr("dx",10)
					.style("fill",d3.rgb(color).darker());	//make the value darker
		applyStyles(tspan,val.styles);
	});
	me.legendVis = legendVis;
	return me;
};

Enigma.prototype.buildBars = function(seriesObj){
	var me = this,
		bh = me.chartArea.h,
		axisObj = me.chartDefaults.axis.x,
		chartVis = seriesObj.vis.append("svg:g")
						.attr("class","bar-chart-holder"),
		chartBg = chartVis.append("svg:rect"),
		chartAxis = chartVis.append("svg:g")
						.attr("class","axis-holder"),
		chartArea = chartVis.append("svg:g")
						.attr("class","bar-area"),
		chartD = chartArea.selectAll("g.nothing")
						.data(me.chartData).enter(),
		numGroups = (seriesObj.group) ? me.totalGroups : 1,
		barW = d3.scale.ordinal()
					.domain(d3.range(me.chartData.length))
					.rangeBands([0,(me.chartArea.w - me.chartDefaults.chart.leftMargin)],0.35),
		barH = d3.scale.linear()
					.domain(me.scales[seriesObj.id].bounds)
					.range([0,(bh - me.chartDefaults.chart.topMargin)]);

	chartD.append("svg:rect")
			.attr("x",function(d,i){
				var x = barW(i)
				return x;
			})
			.attr("transform",function(d,i){
				var tx = 0;
				if(seriesObj.group){
					tx = seriesObj.groupId * (barW.rangeBand() / 2);
				}
				return "translate("+tx+",0)";
				//var x = barW(i + seriesObj.groupId) - ((barW.rangeBand() / 2) * seriesObj.groupId);
				//return "translate(" +x+ ",0)";
			})
			.attr("y",function(d,i){
				return bh;
			})
			.attr("height",0)
			.attr("width",function(d,i){
				var w = barW.rangeBand();
				if(seriesObj.group){
					w /= 2;
				}
				return w;
			})
			.transition().duration(500).ease("circle")
			.delay(function(d,i){
				return i * 25
			})
			.attr("y",function(d,i){
				return (bh - barH(d[seriesObj.dataType]));
			})
			.attr("height",function(d,i){
				return barH(d[seriesObj.dataType]);
			});

	applyStyles(chartArea,seriesObj.styles);
		
	//* build the x-axis
	var axis = {
			vis:chartAxis,
			scale:barW,
			options:axisObj[seriesObj.id]
		};
	me.buildXAxis(axis);

	me.chartVis = chartVis;

	return me;
};

Enigma.prototype.buildXAxis = function(axis){
	var me = this,
		ax = null;

	if(typeof(axis.options) == "undefined" || typeof(axis.options.orient) == "undefined"){
		return;
	}
	ax = d3.svg.axis().scale(axis.scale)
				.orient(axis.options.orient)
				.ticks(axis.options.ticks)
				.tickSize(10,4,1)
				.tickFormat(axis.options.formatter);

	axis.vis.call(ax).attr("transform","translate(0,"+me.chartArea.h+")");
};

Enigma.prototype.buildLine = function(seriesObj){
	var me = this,
		bh = me.chartArea.h,
		co = me.chartDefaults.chart,
		axisObj = me.chartDefaults.axis.x,
		chartVis = seriesObj.vis.append("svg:g")
						.attr("class","line-chart-holder"),
		chartBg = chartVis.append("svg:rect"),
		chartAxis = chartVis.append("svg:g")
						.attr("class","axis-holder"),
		chartArea = chartVis.append("svg:g")
						.attr("class","line-area"),
		chartD = chartArea.selectAll("g.nothing")
						.data([me.chartData]).enter(),
		barW = d3.scale.ordinal()
					.domain(d3.range(me.chartData.length))
					.rangeBands([0,(me.chartArea.w - me.chartDefaults.chart.leftMargin)],0.35),
		barH = d3.scale.linear()
					.domain(me.scales[seriesObj.id].bounds)
					.range([0,(me.chartArea.h - me.chartDefaults.chart.topMargin)]),
		line = d3.svg.line()
						.x(function(d,i){
							return barW(i) + (barW.rangeBand() / 2);
						})
						.y(function(d,i){
							return (bh - barH(d[seriesObj.dataType]));
						})
						.interpolate(seriesObj.interpolate);

	chartD.append("svg:path").attr("d",line);

	applyStyles(chartArea,seriesObj.styles);

	chartD.append("svg:rect")
			.attr("x",co.leftMargin)
			.attr("y",co.topMargin)
			.attr("height",me.chartArea.h - co.bottomMargin)
			.attr("width",me.chartArea.w - co.rightMargin)
			.style("fill","#fff").style("stroke","none")
			.transition().duration(700).ease("circle")
			.attr("x",me.chartArea.w - co.rightMargin)
			.attr("width",0);

	//build the x-axis
	var axis = {
			vis:chartAxis,
			scale:barW,
			options:axisObj[seriesObj.id]
		};
	me.buildXAxis(axis);
	return me;
};

Enigma.prototype.calcScales = function(){
	var me = this,
		group = 0;
	
	me.chartDefaults.series.forEach(function(val,ind){
		//group the bars if given
		if(val.group){
			group++;
		}
		var scale = {
				bounds:getBounds(me.chartData,val.dataType)
			};
		me.scales.push(scale);
	});
	me.totalGroups = group;
	return me;
};

/* hoverBar(d3.selection(),me)	- when you hover over the d3.selection() populate the legend with the correct infor
 */
Enigma.prototype.hoverBar = function(sel,me){
	sel.on("mouseover",function(d,i){
		var lopts = me.chartDefaults.legend;
		
		lopts.tips.forEach(function(val,ind){
			var txt = val.formatter(d[val.dataType],i);
			me.legendVis.select("tspan."+val.dataType)
				.select("tspan").text(txt);
		});
	});
};


Enigma.prototype.applySeriesDefaults = function(def,type){
	var me = this;
	me.chartDefaults[type].forEach(function(val,ind){
		val.styles = applyDefaults(def,val.styles);
	});
};
Enigma.prototype.applySeriesDefaults = function(def){
	var me = this;
	me.chartDefaults.series.forEach(function(val,ind){
		val.styles = applyDefaults(def,val.styles);
	});
};

Enigma.prototype.addDefs = function(){
	var me = this,
		defs = me.vis.append("svg:defs");
	
	me.defs = defs;
	return me;
};

Enigma.prototype.addGradient = function(gra){
	var me = this;
	
	if(!me.defs){
		me.addDefs();
	}
	gradient = me.defs.append("svg:"+gra.type)
					.attr("id",gra.id);
	applyAttrs(gradient,gra.attrs);
	applyStyles(gradient,gra.styles);
	gra.stops.forEach(function(val,ind){
		var stp = gradient.append("svg:stop");
		
		applyAttrs(stp,val.attrs);
		applyStyles(stp,val.styles);
	});
	
	return me;
};

/* Helper functions
 */
function applyDefaults(def,user){
	var defaults = def;
	for(elm in user){
		if(elm == "chartDiv" || elm == "chartData" || elm == "calendar"){
			continue;
		}
		if(typeof(user[elm]) == "object" && defaults[elm]){
			applyDefaults(defaults[elm],user[elm]);
		}
		defaults[elm] = user[elm];
	}
	return defaults;
};

function applyAttrs(vis,attrs){
	for(att in attrs){
		vis.attr(att,attrs[att]);
	}
};

function applyStyles(vis,styles){
	for(sty in styles){
		vis.style(sty,styles[sty]);
	}
};
function getBounds(data,vl){
	var what = new Array(),
		mi = 0,
		ma = 0;
	data.forEach(function(val,ind){
		what.push(parseFloat(val[vl]));
	});
	mi = what.min();
	ma = what.max();
	if(ma == 0){
		ma = 0.1;
	}
	mi = 0;
	return [mi,ma];
};
/**/

/* addKs(int,int)	- adds K|M|B|T to a number and gives number of decimle places
	example:	addKs(123,456,2) returns 123.46K
				addKs(23124455234,5) returns 23.12446B
 */
function addKs(num,places){
	var val = parseFloat(num),
		post = "",
		k = 0;
	if(isNaN(val)){
		val = "undefined";
	} else {
		while(val > 1000){
			val /= 1000;
			k++;
		}
		switch(k){
			case 0:
				post = "";
				break;
			case 1:
				post = "K"
				break;
			case 2:
				post = "M"
				break;
			case 3:
				post = "B"
				break;
			case 4:
				post = "T"
				break;
		}
		val = formatNumber(val,places);
	}
	return val + post;
};

/* formatNumber(int,int)	- formats a number to the given decimle places
 */
function formatNumber(num,places){
	var val = parseFloat(num);
	if(isNaN(val)){
		val = "undefined";
	} else {
		val = val.toFixed(places);
	}
	return val;
}

/*byteSize()	- turns a number of bytes into a human readable value perfexed with KB/MB/GB
	$bytes		- input value
	
	return		= human readable value to 2 decimal places with KB/MB/GB added
*/
function byteSize(bytes,places) {
	var val = parseFloat(bytes),
		post = "",
		k = 0;
	if(isNaN(val)){
		val = "undefined";
	} else {
		while(val > 1024){
			val /= 1024;
			k++;
		}
		switch(k){
			case 0:
				post = "";
				break;
			case 1:
				post = "KB"
				break;
			case 2:
				post = "MB"
				break;
			case 3:
				post = "GB"
				break;
			case 4:
				post = "TB"
				break;
		}
		val = formatNumber(val,places);
	}
	return val + post;
}

/* findAll(str)		- finds all the values in an array of objects and returns an array of those values
	for use with d3.scale.quantile()
 */
function findAll(data,vl){
	var what = [];
	
	data.forEach(function(val,ind){
		what.push(val[vl]);
	});
	
	return what;
}