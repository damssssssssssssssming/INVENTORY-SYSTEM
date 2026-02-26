<!DOCTYPE html>
<html>
<head>
  <title>Forgot Password</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="container">
  <h2>Forgot Password</h2>

  <form method="POST" action="forgot_process.php">
    <input type="text" name="username" placeholder="Enter Username" required>
    <button type="submit">Reset Password</button>
  </form>

  <a href="login.php">Back to Login</a>
</div>

</body>
</html>