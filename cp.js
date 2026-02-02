document.getElementById("passwordForm").addEventListener("submit", e => {
  e.preventDefault();

  const newPass = document.getElementById("newPass").value;
  const confirm = document.getElementById("confirm").value;

  if (newPass !== confirm) {
    alert("Passwords do not match!");
    return;
  }

  alert("Password updated successfully!");
  window.location.href = "admin-dashboard.html";
});

document.getElementById("cancelBtn").addEventListener("click", () => {
  if (confirm("Cancel password change?")) {
    window.location.href = "admin-dashboard.html";
  }
});

document.getElementById("backBtn").addEventListener("click", () => {
  window.location.href = "admin-dashboard.html";
});
