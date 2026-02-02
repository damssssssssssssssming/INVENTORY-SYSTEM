const products = [
  { id: 1, name: "Product A", price: 150, quantity: 120 },
  { id: 2, name: "Product B", price: 85, quantity: 8 },
  { id: 3, name: "Product C", price: 230, quantity: 0 },
  { id: 4, name: "Product D", price: 45, quantity: 45 },
];

const productTableBody = document.getElementById("productTableBody");
const searchInput = document.getElementById("searchInput");

function getStockStatus(qty) {
  if (qty === 0) return { label: "Out of Stock", class: "out" };
  if (qty <= 10) return { label: "Low Stock", class: "low" };
  return { label: "Available", class: "available" };
}

function renderProducts(list) {
  productTableBody.innerHTML = "";
  list.forEach((product) => {
    const status = getStockStatus(product.quantity);
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${product.name}</td>
      <td>₱${product.price.toFixed(2)}</td>
      <td>${product.quantity}</td>
      <td><span class="status ${status.class}">${status.label}</span></td>
      <td>
        <button class="action-btn" onclick="viewDetails(${product.id})">View</button>
        <button class="action-btn" onclick="editProduct(${product.id})">Edit</button>
        <button class="action-btn" onclick="updateStock(${product.id})">Update Stock</button>
        <button class="action-btn" onclick="deleteProduct(${product.id})">Delete</button>
      </td>
    `;
    productTableBody.appendChild(row);
  });
}

function viewDetails(id) {
  alert(`View details of product ID ${id}`);
}

function editProduct(id) {
  alert(`Edit product ID ${id}`);
}

function updateStock(id) {
  alert(`Update stock of product ID ${id}`);
}

function deleteProduct(id) {
  const confirmed = confirm("Are you sure you want to delete this product?");
  if (confirmed) {
    alert(`Product ID ${id} deleted.`);
  }
}

searchInput.addEventListener("input", () => {
  const filtered = products.filter((p) =>
    p.name.toLowerCase().includes(searchInput.value.toLowerCase())
  );
  renderProducts(filtered);
});

document.getElementById("backBtn").addEventListener("click", () => {
  window.location.href = "admin-dashboard.html"; // Adjust accordingly
});

renderProducts(products);
