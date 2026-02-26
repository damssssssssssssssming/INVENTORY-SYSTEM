<!DOCTYPE html>
<html>
<head>
  <title>Create Account</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="container">
  <h2>Create Account</h2>

  <form method="POST" action="create_process.php">

    <input type="text" name="fullname" placeholder="Full Name" required>

    <input type="text" name="username" placeholder="Username" required>

    <input type="password" name="password" placeholder="Password" required>

    <select name="shift" required>
      <option value="">Select Shift</option>
      <option>Morning</option>
      <option>Mid</option>
      <option>Graveyard</option>
    </select>

    <button type="submit">Register</button>

  </form>

  <a href="login.php">Back to Login</a>

</div>

</body>
</html>