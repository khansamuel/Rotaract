<?php
include "mysql_connector.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['user_id'])) {
        $user_id = intval($_POST['user_id']);

        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            echo "<script>alert('User deleted successfully.'); window.location.href = 'viewMembers.php';</script>";
        } else {
            echo "<script>alert('Error deleting user: " . $stmt->error . "'); window.location.href = 'viewMembers.php';</script>";
        }

        $stmt->close();
    }
}

$conn->close();
?>
