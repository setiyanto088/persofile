'use strict';

window.chartColors = {
	red: '#ff5f5f',
	orange: 'rgb(220, 99, 70)',
	yellow: 'rgb(255, 205, 86)',
	green: '#a7d14b',
	blue: 'rgb(54, 162, 235)',
	purple: 'rgb(153, 102, 255)',
	grey: 'rgb(201, 203, 207)',
	white: 'rgb(255, 255, 255)'
};

(function (global) {
	var Days = [
		'Senin',
		'Selasa',
		'Rabu',
		'Kamis',
		'Jumat',
		'Sabtu',
		'Minggu'
	];

	var COLORS = [
		'#4dc9f6',
		'#f67019',
		'#f53794',
		'#537bc4',
		'#acc236',
		'#166a8f',
		'#00a950'
	];

	var Samples = global.Samples || (global.Samples = {});
	var Color = global.Color;

	Samples.utils = {
		// Adapted from http://indiegamr.com/generate-repeatable-random-numbers-in-js/
		srand: function (seed) {
			this._seed = seed;
		},

		rand: function (min, max) {
			var seed = this._seed;
			min = min === undefined ? 0 : min;
			max = max === undefined ? 1 : max;
			this._seed = (seed * 9301 + 49297) % 233280;
			return min + (this._seed / 233280) * (max - min);
		},

		numbers: function (config) {
			var cfg = config || {};
			var min = cfg.min || 0;
			var max = cfg.max || 1;
			var from = cfg.from || [];
			var count = cfg.count || 8;
			var decimals = cfg.decimals || 8;
			var continuity = cfg.continuity || 1;
			var dfactor = Math.pow(10, decimals) || 0;
			var data = [];
			var i, value;

			for (i = 0; i < count; ++i) {
				value = (from[i] || 0) + this.rand(min, max);
				if (this.rand() <= continuity) {
					data.push(Math.round(dfactor * value) / dfactor);
				} else {
					data.push(null);
				}
			}

			return data;
		},

		labels: function (config) {
			var cfg = config || {};
			var min = cfg.min || 0;
			var max = cfg.max || 100;
			var count = cfg.count || 8;
			var step = (max - min) / count;
			var decimals = cfg.decimals || 8;
			var dfactor = Math.pow(10, decimals) || 0;
			var prefix = cfg.prefix || '';
			var values = [];
			var i;

			for (i = min; i < max; i += step) {
				values.push(prefix + Math.round(dfactor * i) / dfactor);
			}

			return values;
		},

		days: function (config) {
			var cfg = config || {};
			var count = cfg.count || 12;
			var section = cfg.section;
			var values = [];
			var i, value;

			for (i = 0; i < count; ++i) {
				value = Days[Math.ceil(i) % 7];
				values.push(value.substring(0, section));
			}

			return values;
		},

		color: function (index) {
			return COLORS[index % COLORS.length];
		},

		transparentize: function (color, opacity) {
			var alpha = opacity === undefined ? 0.5 : 1 - opacity;
			return Color(color).alpha(alpha).rgbString();
		}
	};

	// DEPRECATED
	window.randomScalingFactor = function () {
		return Math.round(Samples.utils.rand(0, 100));
	};

	// INITIALIZATION

	Samples.utils.srand(Date.now());

}(this));

var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
var color = Chart.helpers.color;
var BarChartData = {
	labels: ["ANTV", "RCTI", "MNC", "ANTV", "RCTI", "MNC", "ANTV", "RCTI", "MNC", "ANTV", "RCTI", "MNC", "MNC",],
	datasets: [{
		// label: 'ANTV',
		backgroundColor: window.chartColors.red,
		borderWidth: 0,
		data: [
			randomScalingFactor(),
			randomScalingFactor(),
			randomScalingFactor(),
			randomScalingFactor(),
			randomScalingFactor(),
			randomScalingFactor(),
			randomScalingFactor(),
			randomScalingFactor(),
			randomScalingFactor(),
			randomScalingFactor(),
			randomScalingFactor(),
			randomScalingFactor(),
			randomScalingFactor()
		]
	}]

};

var percentageDoughnutChart = randomScalingFactor();

