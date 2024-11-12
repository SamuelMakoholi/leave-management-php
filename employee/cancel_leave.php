<?php
include '../includes/db.php';
include '../includes/header.php';

if (isset($_POST['cancel_leave'])) {
    $cancel_leave_id = $_POST['leave_id_to_cancel'];
    $stmt = $pdo->prepare("UPDATE leaves SET status = 'Cancelled' WHERE leave_id = :leave_id");
    $stmt->execute(['leave_id' => $cancel_leave_id]);
    echo "<script>alert('Leave application canceled successfully!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Leave Application</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS */
        body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cancel Leave Application</h2>
        <form method="post">
            <div class="form-group">
                <label for="leave_id_to_cancel">Leave Application ID to Cancel:</label>
                <input type="text" class="form-control" id="leave_id_to_cancel" name="leave_id_to_cancel" placeholder="Enter Leave ID">
            </div>
            <button type="submit" name="cancel_leave" class="btn btn-danger">Cancel Leave</button>
        </form>
    </div>
</body>
</html>