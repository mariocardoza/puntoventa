$(function(){

	Highcharts.chart('container', {
	    chart: {
	        plotBackgroundColor: null,
	        plotBorderWidth: null,
	        plotShadow: false,
	        type: 'pie'
	    },
	    title: {
	        text: 'Browser market shares in January, 2018'
	    },
	    tooltip: {
	        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	    },
	    plotOptions: {
	        pie: {
	            allowPointSelect: true,
	            cursor: 'pointer',
	            dataLabels: {
	                enabled: true,
	                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
	                style: {
	                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
	                }
	            }
	        }
	    },
	    series: [{
	        name: 'Brands',
	        colorByPoint: true,
	        data: [{
	            name: 'Chrome',
	            y: 61.41,
	            sliced: true,
	            selected: true
	        }, {
	            name: 'Internet Explorer',
	            y: 11.84
	        }, {
	            name: 'Firefox',
	            y: 10.85
	        }, {
	            name: 'Edge',
	            y: 4.67
	        }, {
	            name: 'Safari',
	            y: 4.18
	        }, {
	            name: 'Sogou Explorer',
	            y: 1.64
	        }, {
	            name: 'Opera',
	            y: 1.6
	        }, {
	            name: 'QQ',
	            y: 1.2
	        }, {
	            name: 'Other',
	            y: 2.61
	        }]
	    }]
	});



	var chart = Highcharts.chart('container_mecanicos', {

	    title: {
	        text: 'Paros de Paros'
	    },

	    subtitle: {
	        text: 'Mecánicos'
	    },

	    xAxis: {
	        categories: ['Walter', 'Raul', 'Rudy', 'Brayan', 'Oscar', 'Ezequiel', 'Luis']
	    },

	    series: [{
	        type: 'column',
	        colorByPoint: true,
	        data: [5, 2, 4, 7, 20, 15, 17],
	        showInLegend: false
	    }]

	});


 

 

 


});