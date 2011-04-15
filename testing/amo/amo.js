/*@1 Global Functions*/


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
Array.prototype.getMax = function(){
    return Math.max.apply(Math,this);
};
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


var flotOps = {
	series: {
		points: {
			show: true,
			symbol: "circle"
		},
		bars: {
			points: {
				show: false
			}
		}
	},
	xaxis: {
		tickDecimals: 0
		
	},
	 yaxis: [{
	}],
	grid: {
		hoverable: true,
		clickable:true
	},
	legend: {
		position: 'ne',
		marginX: -100
	}
};