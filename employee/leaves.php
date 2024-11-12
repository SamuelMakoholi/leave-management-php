<?php
session_start(); // Start session to access session variables
include '../includes/db.php';
include '../includes/header.php';



if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employee') {
    header("Location: ../index.php");
    exit();
}


$employee_id = $_SESSION['id']; 


$leaves = fetchLeaves($employee_id);

function fetchLeaves($employee_id) {
    global $pdo; 

 
    $stmt = $pdo->prepare("SELECT * FROM leaves WHERE employee_id = :employee_id");
    $stmt->execute(['employee_id' => $employee_id]);
    $leaves = $stmt->fetchAll(); 

    return $leaves;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel_leave'])) {
    $leave_id_to_cancel = $_POST['leave_id_to_cancel']; // Get leave ID from the form

    $stmt = $pdo->prepare("UPDATE leaves SET status = 'canceled' WHERE id = :leave_id");
    $stmt->execute(['leave_id' => $leave_id_to_cancel]); 

    header("Location: leaves.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Leaves</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS */
        body {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #dee2e6; /* Bootstrap table border color */
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa; /* Bootstrap table header background color */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Employee Leaves</h2>

        <!-- Buttons for View Leave Status and Cancel Leave -->
        <div class="mb-3">
            <a href="view_leave_status.php" class="btn btn-primary">View Leave Status</a>
            <a href="cancel_leave.php" class="btn btn-danger">Cancel Leave</a>
        </div>

        <!-- Display Leave Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leaves as $leave): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($leave['leave_type']); ?></td>
                        <td><?php echo htmlspecialchars($leave['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($leave['end_date']); ?></td>
                        <td><?php echo htmlspecialchars($leave['status']); ?></td>
                        <td>
                            <?php if ($leave['status'] === 'Pending'): ?>
                                <form method="post" action="view_leaves.php">
                                    <input type="hidden" name="leave_id_to_cancel" value="<?php echo $leave['id']; ?>">
                                    <button type="submit" name="cancel_leave" class="btn btn-danger">Cancel</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
