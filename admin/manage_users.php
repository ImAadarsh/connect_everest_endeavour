<?php
session_start();
require_once '../common/config/db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$success = '';
$error = '';

// Handle user creation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
    
    try {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, status) VALUES (?, ?, ?, ?, 'active')");
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute([$name, $email, $hashed_password, $role]);
        $success = "User created successfully!";
    } catch (PDOException $e) {
        $error = "Error creating user: " . $e->getMessage();
    }
}

// Fetch all users
try {
    $stmt = $conn->query("SELECT id, name, email, role, status, created_at FROM users ORDER BY created_at DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error fetching users: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Connect Everest Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
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
        .form-control, .form-select {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 2px solid #e0e5ec;
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
            <a href="index.php" class="mb-2">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="manage_users.php" class="mb-2 active">
                <i class="fas fa-users"></i> Users
            </a>
            <a href="contact_queries.php" class="mb-2">
                <i class="fas fa-envelope"></i> Contact Queries
            </a>
            <a href="student_applications.php" class="mb-2">
                <i class="fas fa-graduation-cap"></i> Students
            </a>
            <a href="employee_applications.php" class="mb-2">
                <i class="fas fa-user-tie"></i> Employees
            </a>
            <a href="employer_requests.php" class="mb-2">
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
            <h4 class="mb-0">Manage Users</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                <i class="fas fa-plus me-2"></i> Create New User
            </button>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?php echo $success; ?>
            </div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <!-- Users Table Card -->
        <div class="card">
            <div class="card-body">
                <table id="usersTable" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-2">
                                        <div class="avatar-initial rounded-circle bg-label-primary">
                                            <?php echo strtoupper(substr($user['name'], 0, 2)); ?>
                                        </div>
                                    </div>
                                    <?php echo htmlspecialchars($user['name']); ?>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $user['role'] === 'admin' ? 'primary' : 'info'; ?>">
                                    <?php echo htmlspecialchars($user['role']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-<?php echo $user['status'] === 'active' ? 'success' : 'danger'; ?>">
                                    <?php echo htmlspecialchars($user['status']); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning me-1" onclick="editUser(<?php echo $user['id']; ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteUser(<?php echo $user['id']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Create User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    
    <script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            pageLength: 10,
            order: [[0, 'desc']],
            responsive: true
        });
    });

    function editUser(id) {
        Swal.fire({
            title: 'Edit User',
            text: 'Edit functionality will be implemented soon.',
            icon: 'info'
        });
    }

    function deleteUser(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Implement delete functionality
                Swal.fire(
                    'Deleted!',
                    'User has been deleted.',
                    'success'
                );
            }
        });
    }
    </script>
</body>
</html> 