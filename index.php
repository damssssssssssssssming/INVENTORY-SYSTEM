<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Tizen OS | Login</title>
<link rel="stylesheet" href="login.css">
</head>
<body>

<div class="container">
    <img src="T.jpg" class="logo">
    <h2>3 Ways Management Inventory System</h2>

    <form method="POST" action="login_process.php">

        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <select name="shift" required>
            <option value="">Select Shift</option>
            <option>Morning</option>
            <option>Mid</option>
            <option>Graveyard</option>
        </select>

        <button type="submit">Login</button>
    </form>

    <p class="signup-link">
        Don't have an account? <a href="create.php">Create Account</a>
    </p>

    <p class="forgot-link">
        Forgot password? <a href="forgot.php">Reset Here</a>
    </p>
</div>

</body>
</html>