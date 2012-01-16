Enigma.prototype._treeBuilder = function(){
	var me = this,
		opts = me.chartDefaults,
		w = me.chartArea.w,
		h = me.chartArea.h,
	    r = Math.min(w, h) / 2,
	    x = d3.scale.linear().range([0, 2 * Math.PI]),
    	y = d3.scale.sqrt().range([0, r]),
		sun = me.vis.append("svg:g")
				.attr("class","sun-holder")
    			.attr("transform", "translate(" + w / 2 + "," + h / 2 + ")"),
		partition = d3.layout.partition()
						.value(function(d,i){
							return d[opts.tree.value];
						}),
		arc = d3.svg.arc()
				.startAngle(function(d,i){
					return Math.max(0, Math.min(2 * Math.PI, x(d.x)));
				})
				.endAngle(function(d,i){
					return Math.max(0, Math.min(2 * Math.PI, x(d.x + d.dx)));
				})
				.innerRadius(function(d,i){
					return Math.max(0, y(d.y));
				})
				.outerRadius(function(d,i){
					return Math.max(0, y((d.y + d.dy)));
				}),
		path = null;
		
	path = sun.data([me.chartData]).selectAll("g.nothing")
				.data(partition.nodes).enter()
				.append("svg:path")
				.attr("d",arc)
				/*.attrTween("d",function(d,i){
					return me._arcAnimate(me,d,i);
				})/*/
				.attr("class",function(d,i){
					return d.name.replace(/ /g,"-");
				})
				.call(me._superNova,me);
				

	applyStyles(path,opts.tree.styles);
	if(opts.tree.fillStyle){
		path.style("fill","#efefef")
			.transition().duration(750)
			.delay(function(d,i){return i * 10;})
			.style("fill",opts.tree.fillStyle);
	}
	me.arcScales = {
		x:x,
		y:y,
		r:r,
		arc:arc,
		path:path
	};
};

Enigma.prototype._superNova = function(sel,me){
	var opts = me.chartDefaults;
	sel.on("click",function(d,i){
		    me.arcScales.path
				.transition().duration(750)//.delay(0)
				.attrTween("d", me._arcAnimate(me,d,i));
		if(typeof(opts.tree.clickFun) != "undefined"){
			opts.tree.clickFun(d,i);
		}
	});
	if(typeof(opts.tree.mouseoverFun) != "undefined"){
		sel.on("mouseover",opts.tree.mouseoverFun);
	}
};

Enigma.prototype._arcAnimate = function(me,d,i){
	var mar = me.arcScales,
		xd = d3.interpolate(mar.x.domain(), [d.x, d.x + d.dx]),
		yd = d3.interpolate(mar.y.domain(), [d.y, 1]),
		yr = d3.interpolate(mar.y.range(), [d.y ? 20 : 0, mar.r]);
  return function(d, i) {
	  return i ? function(t) { return mar.arc(d); } : function(t) { mar.x.domain(xd(t)); mar.y.domain(yd(t)).range(yr(t)); return mar.arc(d); };
  };
};