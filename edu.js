const user = {
  name: "John Doe",
  email: "john@example.com",
  role: "Staff",
  shift: "Morning",
  status: "Active"
};

document.getElementById("name").value = user.name;
document.getElementById("email").value = user.email;
document.getElementById("role").value = user.role;
document.getElementById("shift").value = user.shift;
document.getElementById("status").value = user.status;

document.getElementById("editUserForm").addEventListener("submit", function (e) {
  e.preventDefault();

  user.name = document.getElementById("name").value;
  user.role = document.getElementById("role").value;
  user.shift = document.getElementById("shift").value;
  user.status = document.getElementById("status").value;

  alert("User updated successfully!");

  // TODO: send update to backend
  window.location.href = "manage-users.html";
});

document.getElementById("cancelBtn").addEventListener("click", () => {
  if (confirm("Cancel editing and return to Manage Users?")) {
    window.location.href = "manage-users.html";
  }
});

document.getElementById("backBtn").addEventListener("click", () => {
  window.location.href = "admin-dashboard.html";
});
