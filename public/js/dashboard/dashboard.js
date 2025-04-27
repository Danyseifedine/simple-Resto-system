/**
 * Dashboard Charts Initialization
 */
function initDashboardCharts(tankFillLevels, tankTypeDistribution, monthlyDeliveries, tankUsageDistribution) {
    // Initialize Tank Fill Levels Chart (Bar Chart)
    initTankFillLevelsChart(tankFillLevels);

    // Initialize Tank Types Distribution Chart (Pie Chart)
    initTankTypeDistributionChart(tankTypeDistribution);

    // Initialize Monthly Deliveries Chart (Line Chart)
    initMonthlyDeliveriesChart(monthlyDeliveries);

    // Initialize Tank Usage Distribution Chart (Donut Chart)
    initTankUsageDistributionChart(tankUsageDistribution);
}

/**
 * Tank Fill Levels Chart (Bar Chart)
 */
function initTankFillLevelsChart(data) {
    const element = document.getElementById('tankFillLevelsChart');
    if (!element) return;

    const tankNames = data.map(item => item.name);
    const fillPercentages = data.map(item => item.fill_percentage);

    // Generate colors based on fill percentage
    const colors = fillPercentages.map(percentage => {
        if (percentage < 20) return '#F1416C'; // Danger - red
        if (percentage < 50) return '#FFC700'; // Warning - yellow
        return '#50CD89'; // Success - green
    });

    const options = {
        series: [{
            name: 'Fill Percentage',
            data: fillPercentages
        }],
        chart: {
            type: 'bar',
            height: 350,
            toolbar: {
                show: false
            },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800,
                animateGradually: {
                    enabled: true,
                    delay: 150
                },
                dynamicAnimation: {
                    enabled: true,
                    speed: 350
                }
            }
        },
        plotOptions: {
            bar: {
                horizontal: true,
                barHeight: '70%',
                distributed: true,
                dataLabels: {
                    position: 'top'
                },
                borderRadius: 5
            }
        },
        colors: colors,
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val + '%';
            },
            offsetX: 20,
            style: {
                fontSize: '12px',
                fontWeight: 'bold',
                colors: ['#304758']
            }
        },
        xaxis: {
            categories: tankNames,
            labels: {
                show: true,
                style: {
                    fontWeight: 'bold'
                }
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        yaxis: {
            labels: {
                show: true,
                style: {
                    fontWeight: 'bold'
                }
            }
        },
        grid: {
            show: false
        },
        tooltip: {
            theme: 'dark',
            y: {
                formatter: function (val) {
                    return val + '% filled';
                }
            }
        }
    };

    const chart = new ApexCharts(element, options);
    chart.render();
}

/**
 * Tank Types Distribution Chart (Pie Chart)
 */
function initTankTypeDistributionChart(data) {
    const element = document.getElementById('tankTypeDistributionChart');
    if (!element) return;

    const labels = data.map(item => item.name);
    const values = data.map(item => item.count);

    const options = {
        series: values,
        chart: {
            type: 'pie',
            height: 350,
            toolbar: {
                show: false
            },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800,
                animateGradually: {
                    enabled: true,
                    delay: 150
                },
                dynamicAnimation: {
                    enabled: true,
                    speed: 350
                }
            }
        },
        labels: labels,
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }],
        colors: ['#009EF7', '#50CD89', '#F1416C', '#7239EA', '#FFC700', '#181C32'],
        stroke: {
            width: 0
        },
        dataLabels: {
            enabled: true,
            formatter: function (val, opts) {
                return opts.w.config.series[opts.seriesIndex] + ' (' + val.toFixed(1) + '%)';
            },
            style: {
                fontSize: '14px',
                fontWeight: 'bold'
            },
            dropShadow: {
                enabled: true
            }
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '14px',
            markers: {
                width: 12,
                height: 12,
                radius: 12
            },
            itemMargin: {
                horizontal: 10,
                vertical: 5
            }
        },
        tooltip: {
            theme: 'dark',
            y: {
                formatter: function (val) {
                    return val + ' tanks';
                }
            }
        },
        plotOptions: {
            pie: {
                expandOnClick: true,
                donut: {
                    size: '0%'
                }
            }
        }
    };

    const chart = new ApexCharts(element, options);
    chart.render();
}

