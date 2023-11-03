'use strict';

window.chartColors = {
	antv: '#ff5f5f',
	gtv: '#c67575',
	kompastv: '#a7d14b',
	metrotv: '#f4ec90',
	mnctv: '#5ccca1',
	net: '#cfc825',
	ochnl: '#bf56a1',
	rcti: '#a3a3a3',
	rtv: '#54c4c6',
	sctv: '#c98557',
	transtv: '#949fbf',
	trans7: '#8f89db'
};

var colors = new Array();
	colors['antv'] = '#ff5f5f';
	colors['gtv'] =  '#c67575';
	colors['kompastv'] =  '#a7d14b';
	colors['metrotv'] =  '#f4ec90';
	colors['mnctv'] =  '#5ccca1';
	colors['net'] =  '#cfc825';
	colors['ochnl'] =  '#bf56a1';
	colors['rcti'] =  '#a3a3a3';
	colors['rtv'] =  '#54c4c6';
	colors['sctv'] =  '#c98557';
	colors['transtv'] =  '#949fbf';
	colors['trans7'] =  '#8f89db';

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
		return Math.round(Samples.utils.rand(-100, 100));
	};

	// INITIALIZATION

	Samples.utils.srand(Date.now());

}(this));

// var dataset = [{
// 			label: "ANTV",
// 			backgroundColor: window.chartColors.antv,
// 			borderColor: window.chartColors.antv,
// 			data: [
// 				0.1,
// 				0.2,
// 				0.2,
// 				0.3,
// 				0.5,
// 				1
// 			],
// 			fill: false,
// 		}, {
// 			label: "KOMPAS TV",
// 			fill: false,
// 			backgroundColor: window.chartColors.kompastv,
// 			borderColor: window.chartColors.kompastv,
// 			data: [
// 				0.2,
// 				0.3,
// 				0.2,
// 				0.4,
// 				0.4,
// 				0.2
// 			],
// 		}];

var dataset = new Array();

$(document).ready(function(){

	var config = {
	type: 'line',
	data: {
		labels: ["09:30:00 - 10:00:00", "10:01:00 - 10:30:00", "10:31:00 - 11:00:00", "11:01:00 - 11:30:00", "11:31:00 - 12:00:00", "12:01:00 - 12:30:00"],
		datasets: dataset
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
					labelString: 'Waktu'
				}
			}],
			yAxes: [{
				display: true,
				scaleLabel: {
					display: true,
					labelString: 'Rating'
				}
			}]
		}
	}
};

	var i = 0;

	$('.channel-selector .urate-select-dropdown a').blur(function(){

		var i = 0;

		$('.channel-selector .urate-custom-menu li').removeClass('selected');

		$('.channel-selector .urate-select-dropdown').each(function(){

			var title = $(this).attr('title');

			if(typeof title !== 'undefined'){

				title = title.replace(' ', '');
				title = title.toLowerCase();

				var data = {
						label: title.toUpperCase(),
						backgroundColor: colors[title],
						borderColor: colors[title],
						data: [
							Math.abs(randomScalingFactor()),
							Math.abs(randomScalingFactor()),
							Math.abs(randomScalingFactor()),
							Math.abs(randomScalingFactor()),
							Math.abs(randomScalingFactor()),
							Math.abs(randomScalingFactor())
						],
						fill: false,
					};

			dataset[i] = data;

			i++;

			}

			$('.channel-selector .urate-custom-menu li a').each(function() {
				if ($(this).text().replace(' ', '').toLowerCase() == title) {
					$(this).closest('li').addClass('selected');
				};
			});
		});

		// Chart type: Line
		var canvasTvr = document.getElementById("tvr-live-chart").getContext("2d");
		var chartTrv = new Chart(canvasTvr, config);

	});

});




window.onload = function () {

	// Chart type: Line
	var canvasTvr = document.getElementById("tvr-live-chart").getContext("2d");
	var chartTrv = new Chart(canvasTvr, config);

};
