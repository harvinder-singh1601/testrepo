// Spline chart
FusionCharts.ready(function(){
    var fusioncharts = new FusionCharts({
    type: 'msspline',
    renderAt: 'chart-container',
    width: '100%',
    height: '250',
    dataFormat: 'json',
    dataSource: {
        "chart": {
            "caption": "",
            "subCaption": "",
            "captionFontSize": "14",
            "subcaptionFontSize": "14",
            "baseFontColor": "#333333",
            "baseFont": "Helvetica Neue,Arial",
            "subcaptionFontBold": "0",
            "xAxisName": "Time period (year)",
            "yAxisName": "Revenue ($)",
            "showValues": "0",
            "paletteColors": "#0075c2,#1aaf5d",
            "bgColor": "#ffffff",
            "showBorder": "0",
            "showShadow": "0",
            "showAlternateHGridColor": "0",
            "showCanvasBorder": "0",
            "showXAxisLine": "1",
            "showYAxisLine": "1",
            "xAxisLineThickness": "1",
            "xAxisLineColor": "#999999",
            "canvasBgColor": "#ffffff",
            "legendBorderAlpha": "0",
            "legendShadow": "0",
            "divlineAlpha": "100",
            "divlineColor": "#999999",
            "divlineThickness": "0",
            "divLineIsDashed": "0",
            "divLineDashLen": "1",
            "divLineGapLen": "1"
        },
        "categories": [{
            "category": [{
                "label": "2011"
            }, {
                "label": "2012"
            }, {
                "label": "2013"
            }, {
                "label": "2014"
            }, {
                "label": "2015"
            }, {
                "label": "2016"
            }, {
                "label": "2017"
            }]
        }],

        "dataset": [{
            "seriesname": "Games played",
            "data": [{
                "value": "25123"
            }, {
                "value": "14233"
            }, {
                "value": "25507"
            }, {
                "value": "9110"
            }, {
                "value": "15529"
            }, {
                "value": "20803"
            }, {
                "value": "19202"
            }]
        }, {
            "seriesname": "Games created",
            "data": [{
                "value": "13400"
            }, {
                "value": "12800"
            }, {
                "value": "22800"
            }, {
                "value": "12400"
            }, {
                "value": "15800"
            }, {
                "value": "19800"
            }, {
                "value": "21800"
            }]
        }]
    }
}
);
    fusioncharts.render();
});


// Google pie chart
google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(Chart);
      function Chart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Played',     35],
          ['Created',      35],
          ['Others',  30]
        ]);

        var options = {
          title: 'Games',
          // pieHole: 0.4,
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }


// Google column chart
google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Donation'],
          ['2014', 1000],
          ['2015', 1170],
          ['2016', 660],
          ['2017', 1030]
        ]);

        var options = {
          chart: {
            title: 'Donation',
            subtitle: '$500'
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }

