function login() {
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    const shift = document.getElementById("shift").value;
    const msg = document.getElementById("msg");

    if (!username || !password || !shift) {
        msg.textContent = "Please fill in all fields.";
        return;
    }

    if (username === "admin" && password === "admin123") {
        window.location.href = "ad.html";
    } else if (
        (username === "user1" && password === "user123") ||
        (username === "user2" && password === "user123")
    ) {
        window.location.href = "dashboard.html";
    } else {
        msg.textContent = "Invalid username or password.";
    }
}

function createAccount() {
    alert("Account created successfully!");
    window.location.href = "login.html";
}

function resetPassword() {
    document.getElementById("msg").textContent =
        "Password reset request sent to Admin.";
}
