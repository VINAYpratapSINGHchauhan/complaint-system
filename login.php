<?php
session_start();
$page = 'login';
require 'config.php';

function clean_input($data)
{
  return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $email = clean_input($_POST['email']);
  $password = $_POST['password'];
  if ($email == 'admin@gmail.com' && $password == 'admin123') {
    $_SESSION['is_admin'] = true;
    header("Location: admin.php");
    exit();
  }
  if (empty($email) || empty($password)) {
    $error = "All fields are required!";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email format!";
  } else {
    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
      $user = $result->fetch_assoc();

      if (password_verify($password, $user['password'])) {

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];

        header("Location: complaint.php");
        exit();
      } else {
        $error = "Invalid password!";
      }
    } else {
      $error = "User not found!";
    }
  }
}
?>

<?php include 'navbar.php'; ?>

<main>
  <div class="auth-wrap">
    <div class="auth-card">
      <div class="logo-area">
        <div class="icon">🔐</div>
        <h2>Welcome Back</h2>
        <p class="sub">Login to your ComplaintHub account</p>
      </div>

      <?php if (isset($error)): ?>
        <div class="alert alert-error">⚠️ <?php echo $error; ?></div>
      <?php endif; ?>

      <form action="login.php" method="POST">
        <div class="form-group">
          <label>Email Address</label>
          <input type="email" name="email" placeholder="you@example.com" required />
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" placeholder="••••••••" required />
        </div>
        <button type="submit" class="btn btn-primary btn-full" style="margin-top: 0.5rem;">
          Login →
        </button>
      </form>

      <div class="divider">or</div>

      <div class="auth-footer">
        Don't have an account? <a href="register.php">Create one</a>
      </div>
      <div class="auth-footer" style="margin-top: 0.5rem;">
        <a href="admin.php" style="color: var(--text-muted);">Admin Login →</a>
      </div>
    </div>
  </div>
</main>

<?php include 'footer.php'; ?>