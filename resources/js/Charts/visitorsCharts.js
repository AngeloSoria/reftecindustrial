import Chart from 'chart.js/auto';
import ChartDataLabels from 'chartjs-plugin-datalabels';

export function initVisitorsChart() {
    const canvas = document.getElementById('chart_visitors');
    if (!canvas) return; // Stop if the canvas isn't on the current page

    const data = {
        labels: ['Philippines', 'United States', 'Japan', 'Canada', 'Australia', 'United Kingdom'],
        datasets: [
            {
                label: 'Visitors',
                data: [3200, 2700, 1800, 1200, 950, 800],
                backgroundColor: [
                    '#3B82F6', // blue
                    '#10B981', // green
                    '#F59E0B', // amber
                    '#EF4444', // red
                    '#8B5CF6', // violet
                    '#06B6D4'  // cyan
                ],
                borderRadius: 6,
            }
        ]
    };

    new Chart(canvas, {
        type: 'bar',
        data,
        options: {
            indexAxis: 'y', // Horizontal bars
            plugins: {
                legend: { display: false },
                datalabels: {
                    color: '#fff',
                    anchor: 'end',
                    align: 'start',
                    formatter: (value) => value.toLocaleString(),
                    font: {
                        weight: 'regular',
                        size: 12,
                    },
                },
                title: {
                    display: true,
                    text: 'Website Visitors by Countries (October 2025)',
                    font: { size: 14 },
                    padding: { bottom: 15 },
                },
            },
            scales: {
                x: { beginAtZero: true, grid: { display: false } },
                y: { grid: { display: false } },
            },
        },
        plugins: [ChartDataLabels],
    });
}
