(function () {
	callChart = function (dv, $labels, $series, $position) {
		new Chartist.Bar('#' + dv, {
			labels: $labels,
			series: [$series],
		}, {
			stackBars: false,
			axisY: {
				position: $position,
				labelInterpolationFnc: function (value) {
					return (value / 1000) + 'k';
				}
			}
		}).on('draw', function (data) {
			if (data.type === 'bar') {
				data.element.attr({
					style: 'stroke-width: 25px'
				});
			}
		});
	}

	parseJsonData = function (t) {
		if (t == '') return (false);
		if (t == 'Your session seems to be timed out. Please try reloading the page.') {
			t = '{"status":0,"msg":"' + t + '"}';
		}
		try {
			var ans = eval('[' + t + ']');
			return (ans[0]);
		} catch (e) {
			return (false);
		}
	};

	topReferers = function (interval) {
		$('.topReferers').html('<li>' + fcom.getLoader() + '</li>');
		data = "rtype=top_referrers&interval=" + interval;

		fcom.ajax(fcom.makeUrl('home', 'dashboardStats'), data, function (t) {
			$('.topReferers').html(t);
		});
	};

	topCountries = function (interval) {
		$('.topCountriesJs').html('<li>' + fcom.getLoader() + '</li>');
		data = "rtype=top_countries&interval=" + interval;

		fcom.ajax(fcom.makeUrl('home', 'dashboardStats'), data, function (t) {
			$('.topCountriesJs').html(t);
		});
	};

	topProducts = function (interval) {
		$('.topProducts').html('<li>' + fcom.getLoader() + '</li>');
		data = "rtype=top_products&interval=" + interval;

		fcom.ajax(fcom.makeUrl('home', 'dashboardStats'), data, function (t) {
			$('.topProducts').html(t);
		});
	};

	getTopSearchKeyword = function (interval) {
		$('.topSearchKeyword').html('<li>' + fcom.getLoader() + '</li>');
		data = "rtype=top_search_keyword&interval=" + interval;
		fcom.ajax(fcom.makeUrl('home', 'dashboardStats'), data, function (t) {
			$('.topSearchKeyword').html(t);
		});
	};

	traficSource = function (interval) {
		$('#piechart').html(fcom.getLoader());
		data = "rtype=traffic_source&interval=" + interval;

		fcom.ajax(fcom.makeUrl('home', 'dashboardStats'), data, function (t) {
			var ans = parseJsonData(t);
			if (ans) {
				var dataTraficSrc = google.visualization.arrayToDataTable(ans);
				var optionsTraficSrc = { title: '', width: $('#piechart').width(), height: 360, pieHole: 0.4, pieStartAngle: 100, legend: { position: 'bottom', textStyle: { fontSize: 12, alignment: 'center' } } };
				var trafic = new google.visualization.PieChart(document.getElementById('piechart'));
				trafic.draw(dataTraficSrc, optionsTraficSrc);
			} else {
				$('#piechart').html(t);
			}
		});
	};

	visitorStats = function () {
		$('#visitsGraph').html(fcom.getLoader());
		data = "rtype=visitors_stats";

		fcom.ajax(fcom.makeUrl('home', 'dashboardStats'), data, function (t) {

			var ans = parseJsonData(t);

			if (ans) {
				var dataVisits = google.visualization.arrayToDataTable(ans);
				var optionVisits = {
					title: '', width: $('#visitsGraph').width(), height: 240, curveType: 'function',
					legend: { position: 'bottom', },

					hAxis: { direction: (layoutDirection == 'rtl') ? -1 : 1 },
					series: {
						0: {
							targetAxisIndex: (layoutDirection == 'rtl') ? 1 : 0
						},
						1: {
							targetAxisIndex: (layoutDirection == 'rtl') ? 1 : 0
						},
						2: {
							targetAxisIndex: (layoutDirection == 'rtl') ? 1 : 0
						},
						3: {
							targetAxisIndex: (layoutDirection == 'rtl') ? 1 : 0
						}
					}
				};

				var visits = new google.visualization.LineChart(document.getElementById('visitsGraph'));
				visits.draw(dataVisits, optionVisits);
			} else {
				$('#visitsGraph').html(t);
			}
		});

	};

	searchStatistics = function (type, tab) {
		if (tab === undefined || tab === null) {
			tab = 'tabs_01';
		} else {
			tab = $(tab).attr('rel');
		}
		data = "type=" + type;
		$('#' + tab).html(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('home', 'searchStatistics'), data, function (t) {
			$('#' + tab).html(t);
		});
	};

	latestOrders = function () {
		$('#latestOrdersJs').html(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('home', 'latestOrders'), '', function (t) {
			$('#latestOrdersJs').html(t);
		});
	};

})();

$(document).ready(function () {
	if (layoutDirection != 'rtl') {
		$position = 'start';
	} else {
		$position = 'end';
	}
	$('.counter').each(function () {
		var $this = $(this),
			countTo = $this.attr('data-count');

		$({ countNum: $this.text() }).animate({
			countNum: countTo
		},

			{
				duration: 8000,
				easing: 'linear',
				step: function () {
					if ($this.attr('data-currency') == 1) {
						$this.text(dataCurrency + Math.floor(this.countNum));
					} else {
						$this.text(Math.floor(this.countNum));
					}
				},
				complete: function () {
					if ($this.attr('data-currency') == 1) {
						$this.text(dataCurrency + this.countNum);
					} else {
						$this.text(this.countNum);
					}
					//alert('finished');
				}
			});
	});
});

$(".navTabsJs li a").click(function () {
	$(this).parents('.tabs_nav_container:first').find(".tabs_panel").hide();
	var activeTab = $(this).attr("data-tab");

	if ($(this).attr('data-chart')) {
		if (layoutDirection != 'rtl') {
			$position = 'start';
		} else {
			$position = 'end';
		}
		if (activeTab == 'tabs_1') {
			callChart('monthlysalesJs', $SalesChartKey, $SalesChartVal, $position);
		} else if (activeTab == 'tabs_2') {
			callChart('monthlysalesearningsJs', $SalesEarningsKey, $SalesEarningsVal, $position);
		} else if (activeTab == 'tabs_3') {
			callChart('monthlySignupsJs', $signupsKey, $signupsVal, $position);
		} else if (activeTab == 'tabs_4') {
			callChart('monthlyAffiliateSignupsJs', $affiliateSignupsKey, $affiliateSignupsVal, $position);
		} else if (activeTab == 'tabs_5') {
			callChart('monthlyProductsJs', $productsKey, $productsVal, $position);
		}
	}
});

$(window).on('load', function () {
	callChart('monthlysalesJs', $SalesChartKey, $SalesChartVal, $position);
	topCountries('yearly');
	latestOrders();
	/* visitorStats();
	traficSource('yearly');
	topReferers('yearly');
	topCountries('yearly');
	getTopSearchKeyword('yearly'); */
	// $('.carousel--oneforth-js').slick(getSlickSliderSettings(4));
	/* FUNCTION FOR SCROLLBAR */
	/* $('.scrollbar-js').enscroll({
		verticalTrackClass: 'scroll__track',
		verticalHandleClass: 'scroll__handle'
	}); */
	/* searchStatistics('statistics');
	latestOrders(); */
	fcom.removeLoader();
});
