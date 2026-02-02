const inventory = [
    { name: "Product A", quantity: 120 },
    { name: "Product B", quantity: 8 },
    { name: "Product C", quantity: 0 },
    { name: "Product D", quantity: 45 }
];

const inventoryList = document.getElementById("inventoryList");

function getStockStatus(qty) {
    if (qty === 0) return { label: "Out of Stock", class: "out" };
    if (qty <= 10) return { label: "Low Stock", class: "low" };
    return { label: "Available", class: "available" };
}

function renderInventory() {
    inventoryList.innerHTML = "";

    inventory.forEach(item => {
        const status = getStockStatus(item.quantity);

        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${item.name}</td>
            <td>${item.quantity}</td>
            <td>
                <span class="status ${status.class}">
                    ${status.label}
                </span>
            </td>
        `;

        inventoryList.appendChild(row);
    });
}

document.getElementById("backToDashboard").addEventListener("click", () => {
    window.location.href = "dashboard.html";
});

renderInventory();
