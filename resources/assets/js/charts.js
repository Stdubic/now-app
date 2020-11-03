function updateCharts(selector = '.chart-area') {
	const elems = $(selector);
	if (!elems.length) return;

	blockSection(selector);

	const data = {
		min_date: document.getElementById('chart-date-range-first').value,
		max_date: document.getElementById('chart-date-range-second').value,
		date_format: document.getElementById('chart-date-format').value
	};

	const api = new ApiHandler();
	for (const elem of elems) {
		api.post(elem.dataset.api, plotLineChart, data, {
			area_id: elem.id,
			title: elem.dataset.title
		});
	}
}

function resizeChart(chartId) {
	chartId = document.getElementById(chartId);
	chartId.classList.toggle('col-sm-6');
	chartId.classList.toggle('col-sm-12');
}

function initChartDatePicker() {
	return $('.chart-daterangepicker').daterangepicker(
		{
			buttonClasses: 'm-btn btn',
			applyClass: 'btn-primary',
			cancelClass: 'btn-secondary',
			timePicker: true,
			timePicker24Hour: true,
			showWeekNumbers: true,
			autoUpdateInput: true,
			maxDate: new Date(),
			locale: { format: 'DD/MM/YYYY HH:mm' }
		},
		function(a, b) {
			const id = $(this)
				.attr('element')
				.attr('id');

			$('#' + id + '-first').val(a.format('YYYY-MM-DD HH:mm'));
			$('#' + id + '-second').val(b.format('YYYY-MM-DD HH:mm'));

			updateCharts();
		}
	);
}

function plotLineChart(data, graphData) {
	unblockSection('#' + graphData.area_id);

	return AmCharts.makeChart(graphData.area_id, {
		type: 'serial',
		theme: 'light',
		creditsPosition: 'top-right',
		fontFamily: 'Roboto',
		mouseWheelZoomEnabled: true,
		dataDateFormat: 'YYYY-MM-DD HH',
		valueAxes: [{ id: 'v1', axisAlpha: 0, position: 'left', ignoreAxisWidth: true, precision: 0 }],
		balloon: { borderThickness: 1, shadowAlpha: 0 },
		legend: {
			enabled: true,
			position: 'top',
			switchType: 'v',
			useMarkerColorForLabels: true,
			useMarkerColorForValues: true
		},
		graphs: [
			{
				id: 'g1',
				lineColor: '#5867dd',
				fillAlphas: 0.3,
				fillColorsField: 'lineColor',
				balloon: { drop: true, adjustBorderColor: false, color: '#ffffff' },
				bullet: 'round',
				bulletBorderAlpha: 1,
				bulletColor: '#FFFFFF',
				title: graphData.title,
				bulletSize: 5,
				hideBulletsCount: 50,
				lineThickness: 2,
				useLineColorForBulletBorder: true,
				valueField: 'value',
				balloonText: '<span style="font-size: 18px;">[[value]]</span>'
			}
		],
		chartScrollbar: {
			graph: 'g1',
			oppositeAxis: false,
			offset: 30,
			scrollbarHeight: 80,
			backgroundAlpha: 0,
			selectedBackgroundAlpha: 0.1,
			selectedBackgroundColor: '#888888',
			graphFillAlpha: 0,
			graphLineAlpha: 0.5,
			selectedGraphFillAlpha: 0,
			selectedGraphLineAlpha: 1,
			autoGridCount: true,
			color: '#AAAAAA'
		},
		chartCursor: {
			pan: true,
			valueLineEnabled: true,
			valueLineBalloonEnabled: true,
			cursorAlpha: 1,
			cursorColor: '#258cbb',
			limitToGraph: 'g1',
			valueLineAlpha: 0.2,
			valueZoomable: true
		},
		valueScrollbar: { oppositeAxis: false, offset: 50, scrollbarHeight: 10 },
		categoryField: 'date',
		categoryAxis: { parseDates: true, dashLength: 1, minorGridEnabled: true, minPeriod: 'hh' },
		export: { enabled: true },
		dataProvider: data
	});
}
