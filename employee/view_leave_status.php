<?php
include '../includes/db.php';
include '../includes/header.php';

$employee_id = 1; // Replace with the actual employee ID
$leaves = [];

if (isset($_POST['view_status'])) {
    $employee_id_to_view = $_POST['employee_id'];
    $stmt = $pdo->prepare("SELECT * FROM leaves WHERE employee_id = :employee_id");
    $stmt->execute(['employee_id' => $employee_id_to_view]);
    $leaves = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Leave Status</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS */
        body {
            padding: 20px;
        }
        .leave-card {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .status-badge {
            padding: 5px 8px;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
        }
        .status-pending {
            background-color: #dc3545; /* Bootstrap danger color */
        }
        .status-approved {
            background-color: #28a745; /* Bootstrap success color */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Leave Status</h2>
        <form method="post">
            <div class="form-group">
                <label for="employee_id">Employee ID:</label>
                <input type="text" class="form-control" id="employee_id" name="employee_id" placeholder="Enter Employee ID">
            </div>
            <button type="submit" name="view_status" class="btn btn-primary">View Status</button>
        </form>

        <?php if (!empty($leaves)): ?>
            <div class="row">
                <?php foreach ($leaves as $leave): ?>
                    <div class="col-md-4">
                        <div class="leave-card">
                            <h4>Leave Type: <?php echo $leave['leave_type']; ?></h4>
                            <p><strong>Start Date:</strong> <?php echo $leave['start_date']; ?></p>
                            <p><strong>End Date:</strong> <?php echo $leave['end_date']; ?></p>
                            <p><strong>Status:</strong> 
                                <span class="status-badge <?php echo $leave['status'] === 'Pending' ? 'status-pending' : 'status-approved'; ?>">
                                    <?php echo $leave['status']; ?>
                                </span>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>