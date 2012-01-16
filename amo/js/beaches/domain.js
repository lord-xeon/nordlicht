(function(){
$.widget("nordlicht.domainTab",{
	options:{
		tab:null,
		offset:0,
		section:"",
		dataType:"",
		data:null,
		errors:[],
		gridConfig:{
			datatype:"local",
			colNames:["","Country","Pages Viewed","Hits","Bandwidth"],
			height:"450px",
			autowidth:true,
			colModel:[{
				name:"domain",
				hidden:true
			},{
				name:"prettycountry",
				width:150,
				sorttype:"string",
				formatter:function(vl,ind,row,type){
					var vl2 = vl ? vl : "+",
						country = vl2.replace("+"," ");
					return '<img src="amo/css/images/flags/' +row.domain+ '.png" alt="' +country+ 'flag" /><span class="country-name">' +country+ "</span>";
				}
			},{
				name:'pages',
				width:150,
				sorttype:"int",
				formatter:"number",
				formatoptions:{
					thousandsSeparator:",",
					decimalPlaces:0
				}
			},{
				name:"hits",
				width:100,
				sorttype:"int",
				formatter:"number",
				formatoptions:{
					thousandsSeparator:",",
					decimalPlaces:0
				}
			},{
				name:"bandwidth",
				width:100,
				sorttype:"int",
				formatter:function(vl){ return byteSize(vl,2); }
			}],
			sortname:'pages',
			sortorder:'desc',
			caption:"Breakdown by Country",
			jsonReader: {
				repeatitems : false,
				id: "0"
			},
			rowNum:15,
			rowList:[15,45,75],
			pager:'#domain-pager'
		},
		chartConfig:{
			type:"map",
			defs:[{
				type:"gradient",
				options:{
					type:"linearGradient",
					id:"ocean",
					attrs:{
						x1:"0%",
						x2:"100%",
						y1:"0%",
						y2:"100%"
					},
					stops:[{
						attrs:	{ offset:"0%" },
						styles:	{ "stop-color":"#9BD6EF" }
					},{
						attrs:	{ offset:"60%" },
						styles:	{ "stop-color":"#044C6D" }
					},{
						attrs:	{ offset:"90%" },
						styles:	{ "stop-color":"#031F2B" }
					},{
						attrs:	{ offset:"100%" },
						styles:	{ "stop-color":"#2a2a2a" }
					}]
				}
			}]
		},
		origin:[-80,12],
		mapColors:["#efefef","#f7fcfd","#e0ecf4","#bfd3e6","#9ebcda","#8c96c6","#8c6bb1","#88419d","#810f7c","#4d004b"],
	},
	
	//data:{"records":159,"rows":[{"prettycountry":"United+States","countrycode":"USA","domain":"us","pages":"30990","hits":"59446","bandwidth":"1071105749","id":"0"},{"prettycountry":"Great+Britain","countrycode":"GBR","domain":"gb","pages":"4179","hits":"8601","bandwidth":"163656912","id":"1"},{"prettycountry":"Canada","countrycode":"CAN","domain":"ca","pages":"3290","hits":"6584","bandwidth":"117176817","id":"2"},{"prettycountry":"Unknown","countrycode":"Unknown","domain":"unknown","pages":"2411","hits":"5605","bandwidth":"38396079","id":"3"},{"prettycountry":"Germany","countrycode":"DEU","domain":"de","pages":"2195","hits":"3175","bandwidth":"74712755","id":"4"},{"prettycountry":"Netherlands","countrycode":"Netherlands","domain":"nl","pages":"1456","hits":"1982","bandwidth":"58578566","id":"5"},{"prettycountry":"Australia","countrycode":"AUS","domain":"au","pages":"1338","hits":"2767","bandwidth":"47696206","id":"6"},{"prettycountry":"Russia","countrycode":"Russia","domain":"ru","pages":"930","hits":"1286","bandwidth":"37076600","id":"7"},{"prettycountry":"Mexico","countrycode":"Mexico","domain":"mx","pages":"923","hits":"1293","bandwidth":"16387437","id":"8"},{"prettycountry":"Brazil","countrycode":"BRA","domain":"br","pages":"914","hits":"1542","bandwidth":"30618507","id":"9"},{"prettycountry":"Bangladesh","countrycode":"BGD","domain":"bd","pages":"18","hits":"42","bandwidth":"619650","id":"10"},{"prettycountry":"Turkey","countrycode":"TUR","domain":"tr","pages":"523","hits":"722","bandwidth":"21413108","id":"11"},{"prettycountry":"Myanmar+(Burma)","countrycode":"Myanmar+(Burma)","domain":"mm","pages":"3","hits":"5","bandwidth":"66060","id":"12"},{"prettycountry":"Malaysia","countrycode":"Malaysia","domain":"my","pages":"373","hits":"676","bandwidth":"12839509","id":"13"},{"prettycountry":"Honduras","countrycode":"HND","domain":"hn","pages":"7","hits":"17","bandwidth":"316462","id":"14"},{"prettycountry":"Greenland","countrycode":"GRL","domain":"gl","pages":"2","hits":"2","bandwidth":"23890","id":"15"},{"prettycountry":"Uganda","countrycode":"UGA","domain":"ug","pages":"4","hits":"7","bandwidth":"213535","id":"16"},{"prettycountry":null,"countrycode":null,"domain":"a2","pages":"9","hits":"15","bandwidth":"184204","id":"17"},{"prettycountry":"Romania","countrycode":"Romania","domain":"ro","pages":"408","hits":"640","bandwidth":"12369788","id":"18"},{"prettycountry":"Denmark","countrycode":"DNK","domain":"dk","pages":"268","hits":"558","bandwidth":"9861257","id":"19"},{"prettycountry":"Tunisia","countrycode":"TUN","domain":"tn","pages":"17","hits":"37","bandwidth":"542573","id":"20"},{"prettycountry":"Columbia","countrycode":"COL","domain":"co","pages":"184","hits":"303","bandwidth":"6951683","id":"21"},{"prettycountry":"New+Caledonia","countrycode":"New+Caledonia","domain":"nc","pages":"1","hits":"2","bandwidth":"17979","id":"22"},{"prettycountry":"Bolivia","countrycode":"BOL","domain":"bo","pages":"2","hits":"6","bandwidth":"95265","id":"23"},{"prettycountry":"Cyprus","countrycode":"CYP","domain":"cy","pages":"19","hits":"40","bandwidth":"670954","id":"24"},{"prettycountry":"Kenya","countrycode":"KEN","domain":"ke","pages":"20","hits":"34","bandwidth":"544258","id":"25"},{"prettycountry":"Macau","countrycode":"Macau","domain":"mo","pages":"21","hits":"23","bandwidth":"719268","id":"26"},{"prettycountry":null,"countrycode":null,"domain":"ps","pages":"5","hits":"9","bandwidth":"116512","id":"27"},{"prettycountry":"Georgia","countrycode":"GEO","domain":"ge","pages":"36","hits":"52","bandwidth":"1091387","id":"28"},{"prettycountry":"Afghanistan","countrycode":"AFG","domain":"af","pages":"3","hits":"7","bandwidth":"108220","id":"29"},{"prettycountry":"Greece","countrycode":"GRC","domain":"gr","pages":"267","hits":"502","bandwidth":"9263177","id":"30"},{"prettycountry":"Maldives","countrycode":"Maldives","domain":"mv","pages":"9","hits":"17","bandwidth":"398792","id":"31"},{"prettycountry":"Iceland","countrycode":"ISL","domain":"is","pages":"20","hits":"46","bandwidth":"734134","id":"32"},{"prettycountry":"Jamaica","countrycode":"JAM","domain":"jm","pages":"3","hits":"7","bandwidth":"147589","id":"33"},{"prettycountry":"Cayman+Islands","countrycode":"Cayman+Islands","domain":"ky","pages":"1","hits":"3","bandwidth":"44690","id":"34"},{"prettycountry":"Malta","countrycode":"Malta","domain":"mt","pages":"13","hits":"32","bandwidth":"486284","id":"35"},{"prettycountry":"Papua+New+Guinea","countrycode":"Papua+New+Guinea","domain":"pg","pages":"4","hits":"6","bandwidth":"108019","id":"36"},{"prettycountry":"Gibraltar","countrycode":"Gibraltar","domain":"gi","pages":"3","hits":"8","bandwidth":"152905","id":"37"},{"prettycountry":"Laos","countrycode":"LAO","domain":"la","pages":"1","hits":"1","bandwidth":"7179","id":"38"},{"prettycountry":"Bahrain","countrycode":"Bahrain","domain":"bh","pages":"6","hits":"16","bandwidth":"257639","id":"39"},{"prettycountry":"Bhutan","countrycode":"BTN","domain":"bt","pages":"1","hits":"3","bandwidth":"45831","id":"40"},{"prettycountry":null,"countrycode":null,"domain":"a1","pages":"2","hits":"6","bandwidth":"95990","id":"41"},{"prettycountry":"El+Salvador","countrycode":"SLV","domain":"sv","pages":"14","hits":"34","bandwidth":"617435","id":"42"},{"prettycountry":"Italy","countrycode":"ITA","domain":"it","pages":"509","hits":"1054","bandwidth":"18051964","id":"43"},{"prettycountry":"Solomon+Islands","countrycode":"Solomon+Islands","domain":"sb","pages":"2","hits":"4","bandwidth":"65793","id":"44"},{"prettycountry":"Hungary","countrycode":"HUN","domain":"hu","pages":"227","hits":"468","bandwidth":"7318328","id":"45"},{"prettycountry":"South+Africa","countrycode":"South+Africa","domain":"za","pages":"201","hits":"357","bandwidth":"7449508","id":"46"},{"prettycountry":"Nigeria","countrycode":"Nigeria","domain":"ng","pages":"46","hits":"56","bandwidth":"1603189","id":"47"},{"prettycountry":"Sweden","countrycode":"SWE","domain":"se","pages":"351","hits":"746","bandwidth":"11767315","id":"48"},{"prettycountry":"Guatemala","countrycode":"GTM","domain":"gt","pages":"30","hits":"64","bandwidth":"1000804","id":"49"},{"prettycountry":"Uruguay","countrycode":"URY","domain":"uy","pages":"16","hits":"37","bandwidth":"572153","id":"50"},{"prettycountry":"Iraq","countrycode":"IRQ","domain":"iq","pages":"10","hits":"19","bandwidth":"317765","id":"51"},{"prettycountry":"Luxembourg","countrycode":"Luxembourg","domain":"lu","pages":"14","hits":"24","bandwidth":"554540","id":"52"},{"prettycountry":"Namibia","countrycode":"Namibia","domain":"na","pages":"2","hits":"6","bandwidth":"96671","id":"53"},{"prettycountry":"Venezuela","countrycode":"VEN","domain":"ve","pages":"83","hits":"153","bandwidth":"2388968","id":"54"},{"prettycountry":"Portugal","countrycode":"Portugal","domain":"pt","pages":"242","hits":"452","bandwidth":"9387276","id":"55"},{"prettycountry":"Israel","countrycode":"ISR","domain":"il","pages":"187","hits":"311","bandwidth":"8832445","id":"56"},{"prettycountry":"Bosnia+And+Herzegovina","countrycode":"Bosnia+And+Herzegovina","domain":"ba","pages":"55","hits":"126","bandwidth":"1969956","id":"57"},{"prettycountry":"Egypt","countrycode":"EGY","domain":"eg","pages":"41","hits":"95","bandwidth":"1598890","id":"58"},{"prettycountry":"Philippines","countrycode":"Philippines","domain":"ph","pages":"523","hits":"1023","bandwidth":"16532235","id":"59"},{"prettycountry":"Kyrgyzstan","countrycode":"KGZ","domain":"kg","pages":"2","hits":"5","bandwidth":"54107","id":"60"},{"prettycountry":"Norway","countrycode":"Norway","domain":"no","pages":"203","hits":"468","bandwidth":"8374495","id":"61"},{"prettycountry":"Latvia","countrycode":"LVA","domain":"lv","pages":"156","hits":"191","bandwidth":"5230430","id":"62"},{"prettycountry":"Kazakhstan","countrycode":"KAZ","domain":"kz","pages":"31","hits":"39","bandwidth":"1456459","id":"63"},{"prettycountry":"France","countrycode":"FRA","domain":"fr","pages":"856","hits":"1454","bandwidth":"30654799","id":"64"},{"prettycountry":"Morocco","countrycode":"Morocco","domain":"ma","pages":"19","hits":"38","bandwidth":"824542","id":"65"},{"prettycountry":"India","countrycode":"IND","domain":"in","pages":"848","hits":"1552","bandwidth":"26856566","id":"66"},{"prettycountry":"Indonesia","countrycode":"IDN","domain":"id","pages":"425","hits":"739","bandwidth":"15921235","id":"67"},{"prettycountry":"Slovenia","countrycode":"Slovenia","domain":"si","pages":"136","hits":"224","bandwidth":"6060956","id":"68"},{"prettycountry":null,"countrycode":null,"domain":"me","pages":"10","hits":"19","bandwidth":"250710","id":"69"},{"prettycountry":"Oman","countrycode":"Oman","domain":"om","pages":"275","hits":"291","bandwidth":"8416083","id":"70"},{"prettycountry":"Belarus","countrycode":"BLR","domain":"by","pages":"5","hits":"11","bandwidth":"217965","id":"71"},{"prettycountry":"Finland","countrycode":"FIN","domain":"fi","pages":"389","hits":"636","bandwidth":"12075485","id":"72"},{"prettycountry":"Fiji","countrycode":"FJI","domain":"fj","pages":"6","hits":"10","bandwidth":"178910","id":"73"},{"prettycountry":"Iran","countrycode":"IRN","domain":"ir","pages":"68","hits":"78","bandwidth":"2524335","id":"74"},{"prettycountry":"Paraguay","countrycode":"Paraguay","domain":"py","pages":"10","hits":"19","bandwidth":"313331","id":"75"},{"prettycountry":"Chad","countrycode":"TCD","domain":"td","pages":"9","hits":"9","bandwidth":"346071","id":"76"},{"prettycountry":"Tanzania","countrycode":"TZA","domain":"tz","pages":"3","hits":"7","bandwidth":"98649","id":"77"},{"prettycountry":"Sudan","countrycode":"SDN","domain":"sd","pages":"5","hits":"8","bandwidth":"200972","id":"78"},{"prettycountry":"Panama","countrycode":"Panama","domain":"pa","pages":"29","hits":"35","bandwidth":"918591","id":"79"},{"prettycountry":"Armenia","countrycode":"ARM","domain":"am","pages":"8","hits":"16","bandwidth":"221439","id":"80"},{"prettycountry":"Ghana","countrycode":"GHA","domain":"gh","pages":"9","hits":"16","bandwidth":"454067","id":"81"},{"prettycountry":"Jordan","countrycode":"JOR","domain":"jo","pages":"14","hits":"32","bandwidth":"561493","id":"82"},{"prettycountry":"Estonia","countrycode":"EST","domain":"ee","pages":"93","hits":"171","bandwidth":"2452851","id":"83"},{"prettycountry":"Democratic+Republic+Of+Congo+(Zaire)","countrycode":"COG","domain":"cd","pages":"1","hits":"1","bandwidth":"37425","id":"84"},{"prettycountry":"Pakistan","countrycode":"Pakistan","domain":"pk","pages":"103","hits":"232","bandwidth":"3804315","id":"85"},{"prettycountry":"Yemen","countrycode":"YEM","domain":"ye","pages":"1","hits":"3","bandwidth":"46524","id":"86"},{"prettycountry":"Algeria","countrycode":"DZA","domain":"dz","pages":"21","hits":"38","bandwidth":"528381","id":"87"},{"prettycountry":"Saint+Kitts+And+Nevis","countrycode":"Saint+Kitts+And+Nevis","domain":"kn","pages":"3","hits":"7","bandwidth":"104069","id":"88"},{"prettycountry":"Mongolia","countrycode":"Mongolia","domain":"mn","pages":"3","hits":"7","bandwidth":"112532","id":"89"},{"prettycountry":"Botswana","countrycode":"BWA","domain":"bw","pages":"1","hits":"3","bandwidth":"51142","id":"90"},{"prettycountry":"Sri+Lanka","countrycode":"Sri+Lanka","domain":"lk","pages":"60","hits":"112","bandwidth":"1831266","id":"91"},{"prettycountry":"New+Zealand","countrycode":"New+Zealand","domain":"nz","pages":"206","hits":"456","bandwidth":"8109277","id":"92"},{"prettycountry":"United+Arab+Emirates","countrycode":"ARE","domain":"ae","pages":"66","hits":"152","bandwidth":"2533691","id":"93"},{"prettycountry":null,"countrycode":null,"domain":"rs","pages":"124","hits":"248","bandwidth":"3891402","id":"94"},{"prettycountry":"Seychelles","countrycode":"Seychelles","domain":"sc","pages":"2","hits":"2","bandwidth":"83258","id":"95"},{"prettycountry":"China","countrycode":"CHN","domain":"cn","pages":"726","hits":"862","bandwidth":"26958156","id":"96"},{"prettycountry":"Antigua+And+Barbuda","countrycode":"Antigua+And+Barbuda","domain":"ag","pages":"6","hits":"10","bandwidth":"165844","id":"97"},{"prettycountry":"Syria","countrycode":"SYR","domain":"sy","pages":"4","hits":"10","bandwidth":"174638","id":"98"},{"prettycountry":"Costa+Rica","countrycode":"CRI","domain":"cr","pages":"28","hits":"63","bandwidth":"973860","id":"99"},{"prettycountry":"Azerbaijan","countrycode":"AZE","domain":"az","pages":"2","hits":"4","bandwidth":"64957","id":"100"},{"prettycountry":"Ecuador","countrycode":"ECU","domain":"ec","pages":"71","hits":"95","bandwidth":"2636007","id":"101"},{"prettycountry":"Singapore","countrycode":"Singapore","domain":"sg","pages":"315","hits":"506","bandwidth":"11389976","id":"102"},{"prettycountry":"Cambodia","countrycode":"KHM","domain":"kh","pages":"6","hits":"13","bandwidth":"227268","id":"103"},{"prettycountry":"Bermuda","countrycode":"Bermuda","domain":"bm","pages":"6","hits":"11","bandwidth":"167467","id":"104"},{"prettycountry":"Lebanon","countrycode":"Lebanon","domain":"lb","pages":"18","hits":"37","bandwidth":"580959","id":"105"},{"prettycountry":"Kuwait","countrycode":"KWT","domain":"kw","pages":"148","hits":"182","bandwidth":"4826908","id":"106"},{"prettycountry":"Benin","countrycode":"BEN","domain":"bj","pages":"3","hits":"5","bandwidth":"85528","id":"107"},{"prettycountry":"Albania","countrycode":"ALB","domain":"al","pages":"21","hits":"36","bandwidth":"505121","id":"108"},{"prettycountry":"Uzbekistan","countrycode":"UZB","domain":"uz","pages":"1","hits":"3","bandwidth":"50891","id":"109"},{"prettycountry":"Puerto+Rico","countrycode":"Puerto+Rico","domain":"pr","pages":"35","hits":"81","bandwidth":"1363354","id":"110"},{"prettycountry":null,"countrycode":null,"domain":"ap","pages":"11","hits":"19","bandwidth":"611819","id":"111"},{"prettycountry":"Nepal","countrycode":"Nepal","domain":"np","pages":"11","hits":"18","bandwidth":"241989","id":"112"},{"prettycountry":"Dominican+Republic","countrycode":"DOM","domain":"do","pages":"28","hits":"53","bandwidth":"718024","id":"113"},{"prettycountry":"Bahamas","countrycode":"Bahamas","domain":"bs","pages":"6","hits":"11","bandwidth":"129808","id":"114"},{"prettycountry":"Cuba","countrycode":"CUB","domain":"cu","pages":"2","hits":"4","bandwidth":"76100","id":"115"},{"prettycountry":"Switzerland","countrycode":"CHE","domain":"ch","pages":"175","hits":"327","bandwidth":"6865614","id":"116"},{"prettycountry":null,"countrycode":null,"domain":"eu","pages":"228","hits":"232","bandwidth":"5338041","id":"117"},{"prettycountry":"Mauritius","countrycode":"Mauritius","domain":"mu","pages":"9","hits":"15","bandwidth":"216267","id":"118"},{"prettycountry":"Nicaragua","countrycode":"Nicaragua","domain":"ni","pages":"7","hits":"13","bandwidth":"147224","id":"119"},{"prettycountry":"Bulgaria","countrycode":"BGR","domain":"bg","pages":"362","hits":"680","bandwidth":"13613166","id":"120"},{"prettycountry":"Guam","countrycode":"Guam","domain":"gu","pages":"5","hits":"11","bandwidth":"628719","id":"121"},{"prettycountry":"Guyana","countrycode":"Guyana","domain":"gy","pages":"4","hits":"7","bandwidth":"91550","id":"122"},{"prettycountry":"Poland","countrycode":"Poland","domain":"pl","pages":"559","hits":"984","bandwidth":"19630484","id":"123"},{"prettycountry":"Slovak+Republic","countrycode":"Slovak+Republic","domain":"sk","pages":"87","hits":"191","bandwidth":"3033883","id":"124"},{"prettycountry":"Peru","countrycode":"Peru","domain":"pe","pages":"110","hits":"170","bandwidth":"3460655","id":"125"},{"prettycountry":"Netherlands+Antilles","countrycode":"Netherlands+Antilles","domain":"an","pages":"3","hits":"5","bandwidth":"66842","id":"126"},{"prettycountry":"Ukraine","countrycode":"UKR","domain":"ua","pages":"694","hits":"801","bandwidth":"23864807","id":"127"},{"prettycountry":null,"countrycode":null,"domain":"ax","pages":"1","hits":"3","bandwidth":"48838","id":"128"},{"prettycountry":"Spain","countrycode":"Spain","domain":"es","pages":"664","hits":"1011","bandwidth":"23911696","id":"129"},{"prettycountry":null,"countrycode":null,"domain":"je","pages":"3","hits":"9","bandwidth":"145224","id":"130"},{"prettycountry":"South+Korea","countrycode":"South+Korea","domain":"kr","pages":"408","hits":"532","bandwidth":"16333997","id":"131"},{"prettycountry":"Trinidad+And+Tobago","countrycode":"TTO","domain":"tt","pages":"25","hits":"60","bandwidth":"1145035","id":"132"},{"prettycountry":"Faroe+Islands","countrycode":"Faroe+Islands","domain":"fo","pages":"2","hits":"6","bandwidth":"112314","id":"133"},{"prettycountry":"Barbados","countrycode":"Barbados","domain":"bb","pages":"7","hits":"12","bandwidth":"165519","id":"134"},{"prettycountry":"Saudi+Arabia","countrycode":"Saudi+Arabia","domain":"sa","pages":"90","hits":"144","bandwidth":"3093309","id":"135"},{"prettycountry":"Zambia","countrycode":"ZMB","domain":"zm","pages":"4","hits":"10","bandwidth":"51005","id":"136"},{"prettycountry":"Thailand","countrycode":"THA","domain":"th","pages":"292","hits":"432","bandwidth":"11138866","id":"137"},{"prettycountry":"Hong+Kong","countrycode":"Hong+Kong","domain":"hk","pages":"178","hits":"277","bandwidth":"6510202","id":"138"},{"prettycountry":"Ethiopia","countrycode":"ETH","domain":"et","pages":"3","hits":"7","bandwidth":"109798","id":"139"},{"prettycountry":"Ireland","countrycode":"IRL","domain":"ie","pages":"323","hits":"682","bandwidth":"12444374","id":"140"},{"prettycountry":"Tajikistan","countrycode":"TJK","domain":"tj","pages":"1","hits":"2","bandwidth":"12597","id":"141"},{"prettycountry":"Czech+Republic","countrycode":"CZE","domain":"cz","pages":"231","hits":"396","bandwidth":"7543947","id":"142"},{"prettycountry":"Macedonia","countrycode":"Macedonia","domain":"mk","pages":"24","hits":"59","bandwidth":"976847","id":"143"},{"prettycountry":"Lithuania","countrycode":"Lithuania","domain":"lt","pages":"95","hits":"187","bandwidth":"3078297","id":"144"},{"prettycountry":"Croatia+(Hrvatska)","countrycode":"HRV","domain":"hr","pages":"134","hits":"291","bandwidth":"4365462","id":"145"},{"prettycountry":"Belgium","countrycode":"BEL","domain":"be","pages":"230","hits":"502","bandwidth":"8077818","id":"146"},{"prettycountry":"Qatar","countrycode":"Qatar","domain":"qa","pages":"12","hits":"24","bandwidth":"406426","id":"147"},{"prettycountry":"Moldova","countrycode":"Moldova","domain":"md","pages":"38","hits":"50","bandwidth":"1891528","id":"148"},{"prettycountry":"Japan","countrycode":"JPN","domain":"jp","pages":"278","hits":"385","bandwidth":"9664309","id":"149"},{"prettycountry":"Chile","countrycode":"CHL","domain":"cl","pages":"132","hits":"228","bandwidth":"4441518","id":"150"},{"prettycountry":"Taiwan","countrycode":"TWN","domain":"tw","pages":"198","hits":"259","bandwidth":"7230085","id":"151"},{"prettycountry":"Andorra","countrycode":"Andorra","domain":"ad","pages":"4","hits":"11","bandwidth":"188286","id":"152"},{"prettycountry":"Brunei","countrycode":"BRN","domain":"bn","pages":"29","hits":"55","bandwidth":"742227","id":"153"},{"prettycountry":"Austria","countrycode":"AUT","domain":"at","pages":"126","hits":"262","bandwidth":"4279452","id":"154"},{"prettycountry":"Vietnam","countrycode":"VNM","domain":"vn","pages":"82","hits":"115","bandwidth":"2227008","id":"155"},{"prettycountry":"Zimbabwe","countrycode":"ZWE","domain":"zw","pages":"2","hits":"4","bandwidth":"76140","id":"156"},{"prettycountry":"Guadeloupe","countrycode":"Guadeloupe","domain":"gp","pages":"2","hits":"3","bandwidth":"22035","id":"157"},{"prettycountry":"Argentina","countrycode":"ARG","domain":"ar","pages":"265","hits":"404","bandwidth":"9385028","id":"158"}],"pages":11},
	
	_create:function(){
		var me = this;

		me._getData();
		me._buildSliders();
		
		me._enableButtons();
		//me.initGrid();
	},
	
	_enableButtons:function(){
		var me = this,
			collapse = me.element.find(".collapse-chart"),
			spin = me.element.find(".auto-spin");
		
		collapse.button({
			label:"Collapse Map",
			text:false,
			icons:{
				primary:"ui-slide-chart"
			}
		})
		.click(function(e){
			e.preventDefault();
			me._toggleChart();
			$(this).toggleClass("selected");
			spin.toggleClass("fade-hide");
		});
		
		spin.button({
			label:"Auto Rotate"
		})
		.click(function(e){
			e.preventDefault();
			me.autoRotate();
		});
	},
	
	autoRotate:function(){
		var me = this,
			opts = me.options,
			origin = opts.origin,
			interval = null,
			long = null;
		
		if(!me.spinInterval){
			interval = setInterval(function(){
							var o1 = opts.origin[0];
							o1++;
							me.options.origin[0] = o1;
							me.spinGlobe();
						},50);
			me.spinInterval = interval;
		} else {
			clearInterval(me.spinInterval);
			me.spinInterval = null;
			long = me.geoCords.cords.origin()[0];
			while(long > 180){
				long -= 360;
			}
			me.longSlider.slider("option","value",long);
		}
	},
	
	_toggleChart:function(){
		var me = this,
			chart = me.element.find(".d3-chart-holder"),
			cTitle = me.element.find(".chart-title");
		chart.slideToggle(500,function(){
			cTitle.toggleClass("hidden")
		});
	},
	
	setChartDefaults:function(){
		var me = this,
			cc = me.element.find(".country-value"),
			pages = me.element.find(".pages-value"),
			hits = me.element.find(".hits-value"),
			bandwidth = me.element.find(".bandwidth-value"),
			cLat = me.element.find(".current-lat"),
			cLong = me.element.find(".current-long"),
			cData = me.data.rows[0];
			
		cc.html(cData.prettycountry.replace("+"," "));
		pages.css({color:nordlicht.colors.pages.darker()})
			.html(addKs(cData.pages));
		hits.css({color:nordlicht.colors.hits.darker()})
			.html(addKs(cData.hits));
		bandwidth.css({color:nordlicht.colors.bandwidth.darker()})
			.html(byteSize(cData.bandwidth));
		cLat.html(me.options.origin[1] + "&deg;");
		cLong.html(me.options.origin[0] + "&deg;");
	},
	
	_buildSliders:function(){
		var me = this,
			lat = me.element.find("#lat-control"),
			long = me.element.find("#long-control");

		lat.slider({
			orientation:"vertical",
			min:-90,
			max:90,
			step:0.5,
			value:12,
			animate:true,
			slide:function(e,u){
				me.options.origin[1] = u.value;
				me.spinGlobe();
			}
		});
		long.slider({
			orientation:"vertical",
			min:-180,
			max:180,
			step:0.5,
			value:-80,
			animate:true,
			slide:function(e,u){
				me.options.origin[0] = u.value;
				me.spinGlobe();
			}
		});
		me.latSlider = lat;
		me.longSlider = long;
	},
	
	spinGlobe:function(){
		var me = this,
			origin = me.options.origin,
			path = me.geoCords.path;
		me.geoCords.marble.origin(origin);
		me.geoCords.cords.origin(origin);

		me.visCountries.attr("d",function(d,i){
			return path(me.geoCords.marble.clip(d))
		});
		me.updateCords();
	},
	
	updateCords:function(){
		var me = this,
			cLat = me.element.find(".current-lat"),
			cLong = me.element.find(".current-long"),
			long = me.geoCords.cords.origin()[0];
		while(long > 180){
			long -= 360;
		}
		
		cLat.html(me.geoCords.cords.origin()[1] + "&deg;");
		cLong.html(long + "&deg;");
	},
	
	crossHairs:function(d,i){
		var me = this,
			cc = me.element.find(".country-value"),
			ccf = document.createElement("image"),
			src = "amo/css/images/flags/",
			pages = me.element.find(".pages-value"),
			hits = me.element.find(".hits-value"),
			bandwidth = me.element.find(".bandwidth-value"),
			country = me.data.rows,
			numCountries = country.length,
			idx = null, ccData = null;
			
		for(var k = 0; k < numCountries; k++){
			if(country[k].countrycode == d.id){
				idx = k;
				break;
			}
		}
		if(idx == null){
			return;
		}
		ccData = country[idx];
		src += ccData.domain + ".png";
		ccf.setAttribute("src",src);
		ccf.setAttribute("class","country-flag");
		ccf.setAttribute("alt","country flag");

		cc.html(ccf).append(ccData.prettycountry.replace("+"," "));
		pages.html(addKs(ccData.pages,2));
		bandwidth.html(byteSize(ccData.bandwidth,1));
		hits.html(addKs(ccData.hits,2));
	},
	
	_getData:function(){
		var me = this,
			ls = JSON.parse(localStorage.getItem("site"));

		$.when(
			$.ajax({
				url:"amo/fire.php",
				type:"GET",
				data:{
					req:"stats",
					siteid:ls.siteid,
					sitename:ls.site.site,
					date:ls.date.awstats,
					section:me.options.section,
					offset:me.options.offset,
					perPage:32
				},
				dataType:"json",
				success:function(data,status,xhr){
					me.data = data;
					me.initGrid();
			}}),
			$.ajax({url:"amo/js/d3/world-countries.json",dataType:"json"}),
			$.ajax({url:"amo/js/d3/d3.geo.js",dataType:"script"})
		)
		.done(function(a0,a1,a2){
			//if(a0[1] == "success" && a1[1] == "success" && a2[1] == "success"){
				me.setChartDefaults();
				me.buildChart();
				//me.world = a0[0];
				me.world = a1[0];
				me.buildMap();
			//}
		})
		.fail(function(jqXHR, status, error){
			var e = {
					status:status,
					error:error
				};
			me.options.errors.push(e);
		});
	},
	
	buildChart:function(){
		var me = this;
		
		me.options.chartConfig.chartDiv = "#domain-chart";
		me.enigma = new Enigma(me.options.chartConfig);
		me.enigma.vis.append("svg:circle").attr("r",250)
			.style("fill","url(#ocean)")
			.attr("transform","translate(280,250)");
		setTimeout(function(){
			me.enigma.setSVGBounds([600]);
		var cH = me.element.innerHeight();
		me.element.css({
			height:cH - 30
		})

		},1000);
	},
	
	buildMap:function(){
		var me = this,
			svg = me.enigma.vis,
			vis = svg.append("svg:g").attr("class","holder")
						.attr("transform","translate(-200,0)"),
			cords = d3.geo.azimuthal().scale(250).mode("orthographic"),
			marble = d3.geo.greatCircle(),
			path = d3.geo.path().projection(cords),
			numCountries = me.data.rows.length,
			mapCols = me.options.mapColors,
			allPages = findAll(me.data.rows,"pages"),
			maxPage = allPages.max(),
			origin = me.options.origin,
			colScale = d3.scale.quantile()
							.domain(allPages)
							.range(mapCols);
							
		
		//set the origin of the map to be centered over america
		marble.origin(origin);
		cords.origin(origin);

		vis.append("svg:g").attr("class","nations")
			.selectAll("g.nothing")
			.data(me.world.features).enter()
			.append("path")
			.attr("d",function(d,i){
				return path(marble.clip(d));
			})
			.style("fill",function(d,i){
				var col = "#2a2a2a",
					country = me.data.rows,
					ccData,
					idx = null;

				for(var k = 0; k < numCountries; k++){
					if(country[k].countrycode == d.id){
						idx = k;
						break;
					}
				}
				if(idx != null){
					ccData = country[idx];
					if(ccData.pages){
						if(ccData.pages == maxPage){
							col = d3.rgb(mapCols[mapCols.length -1]).darker().toString();
						} else{
							col = colScale(ccData.pages)
						}
					}
				}
				return col;
			})
			.on("mouseover",function(d,i){
				me.crossHairs(d,i);
			})
			.append("title")
			.text(function(d) { return d.properties.name; });

		//set these values to the object so we can manupilate them later
		me.svg = svg;
		me.vis = vis;
		me.geoCords = {
			marble:marble,
			path:path,
			cords:cords
		};
		me.visCountries = vis.selectAll("path");
//		me.svg.attr("transform","scale(0.1)").transition().duration(700).attr("transform","translatescale(1)");
	},
	
	buildError:function(){
		var me = this;
		
		console.log("errors thrown...",me);
	},
	
	initTab:function(){
		var me = this;
		
		me.buildGrid();
		
		me.grid.trigger("reloadGrid");
	},

	initGrid:function(){
		var me = this,
			grid = $("#domain-grid").jqGrid(me.options.gridConfig);
		
		//add the data to the grid
		me.data.rows.forEach(function(val,ind){
			grid.jqGrid("addRowData",ind + 1,val);
		});
		//after the data is loaded we need to refresh the grid so that the pages line up
		grid.trigger("reloadGrid");
		//set the grid to the object so we can access it
		me.grid = grid;
	}
});
})();