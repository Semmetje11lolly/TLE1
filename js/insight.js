let chart;

function fetchDataAndUpdate() {
    fetch("insights.php?json=1") // 👈 same file, but returns JSON
        .then(res => res.json())
        .then(data => {
            const labels = data.mood.map(r => r.dates.substring(5));
            const moods = data.mood.map(r => r.mood);
            const energy = data.energy.map(r => r.energy);

            if (!chart) {
                chart = new Chart(document.getElementById("myChart"), {
                    type: "line",
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: "Mood",
                                data: moods,
                                borderColor: "#9BBEC7",
                                fill: false
                            },
                            {
                                label: "Energy",
                                data: energy,
                                borderColor: "#FE938C",
                                fill: false
                            }
                        ]
                    },
                    options: {
                        animation: false,
                        responsive: true,
                        scales: {
                            y: {beginAtZero: false}
                        }
                    }
                });
            } else {
                chart.data.labels = labels;
                chart.data.datasets[0].data = moods;
                chart.data.datasets[1].data = energy;
                chart.update();
            }
        })
        .catch(err => console.error("Fetch error:", err));
}

// Run once immediately, then every 5s
window.onload = () => {
    fetchDataAndUpdate();
    setInterval(fetchDataAndUpdate, 5000);
}