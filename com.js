const completedOrders = [
    {
        id: "ORD-0998",
        createdAt: "2026-01-31 09:10 AM",
        completedAt: "2026-01-31 09:45 AM",
        user: "Admin"
    },
    {
        id: "ORD-0999",
        createdAt: "2026-01-31 10:20 AM",
        completedAt: "2026-01-31 10:55 AM",
        user: "Staff02"
    }
];

const tableBody = document.getElementById("completedOrders");

function renderCompletedOrders() {
    tableBody.innerHTML = "";

    completedOrders.forEach(order => {
        const row = document.createElement("tr");

        row.innerHTML = `
            <td>${order.id}</td>
            <td>${order.createdAt}</td>
            <td>${order.completedAt}</td>
            <td><span class="status completed">Completed</span></td>
            <td>${order.user}</td>
            <td>
                <button class="view-btn">View</button>
            </td>
        `;

        tableBody.appendChild(row);
    });
}

tableBody.addEventListener("click", e => {
    if (e.target.classList.contains("view-btn")) {
        const orderId = e.target.closest("tr").children[0].textContent;
        alert(`Viewing completed order ${orderId}`);
    }
});

renderCompletedOrders();
