function navigateTo(page) {
    window.location.href = page;
}

function refreshDashboard() {
    location.reload();
}

function logoutAdmin() {
    if (confirm("Logout admin?")) {
        window.location.href = "index.php";
    }
}

new Chart(document.getElementById('ordersByHourChart'), {
    type: 'line',
    data: {
        labels: hourLabels,
        datasets: [{
            label: 'Orders',
            data: hourData,
            borderColor: '#1fa2ff',
            backgroundColor: 'rgba(31,162,255,0.2)',
            tension: 0.4,
            fill: true
        }]
    }
});

new Chart(document.getElementById('inventoryValueChart'), {
    type: 'bar',
    data: {
        labels: invLabels,
        datasets: [{
            label: 'Inventory Value ($)',
            data: invData,
            backgroundColor: '#12d8fa'
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});