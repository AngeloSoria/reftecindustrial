import Chart from 'chart.js/auto';

export function initAcquisitionsChart() {
    const canvas = document.getElementById('chart_cartrack_trips');
    if (!canvas) return; // Prevent errors if the canvas doesn't exist

    const data = [
        { year: 2010, count: 10 },
        { year: 2011, count: 20 },
        { year: 2012, count: 15 },
        { year: 2013, count: 25 },
        { year: 2014, count: 22 },
        { year: 2015, count: 30 },
        { year: 2016, count: 28 },
    ];

    new Chart(canvas, {
        type: 'line',
        data: {
            labels: data.map(row => row.year),
            datasets: [
                {
                    label: 'Total Car Trips',
                    data: data.map(row => row.count),
                    fill: true,
                    borderColor: '#f59e0b',
                    tension: 0.1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
        }
    });
}
