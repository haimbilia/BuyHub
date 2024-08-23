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
		$('.topReferersJs').prepend(fcom.getLoader());
		data = "rtype=top_referrers&interval=" + interval;

		fcom.ajax(fcom.makeUrl('home', 'dashboardStats'), data, function (t) {
			fcom.removeLoader();
			if (typeof t.analyticsError != 'undefined' && t.analyticsError == 1) {
				$('.topReferersJs').parent().find('select').hide();
			}
			$('.topReferersJs').html(t.html);
		}, { fOutMode: 'json' });
	};

	topCountries = function (interval) {
		$('.topCountriesJs').prepend(fcom.getLoader());
		data = "rtype=top_countries&interval=" + interval;

		fcom.ajax(fcom.makeUrl('home', 'dashboardStats'), data, function (t) {
			fcom.removeLoader();
			if (typeof t.analyticsError != 'undefined' && t.analyticsError == 1) {
				$('.topCountriesJs').parent().find('select').hide();
			}
			$('.topCountriesJs').html(t.html);
		}, { fOutMode: 'json' });
	};

	topProducts = function (interval) {
		$('.topProducts').prepend(fcom.getLoader());
		data = "rtype=top_products&interval=" + interval;

		fcom.ajax(fcom.makeUrl('home', 'dashboardStats'), data, function (t) {
			fcom.removeLoader();
			$('.topProducts').html(t.html);
		}, { fOutMode: 'json' });
	};

	getTopSearchKeyword = function (interval) {
		$('.topSearchKeywordJs').prepend(fcom.getLoader());
		data = "rtype=top_search_keyword&interval=" + interval;
		fcom.ajax(fcom.makeUrl('home', 'dashboardStats'), data, function (t) {
			fcom.removeLoader();
			$('.topSearchKeywordJs').html(t.html);
		}, { fOutMode: 'json' });
	};

	traficSource = function (interval) {
		$('#piechart').prepend(fcom.getLoader());
		data = "rtype=traffic_source&interval=" + interval;
		fcom.ajax(fcom.makeUrl('home', 'dashboardStats'), data, function (t) {
			var ans = parseJsonData(t.html);
			if (ans) {
				var dataTraficSrc = google.visualization.arrayToDataTable(ans);
				var optionsTraficSrc = { title: '', width: $('#piechart').width(), height: 360, pieHole: 0.4, pieStartAngle: 100, legend: { position: 'bottom', textStyle: { fontSize: 12, alignment: 'center' } } };
				var trafic = new google.visualization.PieChart(document.getElementById('piechart'));
				trafic.draw(dataTraficSrc, optionsTraficSrc);
			} else {
				if (typeof t.analyticsError != 'undefined' && t.analyticsError == 1) {
					$('#piechart').parent().parent().find('select').hide();
				}
				$('#piechart').html(t.html);
			}
		}, { fOutMode: 'json' });
	};

	visitorStats = function () {
		$('#visitsGraph').prepend(fcom.getLoader());
		data = "rtype=visitors_stats";

		fcom.ajax(fcom.makeUrl('home', 'dashboardStats'), data, function (t) {
			var ans = parseJsonData(t.html);
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
				$('#visitsGraph').html(t.html);
			}
		}, { fOutMode: 'json' });

	};

	searchStatistics = function (type, tab) {
		if (tab === undefined || tab === null) {
			tab = 'tabs_01';
		} else {
			tab = $(tab).attr('rel');
		}
		data = "type=" + type;
		$('#' + tab).prepend(fcom.getLoader());
		fcom.updateWithAjax(fcom.makeUrl('home', 'searchStatistics'), data, function (t) {
			fcom.closeProcessing();
			fcom.removeLoader();
			$('#' + tab).html(t.html);
		});
	};

	latestOrders = function () {
		$('#latestOrdersJs').prepend(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('home', 'latestOrders'), '', function (t) {
			fcom.removeLoader();
			$('#latestOrdersJs').html(t.html);
		}, { fOutMode: 'json' });
	};

	totalSales = function (interval) {
		data = "interval=" + interval;
		$('#totalSalesJs').prepend(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('home', 'totalSales'), data, function (t) {
			fcom.removeLoader();
			$('#totalSalesJs').html(t.html);
		}, { fOutMode: 'json' });
	};

	topSellingProducts = function () {
		$('#topSellingProductsJs').html(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('home', 'topSellingProducts'), '', function (t) {
			fcom.removeLoader();
			$('#topSellingProductsJs').html(t.html);
		}, { fOutMode: 'json' });
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
	
	$(document).on('click', ".navTabsJs a",function () {
		// $(this).parents('.tabs_nav_container:first').find(".tabs_panel").hide();
		var activeTab = $(this).attr("data-tab");
		$('.tabsJs.active').removeClass('active');
		$(this).addClass('active');
		$('.dropdownBtnJs').text($(this).text());
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
			} else if (activeTab == 'tabs_5') {
				callChart('monthlyAffiliateSignupsJs', $affiliateSignupsKey, $affiliateSignupsVal, $position);
			} else if (activeTab == 'tabs_4') {
				callChart('monthlyProductsJs', $productsKey, $productsVal, $position);
			}
		}
	});
});

$(function () {
	callChart('monthlysalesJs', $SalesChartKey, $SalesChartVal, $position);
	totalSales(30);
	topCountries('yearly');
	latestOrders();
	topReferers('yearly');
	topSellingProducts();
	getTopSearchKeyword('yearly');
	traficSource('yearly');
	visitorStats();
});
