const orders = [
  { id: 103, datetime: "2026-02-01 12:15", user: "Alice Lee", total: 450.00 },
  { id: 106, datetime: "2026-02-01 14:00", user: "Tom Cruz", total: 780.25 },
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
  alert(`View details for Cancelled Order ID ${id}`);
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
