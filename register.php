<?php
session_start();
$page = 'register';
require 'config.php';

// Sanitize
function clean_input($data)
{
  return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $name = clean_input($_POST['name']);
  $email = clean_input($_POST['email']);
  $phone = clean_input($_POST['phone']);
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  // Validation
  if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
    $error = "All required fields must be filled!";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email format!";
  } elseif (strlen($password) < 8) {
    $error = "Password must be at least 8 characters!";
  } elseif ($password !== $confirm_password) {
    $error = "Passwords do not match!";
  } else {
    // Check duplicate email
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $error = "Email already registered!";
    } else {
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss", $name, $email, $phone, $hashed_password);

      if ($stmt->execute()) {
        $success = "Account created successfully!";
        header("Location: complaint.php");
      } else {
        $error = "Something went wrong!";
      }
    }
  }
}
?>


<?php include 'navbar.php'; ?>

<main>
  <div class="auth-wrap">
    <div class="auth-card">
      <div class="logo-area">
        <div class="icon">✨</div>
        <h2>Create Account</h2>
        <p class="sub">Join ComplaintHub — it's free</p>
      </div>

      <?php if (isset($error)): ?>
        <div class="alert alert-error">⚠️ <?php echo $error; ?></div>
      <?php endif; ?>

      <?php if (isset($success)): ?>
        <div class="alert alert-success">✅ <?php echo $success; ?></div>
      <?php endif; ?>

      <form action="register.php" method="POST">
        <div class="form-group">
          <label>Full Name</label>
          <input type="text" name="name" placeholder="Rahul Sharma" required />
        </div>
        <div class="form-group">
          <label>Email Address</label>
          <input type="email" name="email" placeholder="you@example.com" required />
        </div>
        <div class="form-group">
          <label>Phone Number</label>
          <input type="tel" name="phone" placeholder="+91 98765 43210" />
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" placeholder="Min. 8 characters" required />
        </div>
        <div class="form-group">
          <label>Confirm Password</label>
          <input type="password" name="confirm_password" placeholder="Re-enter password" required />
        </div>
        <button type="submit" class="btn btn-primary btn-full" style="margin-top: 0.5rem;">
          Create Account →
        </button>
      </form>

      <div class="auth-footer" style="margin-top: 1.2rem;">
        Already have an account? <a href="login.php">Login</a>
      </div>
    </div>
  </div>
</main>

<?php include 'footer.php'; ?>