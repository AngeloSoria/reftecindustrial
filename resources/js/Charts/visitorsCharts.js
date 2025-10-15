import Chart from 'chart.js/auto';
import ChartDataLabels from 'chartjs-plugin-datalabels';

export async function initVisitorsChart() {
    const canvas = document.getElementById('chart_visitors');
    if (!canvas) return;

    let thisChart;

    // 🟩 Placeholder data (while waiting for real fetch)
    const placeholderLabels = ['Loading...', 'Please wait', 'Fetching data'];
    const placeholderValues = [100, 100, 100];
    const placeholderColors = ['#E5E7EB', '#D1D5DB', '#9CA3AF'];

    // Initialize chart immediately with placeholder data
    thisChart = new Chart(canvas, {
        type: 'bar',
        data: {
            labels: placeholderLabels,
            datasets: [{
                label: 'Visitors',
                data: placeholderValues,
                backgroundColor: placeholderColors,
                borderRadius: 6,
            }],
        },
        options: {
            indexAxis: 'y',
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
                    text: `Top 10 Website Visitors by Countries (${new Date().toLocaleString('default', { month: 'long', year: 'numeric' })})`,
                    font: { size: 14 },
                    padding: { bottom: 15 },
                },
                tooltip: {
                    callbacks: {
                        // 🟨 Show full country name in tooltip
                        title: (context) => context[0].labelFull || context[0].label,
                    },
                },
            },
            scales: {
                x: { beginAtZero: true, grid: { display: true } },
                y: {
                    grid: { display: true },
                    ticks: {
                        // 🟨 Truncate long labels visually
                        callback: function (value) {
                            const label = this.getLabelForValue(value);
                            return label.length > 15 ? label.substring(0, 15) + '…' : label;
                        },
                    },
                },
            },
            responsive: true,
            maintainAspectRatio: true,
        },
        plugins: [ChartDataLabels],
    });

    // Function to fetch data and update chart
    async function fetchAndUpdateChart() {
        try {
            const response = await fetch('/visitors/countries-this-month');
            const data = await response.json();

            // 🟨 Store full and truncated names
            const labels = data.map(item => item.country);
            const truncatedLabels = labels.map(
                name => name.length > 15 ? name.substring(0, 15) + '…' : name
            );

            const values = data.map(item => item.total);

            const colors = [
                '#3B82F6', '#10B981', '#F59E0B',
                '#EF4444', '#8B5CF6', '#06B6D4',
                '#EC4899', '#22C55E', '#EAB308'
            ];
            const backgroundColors = labels.map((_, i) => colors[i % colors.length]);

            // Replace placeholder data with real data
            thisChart.data.labels = truncatedLabels.length ? truncatedLabels : ['No data'];
            thisChart.data.datasets[0].data = values.length ? values : [0];
            thisChart.data.datasets[0].backgroundColor = backgroundColors;

            // 🟨 Keep reference of full labels for tooltips
            thisChart.data.labelsFull = labels;

            thisChart.update();
        } catch (err) {
            console.error('Error fetching chart data:', err);
        }
    }

    // 🕐 Initial fetch after small delay
    fetchAndUpdateChart();

    // 🔁 Auto-refresh every 30 seconds
    setInterval(fetchAndUpdateChart, 30000);
}
