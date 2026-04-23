<?php
session_start();
require 'config.php';

// 🔐 Admin check (simple version)
if (!isset($_SESSION['is_admin'])) {
  header("Location: login.php");
  exit();
}

// 📊 Stats
$total = $conn->query("SELECT COUNT(*) as c FROM complaints")->fetch_assoc()['c'];
$pending = $conn->query("SELECT COUNT(*) as c FROM complaints WHERE status='Pending'")->fetch_assoc()['c'];
$resolved = $conn->query("SELECT COUNT(*) as c FROM complaints WHERE status='Resolved'")->fetch_assoc()['c'];
$users = $conn->query("SELECT COUNT(*) as c FROM users")->fetch_assoc()['c'];

// 📋 Fetch complaints
$result = $conn->query("SELECT * FROM complaints ORDER BY created_at DESC LIMIT 10");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard — ComplaintHub</title>
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>

  <nav class="navbar">
    <a href="index.php" class="nav-brand">
      <div class="dot"></div>
      Complaint<span>Hub</span>
    </a>
    <div class="nav-links">
      <span style="color: var(--text-muted); font-size: 0.82rem; padding: 0.4rem 0.8rem; background: rgba(255,255,255,0.04); border-radius: 50px;">
        👤 Admin Panel
      </span>
      <a href="logout.php" class="btn-nav" style="background: var(--danger);">Logout</a>
    </div>
  </nav>

  <div class="admin-layout">

    <aside class="sidebar">
      <p class="s-title">Navigation</p>
      <a href="admin.php" class="active">📊 Dashboard</a>
    </aside>

    <div class="admin-content">

      <div style="margin-bottom: 2rem;">
        <p class="section-title">Overview</p>
        <h2>Admin Dashboard</h2>
      </div>

      <!-- STATS -->
      <div class="stats-grid">
        <div class="stat-card purple">
          <div class="stat-icon">📋</div>
          <div class="stat-value"><?php echo $total; ?></div>
          <div class="stat-label">Total Complaints</div>
        </div>
        <div class="stat-card orange">
          <div class="stat-icon">⏳</div>
          <div class="stat-value"><?php echo $pending; ?></div>
          <div class="stat-label">Pending</div>
        </div>
        <div class="stat-card green">
          <div class="stat-icon">✅</div>
          <div class="stat-value"><?php echo $resolved; ?></div>
          <div class="stat-label">Resolved</div>
        </div>
        <div class="stat-card pink">
          <div class="stat-icon">👥</div>
          <div class="stat-value"><?php echo $users; ?></div>
          <div class="stat-label">Total Users</div>
        </div>
      </div>

      <!-- TABLE -->
      <div class="card" style="padding: 0; overflow: hidden; margin-top:20px;">
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>#ID</th>
                <th>Title</th>
                <th>User</th>
                <th>Category</th>
                <th>Date</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>

              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td>#<?php echo $row['id']; ?></td>
                  <td><?php echo htmlspecialchars($row['title']); ?></td>
                  <td><?php echo htmlspecialchars($row['name']); ?></td>
                  <td><?php echo $row['category']; ?></td>
                  <td><?php echo date("d M", strtotime($row['created_at'])); ?></td>

                  <td>
                    <span style="font-size:0.82rem; font-weight:600;">
                      <?php echo ucfirst($row['priority']); ?>
                    </span>
                  </td>

                  <td>
                    <span class="badge">
                      <?php echo $row['status']; ?>
                    </span>
                  </td>

                  <td>
                    <div style="display:flex; gap:0.4rem;">
                      <?php if ($row['status'] != 'Resolved'): ?>
                        <form method="POST" action="update_status.php">
                          <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                          <input type="hidden" name="status" value="Resolved">
                          <button class="btn btn-sm btn-success">Resolve</button>
                        </form>
                      <?php endif; ?>

                      <?php if ($row['status'] != 'Rejected'): ?>
                        <form method="POST" action="update_status.php">
                          <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                          <input type="hidden" name="status" value="Rejected">
                          <button class="btn btn-sm btn-danger">Reject</button>
                        </form>
                      <?php endif; ?>
                    </div>
                  </td>
                </tr>
              <?php endwhile; ?>

            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

</body>

</html>