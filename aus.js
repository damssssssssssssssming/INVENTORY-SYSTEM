const logs = [
  { datetime: "2026-02-01 10:15", user: "John Doe", action: "Login", details: "Successful login" },
  { datetime: "2026-02-01 11:00", user: "Jane Smith", action: "Create Order", details: "Order ID 102 created" },
  { datetime: "2026-02-01 12:30", user: "Mark Tan", action: "Edit User", details: "Edited user Jane Smith" },
];

const tableBody = document.getElementById("logsTableBody");
const searchInput = document.getElementById("searchInput");

function renderLogs(list) {
  tableBody.innerHTML = "";
  list.forEach(log => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${log.datetime}</td>
      <td>${log.user}</td>
      <td>${log.action}</td>
      <td>${log.details}</td>
    `;
    tableBody.appendChild(row);
  });
}

searchInput.addEventListener("input", () => {
  const filtered = logs.filter(log =>
    log.user.toLowerCase().includes(searchInput.value.toLowerCase()) ||
    log.action.toLowerCase().includes(searchInput.value.toLowerCase()) ||
    log.details.toLowerCase().includes(searchInput.value.toLowerCase())
  );
  renderLogs(filtered);
});

document.getElementById("exportBtn").addEventListener("click", () => {
  alert("Export feature placeholder — integrate CSV/Excel export here");
});

document.getElementById("backBtn").addEventListener("click", () => {
  window.location.href = "admin-dashboard.html";
});

renderLogs(logs);
