<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Complaint System— Home</title>
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <!-- navbar.php -->

  <nav class="navbar">
    <a href="index.php" class="nav-brand">
      <div class="dot"></div>
      Complaint<span>System</span>
    </a>

    <div class="nav-links">
      <a href="index.php" class="active">Home</a>
      <a href="complaint.php">File Complaint</a>

      <?php if (isset($_SESSION['user_id'])): ?>
        <span style="color: var(--text-muted); font-size: 0.85rem;">
          👋 Hi !! <?php echo explode(' ', $_SESSION['user_name'])[0]; ?>
        </span>
        <a href="logout.php" class="btn-nav" style="background: var(--danger);">Logout</a>
      <?php else: ?>
        <!-- ❌ Not Logged In -->
        <a href="login.php" class="btn-nav">Login</a>
      <?php endif; ?>

    </div>
  </nav>