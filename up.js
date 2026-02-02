const products = [
  { id: 1, name: "Product A", quantity: 120 },
  { id: 2, name: "Product B", quantity: 8 },
  { id: 3, name: "Product C", quantity: 0 },
  { id: 4, name: "Product D", quantity: 45 },
];

const productSelect = document.getElementById("productSelect");
const currentStockSpan = document.getElementById("currentStock");

function populateProducts() {
  products.forEach(p => {
    const option = document.createElement("option");
    option.value = p.id;
    option.textContent = p.name;
    productSelect.appendChild(option);
  });
  updateCurrentStock();
}

function updateCurrentStock() {
  const selectedId = parseInt(productSelect.value);
  const product = products.find(p => p.id === selectedId);
  currentStockSpan.textContent = product.quantity;
}

productSelect.addEventListener("change", updateCurrentStock);

document.getElementById("updateStockForm").addEventListener("submit", function(e) {
  e.preventDefault();

  const productId = parseInt(productSelect.value);
  const quantityChange = Number(document.getElementById("quantityChange").value);
  const reason = document.getElementById("reason").value.trim();

  const product = products.find(p => p.id === productId);

  if (product.quantity + quantityChange < 0) {
    alert("Error: Stock cannot be negative.");
    return;
  }

  product.quantity += quantityChange;
  alert(`Stock updated! New quantity of ${product.name}: ${product.quantity}\nReason: ${reason || "N/A"}`);

  document.getElementById("quantityChange").value = "";
  document.getElementById("reason").value = "";
  updateCurrentStock();
});

document.getElementById("cancelBtn").addEventListener("click", function() {
  const confirmed = confirm("Are you sure you want to cancel and go back to the Admin Dashboard? Unsaved changes will be lost.");
  if (confirmed) {
    window.location.href = "admin-dashboard.html";
  }
});

document.getElementById("backBtn").addEventListener("click", function() {
  window.location.href = "admin-dashboard.html";
});

populateProducts();
