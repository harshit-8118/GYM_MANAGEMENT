<?php
    include 'backend/config.php';
    if(!file_exists('backend/database.php')){
        header('location: locate');
        die();
    }
    if(!session_id()){ session_start(); }
    if(!isset($_SESSION['admin_name'])){
        header('location: index.php');
    }

    $db = new Database();
    $db->select('settings', "*", null, null, null, null);
    $result = $db->getResult();
    $currency_format = $result[0]['gym_currency'];
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if(isset($title) && $title != ''){ ?>
    <title><?php echo $title.' > '.$result[0]['gym_name'] ?></title>
    <?php }else{ ?>
        <title><?php echo $result[0]['gym_name'] ?></title>
    <?php } ?>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/datatables.bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/jquery.dataTables.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h2><a href="dashboard.php" class="navbar-brand p-0"></a></h2>
            </div>

            <ul class="list-unstyled components">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li>
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        Membership Type
                        <!-- svg -->
                    </a>
                    <ul class="collapse list-unstyled text-color" id="homeSubmenu">
                        <li>
                            <a href="membership.php">Membership</a>
                        </li>
                        <li>
                            <a href="category.php">Category</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#homeSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        Member Management
                        <!-- svg -->
                    </a>
                    <ul class="collapse list-unstyled text-color" id="homeSubmenu1">
                        <li>
                            <a href="staff-member.php">Staff Member</a>
                        </li>
                        <li>
                            <a href="member.php">Member</a>
                        </li>
                        <li>
                            <a href="role.php">Role</a>
                        </li>
                        <li>
                            <a href="specialization.php">Specialization</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="group.php">Group</a>
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        Attendance
                        <!-- svg -->
                    </a>
                    <ul class="collapse list-unstyled text-color" id="pageSubmenu">
                        <li>
                            <a href="member-attendance.php">Member Attendance</a>
                        </li>
                        <li>
                            <a href="staff-attendance.php">Staff Member Attendance</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#reports" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        Reports
                        <!-- svg -->
                    </a>
                    <ul class="collapse list-unstyled text-color" id="reports">
                        <li>
                            <a href="attendance-report">Attendance Report</a>
                        </li>
                        <li>
                            <a href="membership-report.php">Membership Report</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="settings.php">Settings</a>
                </li>
            </ul>
        </nav>
        <div class="container-fluid p-0">
            <div class="content">
                <nav class="navbar navbar-expand-lg navbar-light bg-info">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-light"></button>
                    </div>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            hi, admin
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a href="profile.php" class="dropdown-item">Profile</a>
                            <a href="#" class="dropdown-item logout">Logout</a>
                        </div>
                    </div>
                </nav>