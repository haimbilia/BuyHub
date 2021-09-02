var chart = new Chartist.Line('#chart-1', {
	labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
	series: [
    [1, 5, 2, 5, 4, 3, 5, 2, 5, 4, 3]
    
  ]
}, {
	low: 0,
	showArea: true,
	showPoint: false,
	fullWidth: true,
	showLine: true,
	showPoint: false,
	axisX: {
		showLabel: false,
		showGrid: false
	},
	axisY: {
		offset: 0,
		onlyInteger: false,
		showGrid: false,

	}

});

chart.on('draw', function (data) {
	if (data.type === 'line' || data.type === 'area') {
		data.element.animate({
			d: {
				begin: 2000 * data.index,
				dur: 2000,
				from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
				to: data.path.clone().stringify(),
				easing: Chartist.Svg.Easing.easeOutQuint
			}
		});
	}
});
/**/

var chart = new Chartist.Line('#chart-2', {
	labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
	series: [
  [5, 9, 7, 8, 5, 3, 5, 4, 4, 3, 2, 1, 0.5]

  ]
}, {
	low: 0,
	showArea: true,
	showPoint: false,
	fullWidth: true,
	showLine: true,
	showPoint: false,
	axisX: {
		showLabel: false,
		showGrid: false
	},
	axisY: {
		offset: 0,
		onlyInteger: false,
		showGrid: false,

	}

});
chart.on('draw', function (data) {
	if (data.type === 'line' || data.type === 'area') {
		data.element.animate({
			d: {
				begin: 2000 * data.index,
				dur: 2000,
				from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
				to: data.path.clone().stringify(),
				easing: Chartist.Svg.Easing.easeOutQuint
			}
		});
	}
});
/**/

/**/

var chart = new Chartist.Line('#chart-3', {
	labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
	series: [
    [19, 9, 7, 8, 5, 4, 6, 2, 3, 3, 4, 6, 9, 7, 8, 5, 4, 6, 2, ],

  ]
}, {
	low: 0,
	showArea: true,
	showPoint: false,
	fullWidth: true,
	showLine: true,
	showPoint: false,
	axisX: {
		showLabel: false,
		showGrid: false
	},
	axisY: {
		offset: 0,
		onlyInteger: false,
		showGrid: false,

	}

});
chart.on('draw', function (data) {
	if (data.type === 'line' || data.type === 'area') {
		data.element.animate({
			d: {
				begin: 2000 * data.index,
				dur: 2000,
				from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
				to: data.path.clone().stringify(),
				easing: Chartist.Svg.Easing.easeOutQuint
			}
		});
	}
});
/**/

var chart = new Chartist.Line('#chart-4', {
	labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
	series: [
    [19, 9, 7, 8,  9, 7, 8, 5, 4, 6, 2, 5, 4, 6, 4, 6],

  ]
}, {
	low: 0,
	showArea: true,
	showPoint: false,
	fullWidth: true,
	showLine: true,
	showPoint: false,
	axisX: {
		showLabel: false,
		showGrid: false
	},
	axisY: {
		offset: 0,
		onlyInteger: false,
		showGrid: false,

	}

});
chart.on('draw', function (data) {
	if (data.type === 'line' || data.type === 'area') {
		data.element.animate({
			d: {
				begin: 2000 * data.index,
				dur: 2000,
				from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
				to: data.path.clone().stringify(),
				easing: Chartist.Svg.Easing.easeOutQuint
			}
		});
	}
});
/**/

var chart = new Chartist.Line('#chart-5', {
	labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
	series: [
    [19, 9, 7, 8, 5, 4, 6, 2, 3, 3,  9, 7, 8, 5, 4, 6, 2, 4, 6],

  ]
}, {
	low: 0,
	showArea: true,
	showPoint: false,
	fullWidth: true,
	showLine: true,
	showPoint: false,
	axisX: {
		showLabel: false,
		showGrid: false
	},
	axisY: {
		offset: 0,
		onlyInteger: false,
		showGrid: false,

	}

});
chart.on('draw', function (data) {
	if (data.type === 'line' || data.type === 'area') {
		data.element.animate({
			d: {
				begin: 2000 * data.index,
				dur: 2000,
				from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
				to: data.path.clone().stringify(),
				easing: Chartist.Svg.Easing.easeOutQuint
			}
		});
	}
});
/**/

var chart = new Chartist.Line('#chart-6', {
	labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
	series: [
    [19,  9, 7, 9,  9, 7, 8, 5, 4, 6, 2,  3, 4, 20, 2],

  ]
}, {
	low: 0,
	showArea: true,
	showPoint: false,
	fullWidth: true,
	showLine: true,
	showPoint: false,
	axisX: {
		showLabel: false,
		showGrid: false
	},
	axisY: {
		offset: 0,
		onlyInteger: false,
		showGrid: false,

	}

});
chart.on('draw', function (data) {
	if (data.type === 'line' || data.type === 'area') {
		data.element.animate({
			d: {
				begin: 2000 * data.index,
				dur: 2000,
				from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
				to: data.path.clone().stringify(),
				easing: Chartist.Svg.Easing.easeOutQuint
			}
		});
	}
});
/**/

var chart = new Chartist.Line('#chart-7', {
	labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
	series: [
    [19, 9, 7, 8, 5, 4, 6, 2, 3, 3, 4, 6],

  ]
}, {
	low: 0,
	showArea: true,
	showPoint: false,
	fullWidth: true,
	showLine: true,
	showPoint: false,
	axisX: {
		showLabel: false,
		showGrid: false
	},
	axisY: {
		offset: 0,
		onlyInteger: false,
		showGrid: false,

	}

});
chart.on('draw', function (data) {
	if (data.type === 'line' || data.type === 'area') {
		data.element.animate({
			d: {
				begin: 2000 * data.index,
				dur: 2000,
				from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
				to: data.path.clone().stringify(),
				easing: Chartist.Svg.Easing.easeOutQuint
			}
		});
	}
});