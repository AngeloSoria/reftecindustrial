
export async function initVisitorsChart() {
    const canvas = document.getElementById('widget_counter_total_visits');
    if (!canvas) return; // Stop if the canvas isn't on the current page

    async function fetchAndRefreshValue() {
        try {
            const counterElement = document.querySelector('#widget_counter_total_visits .counter-value');
            const changeElement = document.querySelector('#widget_counter_total_visits .change-value');
            const ratioElement = document.querySelector('#widget_counter_total_visits .ratio-value');
                        
            const response = await fetch('/visitors/widget-data');
            const data = await response.json();
            console.log(data);
            
            // fetch fail
            if(!data['success']) {
                counterElement.textContent = "ERROR";
                changeElement.textContent = "ERROR";
                ratioElement.textContent = "ERROR";
                return;
            }

            if (counterElement) {
                counterElement.textContent = data.data.counter.toLocaleString();
            }
            if (changeElement) {
                const changeValue = data.data.change;
                changeElement.textContent = (changeValue > 0 ? '+' : '') + changeValue.toLocaleString() + ' difference';
                changeElement.classList.toggle('hidden', changeValue == 0);
                changeElement.classList.toggle('text-green-600', changeValue > 0);
                changeElement.classList.toggle('text-red-600', changeValue < 0);
            }
            if (ratioElement) {
                const ratioValue = data.data.ratio;
                ratioElement.textContent = (ratioValue > 0 ? '+' : '') + ratioValue.toFixed(2) + '%';
                ratioElement.classList.toggle('text-gray-500', ratioValue == 0);
                ratioElement.classList.toggle('text-green-600', ratioValue > 0);
                ratioElement.classList.toggle('text-red-600', ratioValue < 0);
            }
        } catch (error) {
            console.error('Error fetching widget data:', error);
        }
    }

    // Initial fetch
    fetchAndRefreshValue();

    // Refresh every 30 seconds
    setInterval(fetchAndRefreshValue, 30000);
}
