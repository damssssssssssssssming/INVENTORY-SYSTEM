const users = [
  { id: 1, name: "John Doe", email: "john@example.com", role: "Staff", status: "active", shift: "Morning" },
  { id: 2, name: "Jane Smith", email: "jane@example.com", role: "User", status: "inactive", shift: "Evening" },
  { id: 3, name: "Mark Tan", email: "mark@example.com", role: "Admin", status: "active", shift: "Night" },
];

const tableBody = document.getElementById("usersTableBody");

function renderUsers() {
  tableBody.innerHTML = "";
  users.forEach(user => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${user.name}</td>
      <td>${user.email}</td>
      <td>${user.role}</td>
      <td><span class="status ${user.status}">${user.status.charAt(0).toUpperCase() + user.status.slice(1)}</span></td>
      <td>${user.shift}</td>
      <td>
        <button class="action-btn" onclick="editUser(${user.id})">Edit</button>
        <button class="action-btn" onclick="toggleStatus(${user.id})">${user.status === 'active' ? 'Deactivate' : 'Activate'}</button>
        <button class="action-btn" onclick="assignRole(${user.id})">Role</button>
        <button class="action-btn" onclick="assignShift(${user.id})">Shift</button>
      </td>
    `;
    tableBody.appendChild(row);
  });
}

function editUser(id) {
  alert(`Edit user ID ${id}`);
}

function toggleStatus(id) {
  const user = users.find(u => u.id === id);
  user.status = user.status === "active" ? "inactive" : "active";
  renderUsers();
}

function assignRole(id) {
  const role = prompt("Enter role (Admin / Staff / User):");
  if (role) {
    const user = users.find(u => u.id === id);
    user.role = role;
    renderUsers();
  }
}

function assignShift(id) {
  const shift = prompt("Enter shift (Morning / Evening / Night):");
  if (shift) {
    const user = users.find(u => u.id === id);
    user.shift = shift;
    renderUsers();
  }
}

document.getElementById("addUserBtn").addEventListener("click", () => {
  const name = prompt("Enter user name:");
  const email = prompt("Enter user email:");
  const role = prompt("Enter role (Admin / Staff / User):");
  const shift = prompt("Enter shift (Morning / Evening / Night):");
  if (name && email && role && shift) {
    users.push({ id: users.length + 1, name, email, role, status: "active", shift });
    renderUsers();
  }
});

document.getElementById("backBtn").addEventListener("click", () => {
  window.location.href = "admin-dashboard.html";
});

renderUsers();
