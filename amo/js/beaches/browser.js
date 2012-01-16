(function(){
$.widget("nordlicht.browserTab",{
	options:{
		tab:null,
		offset:0,
		section:"",
		dataType:"",
		data:null,
		errors:[],
		gridConfig:{
			datatype:"local",
			autowidth:true,
			height:350,
			colNames:["Name","Hits from"],
			colModel:[{
				name:"name",
				sorttype:"string"
			},{
				name:"value",
				width:"200px",
				sorttype:"int",
				formatter:"number",
				formatoptions:{
					thousandsSeparator:",",
					decimalPlaces:0
				}
			}],
			jsonReader: {
				repeatitems : false,
				id: "0"
			},
			sortname:'value',
			sortorder:'desc',
			caption:"Breakdown by Browser",
			rowNum:15,
			rowList:[15,35,65],
			viewRecords:true,
			pager:"#browser-pager"
		},
		chartConfig:{
			type:"tree",
			chart:{
				attrs:{
					width:500,
					height:500
				}
			},
			tree:{
				value:"hits",
				styles:{}
			}
		},
		darkerBy:0.1
	},

	_create:function(){
		var me = this;
		me._getData();
	},

	_getData:function(){
		var me = this;

		$.when(
			$.ajax({url:"amo/fire.php",data:{
				section:me.options.section,
				offset:me.options.offset,
				perPage:15
				},
			dataType:"json",
			success:function(data,status,xhr){
				me.data = {
					children:data.rows,
					name:"browsers"
				};
			}}),
			$.ajax({url:"amo/js/d3/d3.layout.js",dataType:"script"}),
			$.ajax({url:"amo/js/Enigma.tree.js",dataType:"script"})
		)
		.done(function(a0,a1){
			me.initTab();
		})
		.fail(function(jqXHR, status, error){
			var e = {
					status:status,
					error:error
				};
			me.options.errors.push(e);
		});
	},

	initTab:function(){
		var me = this;
		me.superNova();
		me.initGrid();
	},
	
	superNova:function(){
		var me = this,
			darkerBy = me.options.darkerBy,
			copts = me.options.chartConfig,
			color = d3.scale.category20c();
		copts.chartDiv = "#browser-chart",
		copts.chartData = me.data;
		copts.tree.clickFun = function(d,i){ me._updateGrid(d,i); };
		copts.tree.mouseoverFun = function(d,i){ me._updateBrowsers(d,i); };
		copts.tree.fillStyle = function(d,i){
									var nm = (d.children ? d : d.parent).name,
										col = d3.hsl("#2a2a2a");
									switch(nm){
										case"firefox":
											col = d3.hsl("#BC4809");
											break;
										case"msie":
											col = d3.hsl("#0C52F7");
											break;
										case"chrome":
											col = d3.hsl("#0F6004");
											break;
										case"safari":
											col = d3.hsl("#4A1766");
											break;
										case"opera":
											col = d3.hsl("#84060C");
											break;
										case"browsers":
											break;
										default:
											col = d3.hsl(color((d.children ? d : d.parent).name));
											break;
									}
									if(!d.children){
										var dkb = (d.parent.value / d.value) * darkerBy;
										col = col.brighter(dkb);
									}
									return col;
								};
		copts.tree.styles.stroke = function(d,i){ if(!d.children){ return "#A8A8A8"; }};
		me.options.chartConfig = copts;
		me.chart = new Enigma(me.options.chartConfig);
	},
	
	_updateGrid:function(data,i){
		var me = this;
		me.grid.jqGrid("clearGridData");
		
		data.children.forEach(function(val,ind){
			me.grid.jqGrid("addRowData",ind + 1,val);
		});
		//after the data is loaded we need to refresh the grid so that the pages line up
		me.grid.trigger("reloadGrid");
	},
	
	_updateBrowsers:function(data,i){
		var me = this,
			brow = me.element.find(".browser-value"),
			hits = me.element.find(".hits-value");
		
		brow.html(me._formatBrowser(data.name));
		hits.html(addKs(data.value,1));
	},

	initGrid:function(){
		var me = this,
			grid = null;
		me.options.gridConfig.colModel[0].formatter = me._formatBrowser;
		grid = $("#browser-grid").jqGrid(me.options.gridConfig);
		
		//add the data to the grid
		me.data.children.forEach(function(val,ind){
			grid.jqGrid("addRowData",ind + 1,val);
		});
		//after the data is loaded we need to refresh the grid so that the pages line up
		grid.trigger("reloadGrid");
		//set the grid to the object so we can access it
		me.grid = grid;
	},
	
		
	_formatBrowser:function(vl){
		var me = this,
			txtOut = "",
			txt = vl,
			vr = vl.search(/[0-9]/),
			ln = vl.length;
		if(vr > 1){
			txt = vl.substr(0,vr) +" "+ vl.substr((vr), (ln));
		}
		//IE is saved as msie, but we want it to say Internet Explorer
		if(txt.match("msie")){
			txt = "Internet Explorer " + vl.substr((vr), (ln));
		}
		txtOut = txt.charAt(0).toUpperCase() + txt.slice(1);
		return txtOut;
	},
				
	buildError:function(){
		var me = this;
		
		console.log("errors thrown...",me);
	}
});
})();