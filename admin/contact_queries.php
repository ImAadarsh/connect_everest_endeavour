<?php
session_start();
require_once '../common/config/db_connect.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Handle status update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query_id = filter_input(INPUT_POST, 'query_id', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
    
    try {
        $stmt = $conn->prepare("UPDATE contact_queries SET status = ? WHERE id = ?");
        $stmt->execute([$status, $query_id]);
        $success = "Status updated successfully!";
    } catch (PDOException $e) {
        $error = "Error updating status: " . $e->getMessage();
    }
}

// Fetch all contact queries
try {
    $stmt = $conn->query("SELECT * FROM contact_queries ORDER BY created_at DESC");
    $queries = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error fetching queries: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Queries - Connect Everest Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 250px;
        }
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(135deg, #0061f2 0%, #6900f2 100%);
            padding: 1rem;
            color: white;
            z-index: 1000;
        }
        .sidebar-logo {
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-logo img {
            width: 150px;
            margin-bottom: 1rem;
        }
        .sidebar-menu {
            padding: 1rem 0;
        }
        .sidebar-menu a {
            color: white;
            text-decoration: none;
            padding: 0.75rem 1rem;
            display: block;
            border-radius: 10px;
            transition: all 0.3s ease;
            margin-bottom: 0.5rem;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(255,255,255,0.1);
        }
        .sidebar-menu i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
        }
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }
        .card-header {
            background: white;
            border-bottom: 1px solid #e0e5ec;
            padding: 1.5rem;
            border-radius: 15px 15px 0 0 !important;
        }
        .card-body {
            padding: 1.5rem;
        }
        .btn {
            border-radius: 10px;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }
        .btn-primary {
            background: linear-gradient(135deg, #0061f2 0%, #6900f2 100%);
            border: none;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(105,0,242,0.2);
        }
        .table {
            vertical-align: middle;
        }
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 30px;
        }
        .top-bar {
            background: white;
            padding: 1rem 2rem;
            margin-bottom: 2rem;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }
        .modal-content {
            border: none;
            border-radius: 15px;
        }
        .modal-header {
            background: linear-gradient(135deg, #0061f2 0%, #6900f2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
        }
        .modal-body {
            padding: 2rem;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <img src="../inner_pages/assets/imgs/Logo-light.svg" alt="Connect Everest">
            <h6 class="mb-0">Admin Portal</h6>
        </div>
        <div class="sidebar-menu">
            <a href="index.php">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="manage_users.php">
                <i class="fas fa-users"></i> Users
            </a>
            <a href="contact_queries.php" class="active">
                <i class="fas fa-envelope"></i> Contact Queries
            </a>
            <a href="student_applications.php">
                <i class="fas fa-graduation-cap"></i> Students
            </a>
            <a href="employee_applications.php">
                <i class="fas fa-user-tie"></i> Employees
            </a>
            <a href="employer_requests.php">
                <i class="fas fa-building"></i> Employers
            </a>
            <a href="logout.php" class="mt-auto">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-bar d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Contact Queries</h4>
        </div>

        <?php if (isset($success)): ?>
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?php echo $success; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <!-- Queries Table Card -->
        <div class="card">
            <div class="card-body">
                <table id="queriesTable" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($queries as $query): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($query['id']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($query['created_at'])); ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-2">
                                        <div class="avatar-initial rounded-circle bg-label-primary">
                                            <?php echo strtoupper(substr($query['name'], 0, 2)); ?>
                                        </div>
                                    </div>
                                    <?php echo htmlspecialchars($query['name']); ?>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($query['email']); ?></td>
                            <td><?php echo htmlspecialchars($query['subject']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $query['status'] === 'new' ? 'danger' : 'success'; ?>">
                                    <?php echo ucfirst(htmlspecialchars($query['status'])); ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info me-1" onclick="viewQuery(<?php echo htmlspecialchars(json_encode($query)); ?>)">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <form method="post" class="d-inline">
                                    <input type="hidden" name="query_id" value="<?php echo $query['id']; ?>">
                                    <input type="hidden" name="status" value="<?php echo $query['status'] === 'new' ? 'read' : 'new'; ?>">
                                    <button type="submit" class="btn btn-sm btn-<?php echo $query['status'] === 'new' ? 'success' : 'warning'; ?>">
                                        <i class="fas fa-<?php echo $query['status'] === 'new' ? 'check' : 'undo'; ?>"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- View Query Modal -->
    <div class="modal fade" id="viewQueryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Query Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name</label>
                        <p id="modalName"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <p id="modalEmail"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Subject</label>
                        <p id="modalSubject"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Message</label>
                        <p id="modalMessage"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Date</label>
                        <p id="modalDate"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    
    <script>
    $(document).ready(function() {
        $('#queriesTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            pageLength: 10,
            order: [[0, 'desc']],
            responsive: true
        });
    });

    function viewQuery(query) {
        $('#modalName').text(query.name);
        $('#modalEmail').text(query.email);
        $('#modalSubject').text(query.subject);
        $('#modalMessage').text(query.message);
        $('#modalDate').text(new Date(query.created_at).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }));
        $('#viewQueryModal').modal('show');
    }
    </script>
</body>
</html> 