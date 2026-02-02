// Mock user data
const user = {
  name: "John Doe",
  email: "john@example.com",
  role: "Staff",
  status: "Active" // or "Inactive"
};

document.getElementById("name").textContent = user.name;
document.getElementById("email").textContent = user.email;
document.getElementById("role").textContent = user.role;

const statusEl = document.getElementById("status");
const toggleBtn = document.getElementById("toggleBtn");

function updateUI() {
  statusEl.textContent = user.status;
  statusEl.className = `status ${user.status.toLowerCase()}`;

  if (user.status === "Active") {
    toggleBtn.textContent = "Deactivate User";
    toggleBtn.classList.add("deactivate");
  } else {
    toggleBtn.textContent = "Activate User";
    toggleBtn.classList.remove("deactivate");
  }
}

toggleBtn.addEventListener("click", () => {
  const confirmMsg =
    user.status === "Active"
      ? "Are you sure you want to deactivate this user?"
      : "Are you sure you want to activate this user?";

  if (confirm(confirmMsg)) {
    user.status = user.status === "Active" ? "Inactive" : "Active";
    alert(`User is now ${user.status}`);
    window.location.href = "manage-users.html";
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

updateUI();
a