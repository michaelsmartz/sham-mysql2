/**
 * Created by TaroonG on 11/9/2017.
 */
var DashboardApp = (function () {

    var getSimpleTotal = function (csvData) {
        var temp = [{
            text: 'Headcount',
            size: 0
        }];
        temp[0].size = d3.nest()
            .rollup(function (leaves) {
                return leaves.length;
            })
            .entries(csvData);
        return temp;
    };
    var dataGroupByFieldCount = function (csvData, field) {
        return d3.nest()
            .key(function (d) {
                return d[field];
            })
            .rollup(function (leaves) {
                return leaves.length;
            })
            .entries(csvData);
    };
    var getAverageScore = function (csvData) {
        var temp = [{
            text: 'Headcount',
            size: 0
        }];
        temp[0].size = d3.nest()
            .rollup(function (leaves) {
                return Math.round(d3.sum(leaves, function (d) {
                    return (d.TotalPoints / d.TotalThreshold) * 100;
                }) / leaves.length)
            })
            .entries(csvData);
        return temp;
    };

    var vizConfig = {
        resize: true,
        zoom: true,
        message: 'Loading...',
        margin: '20px 30px 20px 20px'
    };

    var drawCharts = function (chartType, options) {
        // draw common single output tree-map chart
        if (chartType === void 0) {
            chartType = "tree_map";
        }

        var chartOptions = Object.create(vizConfig);
        Object.assign(chartOptions, options);

        chartOptions.type = chartType;
        if (chartType == "tree_map") {
            if (chartOptions.set == 1) {
                Object.assign(chartOptions, {
                    id: "text",
                    text: "size",
                    size: "size",
                    font: {
                        size: 45,
                        color: "#FA7240"
                    },
                    class: 'base',
                    color: {
                        scale: ['#FFFFFF']
                    },
                    tooltip: {
                        share: false,
                        sub: "text"
                    }
                });
            } else {
                Object.assign(chartOptions, {
                    id: ["Sex", "Ethnicity"],
                    size: "Size",
                    color: {
                        "scale": ["#60C2BB", "#FA7240", "#FFD35F"],
                        "heatmap": ["#60C2BB", "#FA7240", "#FFD35F"],
                        "value": "Sex"
                    },
                    labels: {
                        "resize": true,
                        "font": {
                            "size": "14px"
                        },
                        "align": "left",
                        "valign": "top"
                    },
                    legend: {
                        "labels": true,
                        "filters": true,
                        "data": false,
                        "size": [15, 48],
                        "font": {
                            "size": 8,
                            "color": '#fff'
                        }
                    }
                });
            }
        }
        if (chartType == "bar") {
            delete chartOptions.zoom;
            if (chartOptions.set == 1) {
                Object.assign(chartOptions, {
                    id: "Department",
                    text: "",
                    x: {
                        "stacked": false,
                        "value": "Department"
                    },
                    y: "Size",
                    axes: {
                        background: {
                            color: 'white'
                        }
                    },
                    tooltip: ["Size"]
                });
            } else if (chartOptions.set == 2) {
                Object.assign(chartOptions, {
                    id: "Description",
                    text: "",
                    x: {
                        "stacked": false,
                        "value": "Description"
                    },
                    y: {
                        "value": "Available"
                    },
                    axes: {
                        background: {
                            color: 'white'
                        }
                    },
                    tooltip: ["Available"]
                });
            } else if (chartOptions.set == 3) {
                Object.assign(chartOptions, {
                    id: "Description",
                    text: "",
                    x: {
                        "stacked": false,
                        "value": "Description"
                    },
                    y: {
                        "value": "Participants"
                    },
                    axes: {
                        background: {
                            color: 'white'
                        }
                    },
                    tooltip: ["Participants"]
                });
            } else {

                var names = {
                    "year": "Date",
                    "name": "Product"
                };

                Object.assign(chartOptions, {
                    id: "name",
                    text: ['Product', 'Date'],
                    x: {
                        "value": "year"
                    },
                    y: {
                        stacked: false,
                        value: "Assessment"
                    },
                    tooltip: ['year', 'name'],
                    color: {
                        "scale": ["#60C2BB", "#FA7240", "#FFD35F"],
                        "heatmap": ["#60C2BB", "#FA7240", "#FFD35F"]
                    },
                    format: {
                        "text": function (text) {
                            if (names[text]) {
                                return names[text]
                            } else {
                                return text
                            }
                        }
                    },
                    ui: {
                        "position": "top",
                        "type": "button",
                        "value": [{
                            "label": "Period",
                            "value": [{
                                "All": 999
                            }, {
                                "Last 7 days": 6
                            }, {
                                "Last 30 days": 29
                            }],
                            "method": function (value, viz) {
                                viz.x({
                                    "solo": function (d) {
                                        if (value == 0 || value == 999) {
                                            return true;
                                        } else {
                                            var arrDays = makeDaysArray(value);
                                            return (arrDays.indexOf(d) > -1);
                                        }
                                    }
                                }).draw();
                            }
                        }]
                    }
                });
            }
        }
        if (chartType == "line") {
            Object.assign(chartOptions, {
                id: "Name",
                x: {
                    label: "",
                    value: "Year"
                },
                y: {
                    label: "",
                    value: "Count"
                },
                legend: {
                    "filters": true,
                    "resize": true,
                    "font": {
                        size: 9,
                        color: '#fff'
                    },
                    "size": [15, 50]
                },
                color: {
                    "scale": ["#60C2BB", "#BFBFBF"],
                    "heatmap": ["#60C2BB", "#BFBFBF"],
                    "value": "Name"
                },
                axes: {
                    background: {
                        color: 'white'
                    }
                },
                tooltip: ["Year", "Count"]
            });
        }
        if (chartType == "pie") {
            Object.assign(chartOptions, {
                id: "Name",
                x: {
                    label: "",
                    value: "Name"
                },
                y: {
                    label: "",
                    value: "value"
                },
                legend: {
                    "filters": true,
                    "resize": true,
                    "font": {
                        size: 9,
                        color: '#fff'
                    },
                    "size": [15, 50]
                },
                size: "value",
                color: {
                    "scale": ["#60C2BB", "#FA7240", "#FFD35F"],
                    "heatmap": ["#60C2BB", "#FA7240", "#FFD35F"]
                }
            });
        }

        if (chartOptions.hasOwnProperty('set')) {
            delete chartOptions.set; // extra property, remove as not part of d3plus
        }

        return d3plus.viz().config(chartOptions);

    };

    function savePng() {
        var parentEl = $(this).closest('.portlet-header');
        var el = $(parentEl).siblings('.content');
        var formatted = 'SHAM ' + $('.title', parentEl).text() + ' ' + moment().format('YYYYMMDD hhmmss');
        saveSvgAsPng($(el).find('svg')[0], formatted + ".png");
    }

    function saveCsv() {
        var parentEl = $(this).closest('.portlet-header');
        var el = $(parentEl).siblings('.content');
        var id = el.attr('id');
        chartObjects[id].csv();
    }

    function chartFocus() {
        $('.btn-focus').clickToggle(
            function (e) {
                //console.log($(this));
                //console.log($(this).closest('.grid-stack-item'));
                e.preventDefault();
                $(this).find('i.fa-eye').toggleClass('fa-eye-slash');
                $(this).closest('.grid-stack-item').addClass('widget-focus-enabled');
                $('body').addClass('focus-mode');
                $('<div id="focus-overlay"></div>').hide().appendTo('body').fadeIn(300);

            },
            function (e) {
                e.preventDefault();
                $theWidget = $(this).parents('.grid-stack-item');

                $(this).find('i.fa-eye').toggleClass('fa-eye-slash');
                $('body').removeClass('focus-mode');
                $('body').find('#focus-overlay').fadeOut(function () {
                    $(this).remove();
                    $theWidget.removeClass('widget-focus-enabled');
                });
            }
        );

    }

    function makeDaysArray(daysVal) {
        var arrDays = [];
        var today = moment();
        var lastDaysX = today.clone().subtract(daysVal, 'days');

        const range = moment.range(lastDaysX.format('YYYY-MM-DD'), today.format('YYYY-MM-DD'));
        range.by('day', function (temp) {
            arrDays.push(temp.format('YYYY-MM-DD'));
        }, false);

        return arrDays;
    }

    return {
        getSimpleTotal: getSimpleTotal,
        getAverageScore: getAverageScore,
        dataGroupByFieldCount: dataGroupByFieldCount,
        drawCharts: drawCharts,
        savePng: savePng,
        chartFocus: chartFocus
    };
})();