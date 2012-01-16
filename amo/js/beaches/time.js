(function(){
$.widget("nordlicht.timeTab",{
	options:{
		tab:null,
		offset:null,
		section:"time",
		data:null,
		gridConfig: {
			height:"100%",
			datatype:"local",
			colNames:["Hour Viewed","Pages Viewed","Hits","Bandwidth"],
			colModel:[{
				name:'hour',
				width:150,
				formatter:function(vl){
					var time = vl % 12;
					if(time == 0){
						time = 12;
					}
					if(vl == 0){
						time = "12 a.m.";
					} else if(vl >= 13){
						time += " p.m.";
					} else {
						time += " a.m.";
					}
					return time;
				}
			},{
				name:'pages',
				width:150,
				formatter:"number",
				formatoptions:{
					thousandsSeparator:",",
					decimalPlaces:0
				}
			},{
				name:"hits",
				width:100,
				formatter:"number",
				formatoptions:{
					thousandsSeparator:",",
					decimalPlaces:0
				}
			},{
				name:"bandwidth",
				width:100,
				formatter:function(vl){ return byteSize(vl,2); }
			}],
			sortname:'hour',
		    sortorder:'desc',
			caption:"Hours of the Day",
			jsonReader: {
				repeatitems : false,
				id: "0"
			},
			rowNum:12,
			pager:"#time-pager"
		},
		chartConfig:{
			chart:{
				attrs:{
					width:1000,
					height:300,
					id:"time-chart-SVG"
				}
			},
			axis:{
				x:[{},{
					show:true,
					ticks:24,
					orient:"bottom",
					formatter:function(d,i){
						var time = d % 12;
						if(time == 0){
							time = 12;
						}
						return time;
					}
				}],
				y:[]
			},
			legend:{
				position:"bottom",
				tips:[{
					name:"Time of day:",
					dataType:"hour",
					formatter:function(d,i){
						var time = d % 12;
						if(time == 0){
							time = 12;
						}
						if(d == 0){
							time = "12 a.m.";
						} else if(d >= 13){
							time += " p.m.";
						} else {
							time += " a.m.";
						}
						return time;
					}
				},{
					name:"Bandwidth:",
					dataType:"bandwidth",
					formatter:function(d,i){
						return byteSize(d,2);
					}
				},{
					name:"Hits:",
					dataType:"hits",
					formatter:function(d,i){
						return addKs(d,2);
					}
				},{
					name:"Pages:",
					dataType:"pages",
					formatter:function(d,i){
						return addKs(d,2);
					}
				}]
			},
			series:[{
				type:"bar",
				group:true,
				groupId:0,
				dataType:"hits",
				color:nordlicht.colors.hits,
				styles:{
					fill:nordlicht.colors.hits,
					stroke:"none"
				}
			},{
				type:"bar",
				group:true,
				groupId:1,
				dataType:"pages",
				color:nordlicht.colors.pages,
				styles:{
					fill:nordlicht.colors.pages,
					stroke:"none"
				}
			},{
				type:"line",
				dataType:"bandwidth",
				interpolate:"basis",
				color:nordlicht.colors.bandwidth,
				styles:{
					fill:"none",
					stroke:nordlicht.colors.bandwidth,
					"stroke-width":"3px"
				}
			}]
		}
	},
	
	_create:function(){
		var me = this;
		
		me._getData();
	},
	
	_getData:function(){
		var me = this;
		$.ajax({
			url:"amo/fire.php",
			type:"GET",
			data:{
				section:me.options.section,
				offset:me.options.offset,
				perPage:12
			},
			dataType:"json",
			success:function(data,status,xhr){
				me.data = data;
				me.initTab();
			},
			error:function(xhr,status,error){
				console.log(error);
			}
		});
	},
	
	initTab:function(){
		var me = this;
		me.buildGrid();
		me.buildChart();
	},
	
	buildGrid:function(){
		var me = this,
			grid = $("#time-grid").jqGrid(me.options.gridConfig);
			
		//add the data to the grid
		me.data.rows.forEach(function(val,ind){
			grid.jqGrid("addRowData",ind + 1,val);
		});
		//after the data is loaded we need to refresh the grid so that the pages line up
		grid.trigger("reloadGrid");
		//set the grid to the object so we can access it
		me.grid = grid;
	},
	
	buildChart:function(){
		var me = this;
		
		me.options.chartConfig.chartDiv = me.element.find("#time-chart")[0];
		me.options.chartConfig.chartData = me.data.rows;

		me.chart = new Enigma(me.options.chartConfig);
	},
});
})();