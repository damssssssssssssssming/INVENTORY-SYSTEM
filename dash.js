function logout() {
    window.location.href = "login.html";
}

function createOrder() {
    alert("Redirecting to Create Order page");
  window.location.href = "create-order.html";
}

function viewPending() {
    alert("Redirecting to Pending Orders page");
    window.location.href = "pending-orders.html";
}

function viewCompleted() {
    alert("Redirecting to Completed Orders page");
   window.location.href = "completed-orders.html";
}

function viewInventory() {
    alert("Redirecting to Inventory page");
window.location.href = "inventory.html";
}

window.onload = function () {
    console.log("Dashboard loaded");
};
