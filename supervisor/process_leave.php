<?php

include '../includes/db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['action']) && isset($_POST['leave_id'])) {
        $action = $_POST['action'];
        $leaveId = $_POST['leave_id'];

        if ($action === 'approve') {
            $updateStmt = $pdo->prepare("UPDATE leaves SET status = 'Approved' WHERE leave_id = ?");
            $updateStmt->execute([$leaveId]);
            echo "Leave request approved successfully.";
        } elseif ($action === 'cancel') {
            $updateStmt = $pdo->prepare("UPDATE leaves SET status = 'Cancelled' WHERE leave_id = ?");
            $updateStmt->execute([$leaveId]);
            echo "Leave request cancelled successfully.";
        } else {
            echo "Invalid action.";
        }
    } else {
        echo "Action and leave ID must be provided.";
    }
} else {
    echo "Invalid request method.";
}
?>