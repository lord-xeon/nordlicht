if(typeof(nordlicht) == null){
	var nordlicht = {};
}

nordlicht = {
	//basic about info
	about:{
		version:"3.0",
		lastUpdate:"Jan. 16, 2012",
		author:"Stephen Giorgi",
		authorEmail:"stephen.giorgi@alphavega.com",
		authorURL:"http://www.alphavega.com",
		home:"http://www.alphavega.com/nordlicht",
		repository:"http://code.google.com/p/nordlicht/"
	},
	//List of colors used throughtout the visiluzations
	colors:{
		pages:d3.rgb("#19a2f0"),		//default pages color
		hits:d3.rgb("#ab2828"),			//default hits color
		bandwidth:d3.rgb("#229b39"),	//default bandwidth color
		visits:d3.rgb("#E29CCF")		//default visits color
	},
	tabs:{},
	globalLoad:null,
	months:["January","February","March","April","May","June","July","August","September","October","November","December"],
	/* initNordlicht()	
	 */
	initNordlicht:function(){
		nordlicht.initTab();
		nordlicht.globalLoad = $("#global-load");
		var dlg;
		/* get the list of sites to populate the drop down list
		 */
		$.ajax({
			url:"amo/fire.php",
			data:{
				req:"siteList"
			},
			dataType:"json",
			success:function(data){
				nordlicht.makeSelect(data.sitelist);
				$("#site-list").selectmenu({
					menuWidth:400,
					width:200,
					format:function(vl){
						var str = vl.split("-|-"),
							txt = vl;
						txt = '<span class="ui-selectmenu-item-header">'+str[0]+'</span>';
						txt += '<span class="ui-selectmenu-item-content">Last Updated: '+str[1]+'</span>';					
						txt += '<span class="ui-selectmenu-item-content">First Updated: '+str[2]+'</span>';
						txt += '<span class="ui-selectmenu-item-footer">Site URL: '+str[3]+'</span>';
						return txt;
					}
				})
			}
		});	//end $.ajax()
		
		/* Make the dialog that 
		 */
		dlg = $("#settings-dialog").dialog({
			height:400,
			modal:true,
			closeOnEscape:false,
			autoOpen:false,
			draggable:false,
			resizable:false,
			title:"Select your site &amp; Time Frame",
			buttons:[{
				text:"Go!",
				click:function(e){
					nordlicht.globalLoad.removeClass("hidden");
					var month = $("#month-date").val(),
						monthAr = month.split("/"),
						siteId = $("#site-list").val(),
						siteInfo = {},
						date = new Date(monthAr[2],monthAr[0],monthAr[1]),
						mon = date.getMonth() + 1;
					
					if(mon < 10){
						mon = "0"+mon;
					}

					siteInfo.date = {
						awstats:mon + "" + date.getFullYear(),
						date:date.toLocaleDateString(),
						year:date.getFullYear(),
						month:nordlicht.months[date.getMonth()]
					};
					siteInfo.siteid = siteId;
					localStorage.setItem("site",JSON.stringify(siteInfo));
					nordlicht.updateSite(siteId);
					nordlicht.destroyTab();
					nordlicht.initTab();
					dlg.dialog("close");
				}
			},{
				text:"Cancel",
				click:function(e){
					e.preventDefault();
					dlg.dialog("close");
				}
			}]
		});

		/* set up the connections to button that opens the dialog
		 */
		$("#show-settings").button({
			text:false,
			icons:{
				primary:"ui-icon-wrench"
			}
		})
		.click(function(e){
			dlg.dialog("open");
		});
		$("#month-date").datepicker({
			maxDate:"+0",
		});
	},
	destroyTab:function(){
		nordlicht.tabs.tabs("destroy");
	},
	
	initTab:function(){
		var $tabs = $("#nordlicht");
		nordlicht.tabs = $tabs;

		$tabs.tabs({
			ajaxOptions:{
				error:function(xhr,status,indx,anchor){
					console.log(status,indx,anchor);
				}
			},
			cache:true,
			fx:{
				opacity:"toggle"
			},
			load:function(e,ui){
				var win = $(window).innerHeight(),
					dt = $(ui.tab).data()
				$tabs.css({ height:win - 40 });
				//return;	//comment this out when done testing
				require([
					"jquery.jqGrid",
					"beaches/"+dt.section
					],
					function(){
						$(ui.panel)[dt.section+"Tab"]({
							tab:ui,
							section:dt.section,
							offset:dt.offset
						});
					nordlicht.globalLoad.addClass("hidden");
				});
			},
		});
		//sorts the tabs along the x axis
		$tabs.find(".ui-tabs-nav").sortable({ axis: "x" });
	},
	
	
	makeSelect:function(data){
		var dd3 = $("#site-list");
		data.forEach(function(val,ind){
			var opt = document.createElement("option"),
				ih = "";
			opt.setAttribute("value",val.siteid);
			ih += val.nicesitename + "-|-" + val.lastupdate + "-|-" + val.firstupdate + "-|-" + val.site;
			opt.innerHTML = ih;
			dd3.append(opt);
		});
	},
	updateSite:function(siteId){
		$.ajax({
			url:"amo/fire.php",
			data:{
				req:"siteinfo",
				siteid:siteId
			},
			dataType:"json",
			success:function(data){
				var siteInfo = JSON.parse(localStorage.getItem("site"));
				siteInfo.site = data;
				localStorage.setItem("site",JSON.stringify(siteInfo));
				$("#site-name").html(data.nicename);
				$("#site-month").html("Month of " + siteInfo.date.month + ", "+ siteInfo.date.year);
			},
			error:function(e){
				console.log("error",e);
			}
		});
	}
};

