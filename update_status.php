<?php
session_start();
require 'config.php';

if(!isset($_SESSION['is_admin'])){
    die("Unauthorized");
}

$id = intval($_POST['id']);
$status = $_POST['status'];

$allowed = ['Pending','Resolved','Rejected','In Progress'];

if(in_array($status, $allowed)){
    $stmt = $conn->prepare("UPDATE complaints SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
}

header("Location: admin.php");
exit();
?>