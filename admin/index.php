<?php
session_start();
require_once '../common/config/db_connect.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch statistics
try {
    $stats = [
        'contact_queries' => $conn->query("SELECT COUNT(*) FROM contact_queries")->fetchColumn(),
        'student_applications' => $conn->query("SELECT COUNT(*) FROM student_applications")->fetchColumn(),
        'employee_applications' => $conn->query("SELECT COUNT(*) FROM employee_applications")->fetchColumn(),
        'employer_requests' => $conn->query("SELECT COUNT(*) FROM employer_requests")->fetchColumn()
    ];

    // Fetch recent activities (combined from all tables)
    $recentActivities = $conn->query("
        (SELECT 'Contact Query' as type, name, email, created_at FROM contact_queries ORDER BY created_at DESC LIMIT 5)
        UNION ALL
        (SELECT 'Student Application' as type, name, email, created_at FROM student_applications ORDER BY created_at DESC LIMIT 5)
        UNION ALL
        (SELECT 'Employee Application' as type, name, email, created_at FROM employee_applications ORDER BY created_at DESC LIMIT 5)
        UNION ALL
        (SELECT 'Employer Request' as type, name, email, created_at FROM employer_requests ORDER BY created_at DESC LIMIT 5)
        ORDER BY created_at DESC LIMIT 10
    ")->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Connect Everest Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/apexcharts@3.45.1/dist/apexcharts.css" rel="stylesheet">
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
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .stat-number {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .activity-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }
        .activity-item {
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
            transition: background-color 0.3s ease;
        }
        .activity-item:hover {
            background-color: #f8f9fa;
        }
        .activity-item:last-child {
            border-bottom: none;
        }
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }
        .chart-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }
        .welcome-card {
            background: linear-gradient(135deg, #0061f2 0%, #6900f2 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
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
            <a href="index.php" class="active">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="manage_users.php">
                <i class="fas fa-users"></i> Users
            </a>
            <a href="contact_queries.php">
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
        <!-- Welcome Card -->
        <div class="welcome-card">
            <h2>Welcome back, <?php echo htmlspecialchars($_SESSION['admin_name']); ?>!</h2>
            <p class="mb-0">Here's what's happening with Connect Everest today.</p>
        </div>

        <!-- Statistics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(0, 97, 242, 0.1); color: #0061f2;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="stat-number"><?php echo $stats['contact_queries']; ?></div>
                    <div class="stat-label">Contact Queries</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(105, 0, 242, 0.1); color: #6900f2;">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stat-number"><?php echo $stats['student_applications']; ?></div>
                    <div class="stat-label">Student Applications</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(0, 172, 105, 0.1); color: #00ac69;">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="stat-number"><?php echo $stats['employee_applications']; ?></div>
                    <div class="stat-label">Employee Applications</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(244, 161, 0, 0.1); color: #f4a100;">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="stat-number"><?php echo $stats['employer_requests']; ?></div>
                    <div class="stat-label">Employer Requests</div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Chart -->
            <div class="col-lg-8">
                <div class="chart-card">
                    <h5 class="card-title mb-4">Applications Overview</h5>
                    <div id="applicationsChart"></div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="col-lg-4">
                <div class="activity-card">
                    <h5 class="card-title mb-4">Recent Activities</h5>
                    <?php foreach ($recentActivities as $activity): ?>
                    <div class="activity-item d-flex align-items-center">
                        <div class="activity-icon" style="background: <?php
                            switch($activity['type']) {
                                case 'Contact Query': echo 'rgba(0, 97, 242, 0.1)'; break;
                                case 'Student Application': echo 'rgba(105, 0, 242, 0.1)'; break;
                                case 'Employee Application': echo 'rgba(0, 172, 105, 0.1)'; break;
                                case 'Employer Request': echo 'rgba(244, 161, 0, 0.1)'; break;
                            }
                        ?>; color: <?php
                            switch($activity['type']) {
                                case 'Contact Query': echo '#0061f2'; break;
                                case 'Student Application': echo '#6900f2'; break;
                                case 'Employee Application': echo '#00ac69'; break;
                                case 'Employer Request': echo '#f4a100'; break;
                            }
                        ?>;">
                            <i class="fas <?php
                                switch($activity['type']) {
                                    case 'Contact Query': echo 'fa-envelope'; break;
                                    case 'Student Application': echo 'fa-graduation-cap'; break;
                                    case 'Employee Application': echo 'fa-user-tie'; break;
                                    case 'Employer Request': echo 'fa-building'; break;
                                }
                            ?>"></i>
                        </div>
                        <div>
                            <h6 class="mb-0"><?php echo htmlspecialchars($activity['name']); ?></h6>
                            <small class="text-muted">
                                <?php echo htmlspecialchars($activity['type']); ?> - 
                                <?php echo date('M d, Y', strtotime($activity['created_at'])); ?>
                            </small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.1/dist/apexcharts.min.js"></script>
    <script>
        // Applications Chart
        var options = {
            series: [{
                name: 'Applications',
                data: [
                    <?php echo $stats['contact_queries']; ?>,
                    <?php echo $stats['student_applications']; ?>,
                    <?php echo $stats['employee_applications']; ?>,
                    <?php echo $stats['employer_requests']; ?>
                ]
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 10,
                    dataLabels: {
                        position: 'top',
                    },
                }
            },
            dataLabels: {
                enabled: true,
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                }
            },
            xaxis: {
                categories: ["Contact Queries", "Student Applications", "Employee Applications", "Employer Requests"],
                position: 'bottom',
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false,
                }
            },
            colors: ['#0061f2', '#6900f2', '#00ac69', '#f4a100']
        };

        var chart = new ApexCharts(document.querySelector("#applicationsChart"), options);
        chart.render();
    </script>
</body>
</html> 