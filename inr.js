const products = [
  { name: "Product A", price: 150, quantity: 120 },
  { name: "Product B", price: 85, quantity: 8 },
  { name: "Product C", price: 230, quantity: 0 },
  { name: "Product D", price: 45, quantity: 45 },
];

const tableBody = document.getElementById("reportTableBody");
const searchInput = document.getElementById("searchInput");

function getStockStatus(qty) {
  if (qty === 0) return { label: "Out of Stock", class: "out" };
  if (qty <= 10) return { label: "Low Stock", class: "low" };
  return { label: "Available", class: "available" };
}

function renderProducts(list) {
  tableBody.innerHTML = "";
  list.forEach(p => {
    const status = getStockStatus(p.quantity);
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${p.name}</td>
      <td>₱${p.price.toFixed(2)}</td>
      <td>${p.quantity}</td>
      <td><span class="status ${status.class}">${status.label}</span></td>
    `;
    tableBody.appendChild(row);
  });
}

searchInput.addEventListener("input", () => {
  const filtered = products.filter(p =>
    p.name.toLowerCase().includes(searchInput.value.toLowerCase())
  );
  renderProducts(filtered);
});

document.getElementById("exportBtn").addEventListener("click", () => {
  alert("Export function not implemented yet.");
});

document.getElementById("backBtn").addEventListener("click", () => {
  window.location.href = "admin-dashboard.html";
});

renderProducts(products);
