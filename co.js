const products = [
    { id: 1, name: "Product A", price: 25 },
    { id: 2, name: "Product B", price: 40 },
    { id: 3, name: "Product C", price: 15 }
];

const productList = document.getElementById("productList");
const grandTotalEl = document.getElementById("grandTotal");

function renderProducts() {
    products.forEach(product => {
        const row = document.createElement("tr");
        row.dataset.price = product.price;
        row.dataset.qty = 0;

        row.innerHTML = `
            <td>${product.name}</td>
            <td>₱${product.price.toFixed(2)}</td>
            <td>
                <div class="qty-control">
                    <button class="qty-btn minus">−</button>
                    <span class="qty-value">0</span>
                    <button class="qty-btn plus">+</button>
                </div>
            </td>
            <td class="row-total">₱0.00</td>
        `;

        productList.appendChild(row);
    });
}

function updateTotals() {
    let grandTotal = 0;

    document.querySelectorAll("#productList tr").forEach(row => {
        const qty = parseInt(row.dataset.qty);
        const price = parseFloat(row.dataset.price);
        const total = qty * price;

        row.querySelector(".qty-value").textContent = qty;
        row.querySelector(".row-total").textContent = `₱${total.toFixed(2)}`;

        grandTotal += total;
    });

    grandTotalEl.textContent = `₱${grandTotal.toFixed(2)}`;
}

productList.addEventListener("click", e => {
    const row = e.target.closest("tr");
    if (!row) return;

    let qty = parseInt(row.dataset.qty);

    if (e.target.classList.contains("plus")) qty++;
    if (e.target.classList.contains("minus") && qty > 0) qty--;

    row.dataset.qty = qty;
    updateTotals();
});

document.getElementById("submitOrder").addEventListener("click", () => {
    alert("Order submitted! Stock will be reduced.");
});

renderProducts();
updateTotals();
document.getElementById("cancelOrder").addEventListener("click", () => {
    const confirmCancel = confirm(
        "Are you sure you want to go back to the Dashboard?\nAll unsaved order data will be lost."
    );

    if (confirmCancel) {
        window.location.href = "dashboard.html";
    }
});
