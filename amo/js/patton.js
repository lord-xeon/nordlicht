$(function(){
	var $tabs = $("#nordlicht");

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
			var win = $(window).innerHeight();
			$("#nordlicht").css({
				height:win - 50
			});
//			return;	//comment this out when done testing
			var dt = $(ui.tab).data();
			Modernizr.load({
				both:"amo/js/beaches/"+dt.section+".js",
				complete:function(){
					$(ui.panel)[dt.section+"Tab"]({
						tab:ui,
						section:dt.section,
						offset:dt.offset
					});					
				}
			});
		},
	});
	//sorts the tabs along the x axis
	$tabs.find(".ui-tabs-nav").sortable({ axis: "x" });

	Modernizr.load({
		both:"amo/js/jquery/jquery.ui.selectmenu.js",
		complete:function(){
			nordlicht.initTab();
		}
	})
});
var nordlicht = {
	about:{
		version:"3.0",
		lastUpdate:"Jan. 08, 2012",
		author:"Stephen Giorgi",
		authorEmail:"stephen.giorgi@alphavega.com",
		authorURL:"http://www.alphavega.com",
		home:"http://www.alphavega.com/nordlicht",
		repository:"http://code.google.com/p/nordlicht/"
	},
	colors:{
		pages:d3.rgb("#19a2f0"),
		hits:d3.rgb("#ab2828"),
		bandwidth:d3.rgb("#229b39")
	},
	initTab:function(){
		console.log("starting...");
		var dir = true
		if(!localStorage.getItem("dir") === null){
			dir = false;
		}
		$.ajax({
			url:"amo/config.php",
			data:{
				siteDir:dir
			},
			dataType:"json",
			success:function(data){
				if(dir){
					localStorage.setItem("dir",data.dir);
				}
				makeSelect(data.sitelist);
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
		var dlg = $("#settings-dialog").dialog({
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
					localStorage.setItem("site",$("#site-list").val());
					localStorage.setItem("month",$("#month-date").val());
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
		$("#show-settings").button({
			text:"show dialog"
		})
		.click(function(e){
			dlg.dialog("open");
		});
		$("#month-date").datepicker({
			maxDate:"+0",
		});
	}
};

function makeSelect(data){
	var dd3 = $("#site-list");
	data.forEach(function(val,ind){
		var opt = document.createElement("option"),
			ih = "";
		opt.setAttribute("value",val.siteid);
		ih += val.nicesitename + "-|-" + val.lastupdate + "-|-" + val.firstupdate + "-|-" + val.site;
		opt.innerHTML = ih;
		dd3.append(opt);
	});
};
