// Mock user data
const user = {
  name: "John Doe",
  email: "john@example.com",
  role: "Staff"
};

document.getElementById("name").textContent = user.name;
document.getElementById("email").textContent = user.email;
document.getElementById("currentRole").textContent = user.role;

const roleSelect = document.getElementById("roleSelect");
roleSelect.value = user.role;

document.getElementById("saveBtn").addEventListener("click", () => {
  const newRole = roleSelect.value;

  if (newRole !== user.role) {
    if (confirm(`Change role from ${user.role} to ${newRole}?`)) {
      user.role = newRole;
      alert("Role updated successfully!");
      window.location.href = "manage-users.html";
    }
  } else {
    alert("No changes made.");
  }
});

document.getElementById("cancelBtn").addEventListener("click", () => {
  if (confirm("Cancel and return to Manage Users?")) {
    window.location.href = "manage-users.html";
  }
});

document.getElementById("backBtn").addEventListener("click", () => {
  window.location.href = "admin-dashboard.html";
});
