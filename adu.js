document.getElementById("addUserForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const user = {
    name: document.getElementById("name").value,
    email: document.getElementById("email").value,
    password: document.getElementById("password").value,
    role: document.getElementById("role").value,
    shift: document.getElementById("shift").value,
    status: "Active"
  };

  alert(`User Created Successfully!\n\nName: ${user.name}\nRole: ${user.role}\nShift: ${user.shift}`);

  // TODO: send data to backend
  window.location.href = "manage-users.html";
});

document.getElementById("cancelBtn").addEventListener("click", () => {
  if (confirm("Cancel adding user and return to Manage Users?")) {
    window.location.href = "manage-users.html";
  }
});

document.getElementById("backBtn").addEventListener("click", () => {
  window.location.href = "admin-dashboard.html";
});
