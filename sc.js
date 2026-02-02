const shifts = [
  { name: "Morning", start: "08:00", end: "16:00" },
  { name: "Evening", start: "16:00", end: "00:00" },
  { name: "Night", start: "00:00", end: "08:00" }
];

const table = document.getElementById("shiftTable");

function render() {
  table.innerHTML = "";
  shifts.forEach((s, i) => {
    table.innerHTML += `
      <tr>
        <td>${s.name}</td>
        <td>${s.start}</td>
        <td>${s.end}</td>
        <td><button onclick="edit(${i})">Edit</button></td>
      </tr>
    `;
  });
}

function edit(i) {
  const start = prompt("New start time:", shifts[i].start);
  const end = prompt("New end time:", shifts[i].end);
  if (start && end) {
    shifts[i].start = start;
    shifts[i].end = end;
    render();
  }
}

document.getElementById("backBtn").onclick = () =>
  window.location.href = "admin-dashboard.html";

render();
