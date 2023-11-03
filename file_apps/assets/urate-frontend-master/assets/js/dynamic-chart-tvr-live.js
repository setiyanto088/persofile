'use strict';
(function (global) {
	
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


Highcharts.chart('container', {
	chart: {
        events: {
            load: function () {

                // set up the updating of the chart each second
                var series = this.series[0], 
                series2 = this.series[1],
                series3 = this.series[2],
                series4 = this.series[3];

                setInterval(function () {
                    var x = (new Date()).getTime(), // current time
                        // y = Math.round(Math.random() * 100);
                    y = Math.round(Samples.utils.rand(90, 100));
                    series.addPoint([x, y], false, true);

                    y = Math.round(Samples.utils.rand(40, 50));
                    series2.addPoint([x, y], false, true);
                    
                    y = Math.round(Samples.utils.rand(50, 60));
                    series3.addPoint([x, y], false, true);
                    
                    y = Math.round(Samples.utils.rand(75, 85));
                    series4.addPoint([x, y], true, true);
                }, 1000);
            }
        }
    },

    title: {
        text: ''
    },

    exporting: {
        enabled: false
    },

    credits: {
      enabled: false
  	},

    yAxis: {
        title: {
            text: ''
        }
    },

    legend: {
        layout: 'horizontal',
        align: 'center',
        verticalAlign: 'bottom'
    },

    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            }
        }
    },

    xAxis: {
	    type: 'datetime',
	    tickInterval: 1000,
	    labels: {
	      format: '{value:%H:%M:%S}'
	    }
	},

    series: [{
	        name: 'METROTV',
	        data: (function () {
	            // generate an array of random data
	            var data = [],
	                time = (new Date()).getTime(),
	                i;

	            for (i = -20; i <= 0; i += 1) {
	                data.push([
	                    time + i * 1000,
	                    Math.round(Samples.utils.rand(90, 100))
	                ]);
	            }
	            return data;
	        }()),
	        color: '#c30'
	    },{
	        name: 'ANTV',
	        data: (function () {
	            // generate an array of random data
	            var data = [],
	                time = (new Date()).getTime(),
	                i;

	            for (i = -20; i <= 0; i += 1) {
	                data.push([
	                    time + i * 1000,
	                    Math.round(Samples.utils.rand(40, 50))
	                ]);
	            }
	            return data;
	        }()),
	        color: '#627fff'
	    },{
	        name: 'RCTI',
	        data: (function () {
	            // generate an array of random data
	            var data = [],
	                time = (new Date()).getTime(),
	                i;

	            for (i = -20; i <= 0; i += 1) {
	                data.push([
	                    time + i * 1000,
	                    Math.round(Samples.utils.rand(50, 60))
	                ]);
	            }
	            return data;
	        }()),
	        color: '#fff123'
	    },{
	        name: 'NET TV',
	        data: (function () {
	            // generate an array of random data
	            var data = [],
	                time = (new Date()).getTime(),
	                i;

	            for (i = -20; i <= 0; i += 1) {
	                data.push([
	                    time + i * 1000,
	                    Math.round(Samples.utils.rand(75, 85))
	                ]);
	            }
	            return data;
	        }()),
	        color: '#45ff45'
	    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});