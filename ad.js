function navigateTo(page) {
    // Navigate directly to the PHP page (no .html appended)
    window.location.href = page;
}

function exportLogs() {
    alert("Logs exported successfully");
}

function refreshDashboard() {
    location.reload();
}

function logoutAdmin() {
    if (confirm("Logout admin?")) {
        window.location.href = "login.php"; // Make sure login is PHP too
    }
}

// Chart.js initialization remains the same
new Chart(document.getElementById('stockChart'), {
    type: 'line',
    data: {
        labels: ['Mon','Tue','Wed','Thu','Fri','Sat'],
        datasets: [{
            data: [120, 90, 150, 80, 110, 70],
            borderColor: '#12d8fa',
            backgroundColor: 'rgba(18,216,250,0.2)',
            tension: 0.4,
            fill: true
        }]
    }
});

new Chart(document.getElementById('userActivityChart'), {
    type: 'bar',
    data: {
        labels: ['Admins','Staff','Warehouse'],
        datasets: [{
            data: [5,18,12],
            backgroundColor: '#12d8fa'
        }]
    }
});

new Chart(document.getElementById('inventoryChart'), {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun'],
        datasets: [{
            data: [300,280,350,320,400,370],
            borderColor: '#1fa2ff',
            backgroundColor: 'rgba(31,162,255,0.2)',
            tension: 0.4,
            fill: true
        }]
    }
});