<?php
include '../includes/db.php';
include '../includes/header.php';
session_start();

$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the employee ID from the session
    $employee_id = $_SESSION['id'];
    $leave_type = $_POST['leave_type'];
    $notes = $_POST['notes'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = 'Pending';

    $stmt = $pdo->prepare("INSERT INTO leaves (employee_id, leave_type, notes, start_date, end_date, status) VALUES (:employee_id, :leave_type, :notes, :start_date, :end_date, :status)");

    if ($stmt->execute(['employee_id' => $employee_id, 'leave_type' => $leave_type, 'notes' => $notes, 'start_date' => $start_date, 'end_date' => $end_date, 'status' => $status])) {
        $success_message = 'Leave application submitted successfully!';
    } else {
        $success_message = 'Failed to submit leave application. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Leave</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Apply for Leave</h2>
        <?php if (!empty($success_message)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="leave_type">Leave Type:</label>
                <input type="text" class="form-control" id="leave_type" name="leave_type" required>
            </div>
            <div class="form-group">
                <label for="notes">Notes:</label>
                <textarea class="form-control" id="notes" name="notes" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>


//done