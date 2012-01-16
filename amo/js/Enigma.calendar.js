Enigma.prototype._calenderBuilder = function(){
	var me = this;
	
	console.log("calender",me);
	me.chartHolderVis = me.vis.append("svg:g")
							.attr("class","holder")
							.attr("transform","translate(10,0)");

	me._addJSDate();
	me.calCellSize();

	me.calendar();
	if(me.chartDefaults.calendar.animate){
		me.transitionCal();
	}
		me.setSVGBounds([900,600]);
	if(me.chartDefaults.legend.show){
		me.addLegend();
	}
	return me;
};

Enigma.prototype.transitionCal = function(){
	var me = this;
	
	me.cals.forEach(function(sel,ind){
		
	});

	
	return me;
};


Enigma.prototype.calendar = function(){
	var me = this,
		cd = me.chartDefaults,
		calD = cd.calendar,
		calDT = calD.title,
		sh = calD.dims.height,
		sw = calD.dims.width,
		sz = calD.dims.cell,
		vis = me.cal;

	me.cals = [];
	cd.series.forEach(function(val,ind){
		var tans = (sh * ind) + (sz),
			color = val.color,
			scl = d3.scale.linear()
					.range([0,4])
					.domain(getBounds(me.chartData,val.dataType)),
			cl = me.chartHolderVis.append("svg:g")
					.attr("class",val)
					.attr("transform","translate(0,"+ tans +")"),
			clvis = cl.append("svg:g")
					.attr("class","calendar")
					.attr("transform",function(d,i){
						var trans = "translate(0,",
							y = (calD.funs.week(me.chartData[0].jsdate) * sz) - sz;
						trans += -(y) + ")";
						return trans;
					}),
			boxes = clvis.selectAll("g.nothing")
						.data(me.chartData).enter()
						.append("svg:g").attr("class","day-g"),
			boxesR = null, boxesT = null,
			title = cl.append("svg:text"),
			titleX = (sw / 2), titleY = sh, 
			titleT = val.name ? val.name : val.dataType;
			
		boxesR = boxes.append("svg:rect")
					.attr("class","day")
					.attr("height",sz).attr("width",sz)
					.attr("y",function(d,i){
						return calD.funs.week(d.jsdate) * sz;
					})
					.attr("x",function(d,i){
						return calD.funs.day(d.jsdate) * sz;
					})
					.style("fill",function(d,i){
						return color.darker(scl(d[val.dataType]));
					});
			
		applyStyles(boxes,calD.boxes.styles);		
		if(calD.animate){
			cl.call(me._animateCal,me);
		}
		if(calD.hover){
			boxesR.call(me._hoverDay,me,cl);
		}

		//add the numbered days
		if(calD.boxes.showDay){
			var fs = parseFloat(calD.boxes.text.styles["font-size"]);
			boxesT = boxes.append("svg:text")
						.text(function(d,i){
							return i + 1;
						})
						.attr("y",function(d,i){
							return (calD.funs.week(d.jsdate) * sz) + fs;
						})
						.attr("x",function(d,i){
							return calD.funs.day(d.jsdate) * sz + (sz - 1);
						});
			applyStyles(boxesT,calD.boxes.text.styles);
		}

		//add the title to the chart
		if(calDT.show){
			if(calDT.pos == "top"){
				titleY = 0;
			}
			titleY += parseFloat(calDT.styles['font-size']);
			if(calDT.align == "left"){
				titleX = 0;
			} else if(calDT.align == "right"){
				titleX = sw;
			}
			
			if(calDT.capitalize == true){
				//titleT = val.charAt(0).toUpperCase() + val.slice(1);
			}
			title.attr("x",titleX)
				.attr("y",titleY)
				.style("fill",color)
				.text(titleT);
			applyStyles(title,calD.title.styles);
		}

		me.cals.push(cl);
	});
	me.setSVGBounds();
	return me;
};

Enigma.prototype._animateCal = function(sel,me){
	sel.on("click",function(d,i){
		var tSel = d3.select(this),
			zoomOut = false;
		if(tSel.attr("zoomed") == "true"){
			zoomOut = true;
		}
		me.cals.forEach(function(val,ind){
			if(val.attr("zoomed") == "true"){
				val.transition().duration(500)
					.ease("bounce")
					.attr("transform",me.chartDefaults.calendar.zoom.old)
					.attr("zoomed",false);
				val.select("g.calendar").selectAll("text")
					.transition().delay(100).style("opacity",0);
			}
		});
		if(zoomOut){
			me.legendVis.style("opacity",0);
			return;
		}
		me.legendVis.style("opacity",1);
		me.chartDefaults.calendar.zoom.old = tSel.attr("transform");
		tSel.transition().duration(300)
			.ease("circle")
			.attr("transform","translate(300 -50) scale(4)")
			.attr("zoomed",true);
		tSel.select("g.calendar").selectAll("text")
				.transition().delay(100).style("opacity",1);
	});
};

Enigma.prototype._hoverDay = function(sel,me,cl){
	sel.on("mouseover",function(d,i){
		if(cl.attr("zoomed") != "true"){
			return;
		}
		var lopts = me.chartDefaults.legend;
		
		lopts.tips.forEach(function(val,ind){
			var txt = val.formatter(d[val.dataType],i);
			me.legendVis.select("tspan."+val.dataType)
				.select("tspan").text(txt);
		});
	});
};

/* _addJSDate()	- adds a Javascript date object to each chartData object
 *	since we use new Date(data.fulldate.iso) many times, let's only call new Date() once
 */
Enigma.prototype._addJSDate = function(){
	var me = this;
	
	me.chartData.forEach(function(val,ind){
		val.jsdate = new Date(val.fulldate.iso);
	});
	return me;
};

/* calCellSize()	- calculates the cell size based on the width / 7
 * sets the height & width dimensions to the calculated ones
 * Adds 2 to height & width to take into account border
 * Height is 6 * the cell dimensions (max num weeks = 6)
 */
Enigma.prototype.calCellSize = function(){
	var me = this,
		dims = me.chartDefaults.calendar.dims;

	dims.cell = dims.width / 7;
	dims.height= (dims.cell * 6) + 2;
	dims.width += 2 + dims.cell;
	me.chartDefaults.calendar.dims = dims;
	return me;
};
