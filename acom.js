const orders = [
  { id: 102, datetime: "2026-02-01 11:00", user: "Jane Smith", total: 850.00 },
  { id: 105, datetime: "2026-02-01 14:30", user: "Paul Chen", total: 1230.50 },
  { id: 107, datetime: "2026-02-01 15:10", user: "Anna Lee", total: 670.25 },
];

const tableBody = document.getElementById("ordersTableBody");
const searchInput = document.getElementById("searchInput");

function renderOrders(list) {
  tableBody.innerHTML = "";
  list.forEach(order => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${order.id}</td>
      <td>${order.datetime}</td>
      <td>${order.user}</td>
      <td>₱${order.total.toFixed(2)}</td>
      <td><button class="action-btn" onclick="viewOrder(${order.id})">View</button></td>
    `;
    tableBody.appendChild(row);
  });
}

function viewOrder(id) {
  alert(`View details for Order ID ${id}`);
}

searchInput.addEventListener("input", () => {
  const filtered = orders.filter(o =>
    o.id.toString().includes(searchInput.value) ||
    o.user.toLowerCase().includes(searchInput.value.toLowerCase())
  );
  renderOrders(filtered);
});

document.getElementById("backBtn").addEventListener("click", () => {
  window.location.href = "admin-dashboard.html";
});

renderOrders(orders);
