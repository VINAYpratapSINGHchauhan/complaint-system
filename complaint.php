<?php
session_start();
$page = 'complaint';
require 'config.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// Sanitize
function clean_input($data)
{
  return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $name = clean_input($_POST['name']);
  $email = clean_input($_POST['email']);
  $title = clean_input($_POST['title']);
  $category = clean_input($_POST['category']);
  $priority = clean_input($_POST['priority']);
  $description = clean_input($_POST['description']);

  // Validation
  if (empty($name) || empty($email) || empty($title) || empty($description)) {
    $error = "All required fields must be filled!";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email!";
  } else {

    // File upload
    $file_name = NULL;
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {

      $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
      $ext = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));

      if (in_array($ext, $allowed)) {
        $file_name = time() . "_" . basename($_FILES['attachment']['name']);
        move_uploaded_file($_FILES['attachment']['tmp_name'], "uploads/" . $file_name);
      } else {
        $error = "Invalid file type!";
      }
    }

    if (!isset($error)) {
      $stmt = $conn->prepare("INSERT INTO complaints (user_id, name, email, title, category, priority, description, attachment) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("isssssss", $_SESSION['user_id'], $name, $email, $title, $category, $priority, $description, $file_name);

      if ($stmt->execute()) {
        $success = true;
        $complaint_id = $stmt->insert_id;
      } else {
        $error = "Submission failed!";
      }
    }
  }
}

// Fetch user's complaints
$stmt = $conn->prepare("SELECT * FROM complaints WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include 'navbar.php'; ?>

<main>
  <div class="complaint-wrap">

    <div style="margin-bottom: 2rem;">
      <p class="section-title">Submit</p>
      <h2>File a New Complaint</h2>
      <p style="color: var(--text-secondary); margin-top: 0.4rem; font-size: 0.95rem;">
        Fill out the form below. We'll review your complaint and get back to you within 48 hours.
      </p>
    </div>

    <?php if (isset($success)): ?>
      <div class="alert alert-success">✅ Complaint submitted successfully! ID: #<?php echo $complaint_id; ?></div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
      <div class="alert alert-error">⚠️ <?php echo $error; ?></div>
    <?php endif; ?>

    <div class="card" style="padding: 2rem;">
      <form method="POST" enctype="multipart/form-data">

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
          <div class="form-group">
            <label>Your Name</label>
            <input type="text" name="name" required />
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required />
          </div>
        </div>

        <div class="form-group">
          <label>Complaint Title</label>
          <input type="text" name="title" required />
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
          <div class="form-group">
            <label>Category</label>
            <select name="category" required>
              <option value="">Select category</option>
              <option value="infrastructure">Infrastructure</option>
              <option value="service">Service Issue</option>
              <option value="billing">Billing</option>
              <option value="staff">Staff Behavior</option>
              <option value="safety">Safety</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="form-group">
            <label>Priority</label>
            <select name="priority">
              <option value="low">Low</option>
              <option value="medium" selected>Medium</option>
              <option value="high">High</option>
              <option value="urgent">Urgent</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Description</label>
          <textarea name="description" required></textarea>
        </div>

        <div class="form-group">
          <label>Attachment</label>
          <input type="file" name="attachment" />
        </div>

        <button type="submit" class="btn btn-primary">Submit Complaint 🚀</button>
      </form>
    </div>

    <!-- My Complaints -->
    <div style="margin-top: 3rem;">
      <h3>My Complaints</h3>

      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="complaint-item">
          <div>
            <div class="c-title"><?php echo htmlspecialchars($row['title']); ?></div>
            <div class="c-meta">
              Submitted on <?php echo date("d M Y", strtotime($row['created_at'])); ?>
              · Category: <?php echo $row['category']; ?>
            </div>
          </div>
          <span class="badge"><?php echo $row['status']; ?></span>
        </div>
      <?php endwhile; ?>

    </div>

  </div>
</main>

<?php include 'footer.php'; ?>