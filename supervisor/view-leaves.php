<?php
include '../includes/db.php';
include '../includes/header.php';

$leaves = [];

// Fetch all leaves applied by employees
$stmt = $pdo->prepare("SELECT * FROM leaves");
$stmt->execute();
$leaves = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor View - Employee Leaves</title>
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
        <h2>Employee Leaves - Supervisor View</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Employee ID</th>
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
                        <td><?php echo $leave['employee_id']; ?></td>
                        <td><?php echo $leave['leave_type']; ?></td>
                        <td><?php echo $leave['start_date']; ?></td>
                        <td><?php echo $leave['end_date']; ?></td>
                        <td><?php echo $leave['status']; ?></td>
                        <td>
                            <?php if ($leave['status'] === 'Pending'): ?>
                                <form class="action-form">
                                    <input type="hidden" name="leave_id" value="<?php echo $leave['leave_id']; ?>">
                                    <button type="button" class="btn btn-success approve-leave">Approve</button>
                                    <button type="button" class="btn btn-danger cancel-leave">Cancel</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.approve-leave').click(function() {
            var leaveId = $(this).closest('form').find('input[name="leave_id"]').val();
            $.post('process_leave.php', { action: 'approve', leave_id: leaveId }, function(data) {
                alert(data); 
                location.reload();
            });
        });

        $('.cancel-leave').click(function() {
            var leaveId = $(this).closest('form').find('input[name="leave_id"]').val();
            $.post('process_leave.php', { action: 'cancel', leave_id: leaveId }, function(data) {
                alert(data); 
                location.reload();
            });
        });
    });
</script>
</body>
</html>