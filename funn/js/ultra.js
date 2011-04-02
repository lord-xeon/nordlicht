/*	Operation Ultra - main jQuery plugins file for AWE stats
	Plugins:
	@1 - Global Functions
	@2 - Inline JS taken out of header
*/
/*@1 Global Functions*/
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
/* function addCommas()	= adds commas to a number every 3 digits
 *	nStr = int
 */
function addCommas(nStr) {
	  var rgx = /(\d+)(\d{3})/,x,x1,x2;
	  nStr += '';
	  x = nStr.split('.');
	  x1 = x[0];
	  x2 = x.length > 1 ? '.' + x[1] : '';
	  
	  while(rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	  }
	  return x1 + x2;
}
/* function dateMake()	= retuns a Human friendly Time stamp
 *	time	= int in this format: YYYYMMDDhhmmss | 20110217235028
 */
function dateMake(time){
	if(isNaN(time)){
		when =  'not recorded';
	}
	else {
	var t = time,
		month = Array("January","February","March","April","May","June","July","August","September","October","November","December"),
		weekDay = Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"),
		y = t.substr(0,4),
		m = t.substr(4,2),
		d = t.substr(6,2),
		h = t.substr(8,2),
		mm = t.substr(10,2),
		s = t.substr(12,2),
		tt = new Date(y,m,d,h,mm,s);
		when = '';

		when = weekDay[tt.getDay()];
		when += ", "+ month[tt.getMonth()]+" "+d+", "+y;
		when += "<br />@ "+tt.getHours() + ":"+tt.getMinutes() +":"+tt.getMilliseconds();
	}
	return when;
}
/* function countryFlag()	= adds a country Flag to the Domain column of the table
 * dn	= domain name, lowercase ex: us, uk, ru
 */
function countryFlag(dn){
	var flag = '<img src="funn/img/country/'+dn+'.png" alt="'+dn+'" class="flag" />';
	flag += " "+dn;
	return flag;
}

function drawTable(flo,flir) {
	var hd = getHeaders(flo['headers']);
	$("#"+flir).dataTable({
		"bDestroy":true,
		"aaData":flo['data'],
		"aoColumns":hd,
		"bSort":false,
		"iDisplayLength":25,
		"sPaginationType":"full_numbers",
		"sDom":'<"dataTableTop"lif<"clear">>rtp'
	});
}

function getHeaders(hd){
	var i=0, fh = new Array();
	while(i < hd.length){
		fh[i] = new Array();
		fh[i]['sTitle']=hd[i];
		if(hd[i] == 'Bandwidth'){
			fh[i]['fnRender'] = function(dd){ return byteSize(dd.aData[dd.iDataColumn]);};
		}
		else if(hd[i] == 'Last visit date'){
			fh[i]['fnRender'] = function(dd){ return dateMake(dd.aData[dd.iDataColumn]);};
			fh[i]['sClass'] = 'date';
		}
		else if(hd[i] == 'Domain'){
			fh[i]['fnRender'] = function(dd){ return countryFlag(dd.aData[dd.iDataColumn]);};
		}
		i++;
	}
	return fh;
}

/*@2 inline JS taken out of header*/
$(window).load(function(){
	$('#nav li').click(function(e){
		e.preventDefault();
		var div = $(this).children('a').attr('href');
		$.scrollTo($(div), {duration:1750});
	});
	$('table td a').colorbox({
		iframe:true,
		width:'75%',
		height:'75%'
	});
	var curyear = new Date();
	$("#dayR").datepick({
		showAnim:'slideDown',
		showSpeed:'normal',
		pickerClass:'buffel',
		maxDate:0,
		popupContainer:"#datePickHolder"
	});
	$("#siteSelect").msDropDown({mainCSS:'buffel dropDown'});
	$("#goToStats").click(function(e){
		$("#statsInfo").html('');
		e.preventDefault();
		var href, dayR = $('#dayR').val(), dayR2;
		href = 'stats-'+$('#siteSelect').val();
		if(dayR) {
			dayR2 = dayR.split("/");
			href += '-'+dayR2[0]+dayR2[2];
		}
		$("#statsInfo").load(href+ ' #statsInfo');
	});
	
	$("a.fullList").click(function(e){
		e.preventDefault();
		var t = $(this),	//cache this, to speed up everything below
			fl= t.attr('data-fullList'), 	//the section to search for
			flid = t.attr('data-frData'),	//the id of the jQuery data store
			flir = t.attr('data-table'),	//the id of the table
			flo = $("#"+flid).data(),		//the jQuery data object
			flair = $("#"+flir).parent();	//the section that holds the table & jQuery data store

		if($("#"+flid).length==0){	//if the section isn't made yet, make it
			var sec = document.createElement('section'),
				tbl = document.createElement('table'),
				dta = document.createElement('span');
			$(tbl).attr('id',flir);
			$(dta).attr('id',flid);
			$(sec).append(tbl).append(dta);
			$('body').append(sec);
			flo = $("#"+flid).data();
			flair = $("#"+flir).parent();
		}
		$.colorbox({	//open up the colorbox with the table
			inline:true,
			href:flair,
			width:"85%",
			height:"75%",
			onOpen: function(){		//fades in the section before it's finished loading
				$(flair).fadeIn('fast');
			},
			onCleanup:function(){	//fades out the section
				$(flair).fadeOut('fast');
			}
		});
		if(!flo.data){	//load the data from
			$.getJSON('funn/fullRange/fullRange-builder.php',
				{	surl:statsURL,
					day:dayR,
					what:fl },
				function(d){
					$("#"+flid).data(d);
					drawTable(flo,flir);
			});
		}
	});
});