const pendingOrders = [
    {
        id: "ORD-1001",
        datetime: "2026-02-01 10:32 AM",
        status: "Pending",
        user: "Admin"
    },
    {
        id: "ORD-1002",
        datetime: "2026-02-01 11:05 AM",
        status: "Pending",
        user: "Staff01"
    }
];

const tableBody = document.getElementById("pendingOrders");

function renderOrders() {
    tableBody.innerHTML = "";

    pendingOrders.forEach(order => {
        const row = document.createElement("tr");

        row.innerHTML = `
            <td>${order.id}</td>
            <td>${order.datetime}</td>
            <td>
                <span class="status pending">${order.status}</span>
            </td>
            <td>${order.user}</td>
            <td>
                <button class="action-btn view">View</button>
                <button class="action-btn edit">Edit</button>
                <button class="action-btn cancel">Cancel</button>
                <button class="action-btn complete">Complete</button>
            </td>
        `;

        tableBody.appendChild(row);
    });
}

tableBody.addEventListener("click", e => {
    const row = e.target.closest("tr");
    if (!row) return;

    const orderId = row.children[0].textContent;

    if (e.target.classList.contains("view")) {
        alert(`View details for ${orderId}`);
    }

    if (e.target.classList.contains("edit")) {
        alert(`Edit ${orderId}`);
    }

    if (e.target.classList.contains("cancel")) {
        const confirmCancel = confirm(`Cancel order ${orderId}?`);
        if (confirmCancel) {
            alert(`Order ${orderId} cancelled`);
        }
    }

    if (e.target.classList.contains("complete")) {
        const confirmComplete = confirm(`Mark order ${orderId} as completed?`);
        if (confirmComplete) {
            alert(`Order ${orderId} completed`);
        }
    }
});

renderOrders();
