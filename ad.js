function navigateTo(page) {
    window.location.href = page + ".html";
}

function exportLogs() {
    alert("Logs exported successfully");
}

function refreshDashboard() {
    location.reload();
}

function logoutAdmin() {
    if (confirm("Logout admin?")) {
        window.location.href = "login.html";
    }
}

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

new Chart(document.getElementById('orderShiftChart'), {
    type: 'bar',
    data: {
        labels: ['Morning','Afternoon','Night'],
        datasets: [{
            data: [45,70,30],
            backgroundColor: ['#1fa2ff','#12d8fa','#4db8ff']
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
