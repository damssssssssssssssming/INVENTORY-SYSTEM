function logout() {
    window.location.href = "login.html";
}

function createOrder() {
    alert("Redirecting to Create Order page");
    // Later: window.location.href = "create-order.html";
}

function viewPending() {
    alert("Redirecting to Pending Orders page");
    // Later: window.location.href = "pending-orders.html";
}

function viewCompleted() {
    alert("Redirecting to Completed Orders page");
    // Later: window.location.href = "completed-orders.html";
}

function viewInventory() {
    alert("Redirecting to Inventory page");
    // Later: window.location.href = "inventory.html";
}

window.onload = function () {
    console.log("Dashboard loaded");
};
