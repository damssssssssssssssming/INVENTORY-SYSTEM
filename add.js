document.getElementById("addProductForm").addEventListener("submit", function(e) {
  e.preventDefault();

  const name = document.getElementById("productName").value.trim();
  const stock = document.getElementById("initialStock").value.trim();
  const price = document.getElementById("price").value.trim();

  if (!name || stock === "" || price === "") {
    alert("Please fill in all fields.");
    return;
  }

  if (Number(stock) < 0) {
    alert("Stock cannot be negative.");
    return;
  }

  if (Number(price) < 0) {
    alert("Price cannot be negative.");
    return;
  }

  // Here you would send data to backend API to add product
  alert(`Product "${name}" added successfully!`);

  this.reset();
});

document.getElementById("cancelBtn").addEventListener("click", function() {
  const confirmed = confirm("Are you sure you want to cancel and go back to the Admin Dashboard? Unsaved data will be lost.");
  if (confirmed) {
    window.location.href = "admin-dashboard.html"; // Adjust as needed
  }
});

document.getElementById("backBtn").addEventListener("click", function() {
  window.location.href = "admin-dashboard.html"; // Adjust as needed
});
