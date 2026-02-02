const orders = [
  { id: 101, datetime: "2026-02-01 10:30", status: "pending", user: "John Doe", total: 1200.50 },
  { id: 102, datetime: "2026-02-01 11:00", status: "completed", user: "Jane Smith", total: 850.00 },
  { id: 103, datetime: "2026-02-01 12:15", status: "canceled", user: "Alice Lee", total: 450.00 },
  { id: 104, datetime: "2026-02-01 13:20", status: "pending", user: "Mark Tan", total: 670.25 },
];

const tableBody = document.getElementById("ordersTableBody");
const searchInput = document.getElementById("searchInput");

function renderOrders(list) {
  tableBody.innerHTML = "";
  list.forEach(order => {
    const row = document.createElement("tr");
    let actions = `<button class="action-btn" onclick="viewOrder(${order.id})">View</button>`;

    if (order.status === "pending") {
      actions += `<button class="action-btn" onclick="editOrder(${order.id})">Edit</button>
                  <button class="action-btn" onclick="cancelOrder(${order.id})">Cancel</button>
                  <button class="action-btn" onclick="completeOrder(${order.id})">Complete</button>`;
    }

    row.innerHTML = `
      <td>${order.id}</td>
      <td>${order.datetime}</td>
      <td><span class="status ${order.status}">${order.status.charAt(0).toUpperCase() + order.status.slice(1)}</span></td>
      <td>${order.user}</td>
      <td>₱${order.total.toFixed(2)}</td>
      <td>${actions}</td>
    `;
    tableBody.appendChild(row);
  });
}

function viewOrder(id) {
  alert(`View details for Order ID ${id}`);
}

function editOrder(id) {
  alert(`Edit Order ID ${id}`);
}

function cancelOrder(id) {
  const confirmed = confirm(`Are you sure you want to cancel Order ID ${id}?`);
  if (confirmed) {
    const order = orders.find(o => o.id === id);
    order.status = "canceled";
    renderOrders(orders);
  }
}

function completeOrder(id) {
  const confirmed = confirm(`Mark Order ID ${id} as completed?`);
  if (confirmed) {
    const order = orders.find(o => o.id === id);
    order.status = "completed";
    renderOrders(orders);
  }
}

searchInput.addEventListener("input", () => {
  const filtered = orders.filter(o =>
    o.id.toString().includes(searchInput.value) ||
    o.user.toLowerCase().includes(searchInput.value.toLowerCase()) ||
    o.status.toLowerCase().includes(searchInput.value.toLowerCase())
  );
  renderOrders(filtered);
});

document.getElementById("backBtn").addEventListener("click", () => {
  window.location.href = "admin-dashboard.html";
});

renderOrders(orders);