var DoughnutChartData = {
	labels: [
		"Non Prime Time"
	],
	datasets: [{
		backgroundColor: [
			window.chartColors.white,
			window.chartColors.orange
		],
		label: 'Dataset 1',
		borderWidth: 0,
		cutoutPercentage: 75,
		data: [
			percentageDoughnutChart,
			100-percentageDoughnutChart
		]
	}]
};

var DAYS = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
var config = {
	type: 'line',
	data: {
		labels: ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"],
		datasets: [{
			label: "ANTV",
			backgroundColor: window.chartColors.red,
			borderColor: window.chartColors.red,
			data: [
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor()
			],
			fill: false,
		}]
	},
	options: {
		responsive: true,
		tooltips: {
			mode: 'index',
			intersect: false,
		},
		hover: {
			mode: 'nearest',
			intersect: true
		},
		scales: {
			xAxes: [{
				display: true,
				scaleLabel: {
					display: true,
					labelString: 'Day'
				},
				gridLines: {
                    display:false
                }   
			}],
			yAxes: [{
				display: true,
				scaleLabel: {
					display: true,
					labelString: 'Spot'
				}
			}]
		},
		legend: {
				display: false
		}
	}
};



window.onload = function () {


	// Chart type: Line
	var canvasSpotByDay = document.getElementById("widget-spot-day").getContext("2d");
	var widgetSpotByDay = new Chart(canvasSpotByDay, config);

	// Chart type: Bar
	var canvasSpotByChannel = document.getElementById("widget-spot-channel").getContext("2d");
	window.widgetSpotByChannel = new Chart(canvasSpotByChannel, {
		type: 'bar',
		data: BarChartData,
		options: {
			scales: {
		        xAxes: [{
		            barPercentage: 0.2,
		            gridLines: {
	                    display:false
	                }   
		        }]
		    },
			responsive: true,
			legend: {
				display: false
			}
		}
	});

	// Chart type: Doughnut
	var canvasSpotByTime = document.getElementById("widget-spot-time").getContext("2d");
	window.widgetSpotByTime = new Chart(canvasSpotByTime, {
		type: 'doughnut',
		data: DoughnutChartData,
		options: {
			cutoutPercentage: 90,
			maintainAspectRatio: false,
			legend: {
				labels: {
					usePointStyle : true,
					fontColor: 'white',
					fontSize : 14
				},
				// position: 'bottom',
				display: false

			},
			elements: {
				center: {
					text: percentageDoughnutChart + "%",
					color: '#FFF',
					fontStyle: 'Lato',
				}
			}
		}
	});

	Chart.pluginService.register({
		beforeDraw: function (chart) {
			if (chart.config.options.elements.center) {
		        //Get ctx from string
		        var ctx = chart.chart.ctx;
		        
				//Get options from the center object in options
		        var centerConfig = chart.config.options.elements.center;
		      	var fontStyle = centerConfig.fontStyle || 'Arial';
				var txt = centerConfig.text;
		        var color = centerConfig.color || '#000';
		        var sidePadding = centerConfig.sidePadding || 20;
		        var sidePaddingCalculated = (sidePadding/100) * (chart.innerRadius * 2)
		        
		        //Start with a base font of 30px
		        ctx.font = "50px " + fontStyle;
		        
				//Get the width of the string and also the width of the element minus 10 to give it 5px side padding
		        var stringWidth = ctx.measureText(txt).width;
		        var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

		        // Find out how much the font can grow in width.
		        var widthRatio = elementWidth / stringWidth;
		        var newFontSize = Math.floor(30 * widthRatio);
		        var elementHeight = (chart.innerRadius * 2);

		        // Pick a new font size so it will not be larger than the height of label.
		        var fontSizeToUse = Math.min(newFontSize, elementHeight);

				//Set font settings to draw it correctly.
		        ctx.textAlign = 'center';
		        ctx.textBaseline = 'middle';
		        var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
		        var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
		        ctx.font = fontSizeToUse + "px " + fontStyle;
		        ctx.fillStyle = color;
		        
		        //Draw text in center
		        ctx.fillText(txt, centerX, centerY);
			}
		}
	});

	document.getElementById('js-legend').innerHTML = window.widgetSpotByTime.generateLegend();
};