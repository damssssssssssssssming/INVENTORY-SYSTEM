document.getElementById("applyBtn").addEventListener("click", () => {
  alert("Logs filtered successfully!");
  window.location.href = "user-logs.html";
});

document.getElementById("resetBtn").addEventListener("click", () => {
  document.getElementById("user").value = "";
  document.getElementById("action").value = "";
  document.getElementById("date").value = "";
});

document.getElementById("backBtn").addEventListener("click", () => {
  window.location.href = "admin-dashboard.html";
});
