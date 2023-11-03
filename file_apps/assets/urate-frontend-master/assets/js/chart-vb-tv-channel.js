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

var config = {
	type: 'bar',
	data: {
		labels: ["Anandhi ANTV", "Thapki ANTV", "Film Keluarga RCTI", "Baper Banyak Permainan RCTI", "Metro Plus Siang METRO TV", "Netizen News METRO TV"],
		datasets: [{
			label: "ANTV",
			backgroundColor: window.chartColors.antv,
			borderColor: window.chartColors.antv,
			data: [
				760,
				700,
				0,
				0,
				0,
				0
			],
			fill: false,
		}, {
			label: "RCTI",
			fill: false,
			backgroundColor: window.chartColors.rcti,
			borderColor: window.chartColors.rcti,
			data: [
				0,
				0,
				500,
				400,
				0,
				0
			],
		}, {
			label: "METRO TV",
			fill: false,
			backgroundColor: window.chartColors.metrotv,
			borderColor: window.chartColors.metrotv,
			data: [
				0,
				0,
				0,
				0,
				240,
				150
			],
		}]
	},
	options: {
		responsive: true,
		legend: {
				position: 'bottom',
				labels: {
					usePointStyle : true,
					padding: 40,
				}
		},
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
	            barPercentage: 0.5,
	            gridLines: {
                    display:false
                }   
	        }],
			yAxes: [{
				display: true,
				scaleLabel: {
					display: true,
					labelString: 'Viewer'
				},
			}]
		}
	}
};

window.onload = function () {

	// Chart type: Line
	var canvasTvChannel = document.getElementById("vb-tv-channel").getContext("2d");
	var vbTVChannel 	= new Chart(canvasTvChannel, config);

};