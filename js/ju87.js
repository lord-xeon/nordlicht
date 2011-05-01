/*Junkers Ju 87
  Flot metadata for all charts of nordlicht Omaha build
 
 	Table of Contents:
	
	@1 - Today
	@2 - Year to Date
	@3 - Monthly
	@4 - Hourly
	@5 - Browser
		@5.1 - Minor Browser
	@6 - OS
		@6.1 - Minor OS
	@7 - GEO
	@8 - Content
	@9 - Robots
	@10 - Searches
	@11 - Errors
 */
 
var flotOps = {
	today: {
	},
	year2date: {
		
	},
	monthly: {
		series: {
			points: {
				show:true
			},
			lines: {
				show:true
			},
			bars: {
				barWidth:(10 * 60 * 60 * 1000), //2 hours less then a full day, so that there's some spacing between the bars
				fill:0.9,
				align:'center',
				points: {
					show:false
				}
			},
			shadowSize:5,
		},
		xaxes: [{
			mode:'time'
		}],
		yaxes: [{
			min:0
		},{
			alignTicksWithAxis:'right',
			position:'right',
			tickFormatter:byteSizeTick
		}],
		legend: {
			show:true
		}
	},
	hourly: {
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
		 yaxis: {
			 
        },
		legend: {
			show:true
		},
        grid: {
			hoverable: true,
			clickable:true
        }
	},
	browser: {
		series: {
			pie: {
				show:true,	//we want to show a pie chart
				radius:0.8,	//we want it to be smaller then the container, to get a better donut effect when you get the minor versions
				stroke: {
					color:'#fff',	//inner borders white
					width:2
				},
				label: {
					show:false,
					radius:0.8,
					background: {
						opacity:0.2
					},
					threshold:0.05
				},
				combine: {
					threshold:0.05,		//combine all slices that are under 5% of total
					color:"#333",	//make them color #333
					label:'All Others'
				}
			}
		},
		legend: {
			show:true,
			labelFormatter: function(label, series){
				var ll = '',
					lc = label.charAt(0).toUpperCase() + label.substr(1);
				if(label == 'msie') {
					lc = 'IE';
				}
				ll = '<span class="pie '+label+'"></span>'+lc + " - "+Math.round(series.percent)+"%";
				return ll;
			}
		},
		grid: {
			hoverable:true,
			clickable:true
		}
	},
	//Browser minor metadata
	browserMinor: {
		series: {
			pie: {
				innerRadius:0.55,
				radius:0.9,
				show:true,
				stroke: {
					color:'#fff',
					width:3
				},
				label: {
					show:true,
					radius:0.8,
					background: {
						opacity:0.7
					},
					threshold:0.05,
					formatter: function(label, series){
						var ll = '',
							vr = new RegExp('[0-9]'),
							vl = label.search(vr),
							v = label.substr(vl),
							b = label.substring(0,vl);
						b = b.charAt(0).toUpperCase() + b.substr(1);

						if(b == 'Msie') {
							b = 'IE';
						}
						lc = b +' v.' + v + '<br />'+ Math.round(series.percent) +'%';
						return lc;
					}
				},
				combine: {
					color:"#333",
					threshold:0.05
				}
			}
		},
		legend: {
			show:false
		},
		grid: {
			hoverable:true
		}
	},
	os: {
		series: {
			pie: {
				show:true,	//we want to show a pie chart
				radius:0.8,	//we want it to be smaller then the container, to get a better donut effect when you get the minor versions
				stroke: {
					color:'#fff',	//inner borders white
					width:2
				},
				label: {
					show:false,
					radius:0.8,
					background: {
						opacity:0.2
					},
					threshold:0.05
				},
				combine: {
					threshold:0.02,		//combine all slices that are under 5% of total
					color:"#333333",	//make them color #333333
					label:'All Others'
				}
			}
		},
		legend: {
			show:true,		//show the legend
			container: $("#os figcaption"),	//put the legend in the figcaption under the browser section
			noColumns: 1,
			labelFormatter: function(label, series){
				var ll = '';
				switch (label){
					case 'win':
						lc = 'Windows'
						break;
					case 'mac':
						lc = 'Mac OSX';
						break;
					default:
						lc = label.charAt(0).toUpperCase() + label.substr(1);
				}
				return lc + ' - ' + Math.round(series.percent) +"%";
			}
		},
		grid: {
			hoverable:true,
			clickable:true
		}
	},
	osMinor: {
		series: {
			pie: {
//				innerRadius:0.55,
				radius:0.9,
				show:true,
				stroke: {
					color:'#fff',
					width:3
				},
				label: {
					show:true,
					radius:0.8,
					background: {
						opacity:0.7
					},
					threshold:0.1,
					formatter: function(label, series){
						var ll = '',
							vr = new RegExp('[0-9]'),
							vl = label.search(vr),
							v = label.substr(vl),
							b = label.substring(0,vl);
						b = b.charAt(0).toUpperCase() + b.substr(1);

						if(b == 'Msie') {
							b = 'IE';
						}
						lc = b +' v.' + v + '<br />'+ Math.round(series.percent) +'%';
						return lc;
					}
				},
				combine: {
					color:"#333",
					threshold:0.1
				}
			}
		},
		legend: {
			show:false
		},
		grid: {
			hoverable:true
		}
	},
	geo: {
	},
	content: {
	},
	robots: {
	},
	searches: {
	},
	errors: {
		series: {
			bars: {
				fill:1,
				show:true,
				horizontal:true,
				align:'center'
			},
			points: {
				show:false
			},
			shadowSize:2
		},
        grid: {
			hoverable: true,
			clickable:true
        },
		legend: {
			show:true,		//show the legend
			//container: $("#errors figcaption"),	//put the legend in the figcaption under the errors section
			noColumns: 1
		}
	}
};