/**
 * Monthly Deliveries Chart (Line Chart)
 */
function initMonthlyDeliveriesChart(data) {
    const element = document.getElementById('monthlyDeliveriesChart');
    if (!element) return;

    const months = data.map(item => item.month);
    const quantities = data.map(item => item.total);

    const options = {
        series: [{
            name: 'Total Quantity',
            data: quantities
        }],
        chart: {
            height: 350,
            type: 'area',
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800,
                animateGradually: {
                    enabled: true,
                    delay: 150
                },
                dynamicAnimation: {
                    enabled: true,
                    speed: 350
                }
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        colors: ['#009EF7'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.3,
                stops: [0, 90, 100]
            }
        },
        grid: {
            borderColor: '#f1f1f1',
            row: {
                colors: ['#f3f3f3', 'transparent'],
                opacity: 0.5
            }
        },
        xaxis: {
            categories: months,
            labels: {
                style: {
                    fontWeight: 'bold'
                }
            }
        },
        yaxis: {
            labels: {
                formatter: function (val) {
                    return val.toFixed(0);
                },
                style: {
                    fontWeight: 'bold'
                }
            }
        },
        markers: {
            size: 5,
            colors: ['#009EF7'],
            strokeColors: '#fff',
            strokeWidth: 2,
            hover: {
                size: 7
            }
        },
        tooltip: {
            theme: 'dark',
            y: {
                formatter: function (val) {
                    return val.toFixed(0) + ' units';
                }
            }
        }
    };

    const chart = new ApexCharts(element, options);
    chart.render();
}

/**
 * Tank Usage Distribution Chart (Donut Chart)
 */
function initTankUsageDistributionChart(data) {
    const element = document.getElementById('tankUsageDistributionChart');
    if (!element) return;

    const labels = data.map(item => item.name);
    const values = data.map(item => item.count);

    const options = {
        series: values,
        chart: {
            type: 'donut',
            height: 350,
            toolbar: {
                show: false
            },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800,
                animateGradually: {
                    enabled: true,
                    delay: 150
                },
                dynamicAnimation: {
                    enabled: true,
                    speed: 350
                }
            }
        },
        labels: labels,
        colors: ['#7239EA', '#F1416C', '#009EF7', '#50CD89', '#FFC700'],
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }],
        stroke: {
            width: 0
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '50%',
                    background: 'transparent',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '22px',
                            fontWeight: 'bold',
                            color: undefined,
                            offsetY: -10
                        },
                        value: {
                            show: true,
                            fontSize: '16px',
                            fontWeight: 'bold',
                            color: undefined,
                            offsetY: 16,
                            formatter: function (val) {
                                return val;
                            }
                        },
                        total: {
                            show: true,
                            label: 'Total',
                            fontSize: '16px',
                            fontWeight: 'bold',
                            color: '#373d3f',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                            }
                        }
                    }
                }
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val, opts) {
                return opts.w.config.series[opts.seriesIndex] + ' (' + val.toFixed(1) + '%)';
            },
            style: {
                fontSize: '14px',
                fontWeight: 'bold'
            },
            dropShadow: {
                enabled: true
            }
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '14px',
            markers: {
                width: 12,
                height: 12,
                radius: 12
            },
            itemMargin: {
                horizontal: 10,
                vertical: 5
            }
        },
        tooltip: {
            theme: 'dark',
            y: {
                formatter: function (val) {
                    return val + ' tanks';
                }
            }
        }
    };

    const chart = new ApexCharts(element, options);
    chart.render();
}
