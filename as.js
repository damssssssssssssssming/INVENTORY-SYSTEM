document.getElementById("assignShiftForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const user = document.getElementById("user").value;
  const role = document.getElementById("role").value;
  const date = document.getElementById("date").value;
  const shift = document.getElementById("shift").value;

  if (!user || !role || !date) {
    alert("Please fill all fields");
    return;
  }

  alert(`Shift Assigned:
User: ${user}
Role: ${role}
Date: ${date}
Shift: ${shift}`);
});
