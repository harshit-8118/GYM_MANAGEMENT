<?php

    include 'backend/config.php';
    if(!file_exists('backend/database.php')){
        header('location: locate');
        die();
    }

    if(!session_id()) { session_start(); }
    if(isset($_SESSION['admin_name'])){
        header("location: dashboard.php");
    }

    $db = new Database();
    $db->select('settings', '*', null, null, null, null);
    $result = $db->getResult();
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $result[0]['gym_name']; ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div id="admin-content" class="mt-5">
        <div class="message"></div>
        <div class="container">
            <div class="row">
                <div class="offset-md-4 col-md-4">
                    <div class="login-form">
                        <?php if(count($result) and $result[0]['gym_logo'] != ''){ ?>
                            <img src="images/gym-logo/<?php echo $result[0]['gym_logo']; ?>" alt="" class="d-block mx-auto mb-2" width="70px">
                        <?php } ?>
                        <div class="card">
                            <div class="card-header bg-info p-2">
                                <h2 class="text-white m-2 text-center"><?php echo $result[0]['gym_name']; ?></h2>
                            </div>
                            <div class="card-body login-form position-relative">
                                <form action="" method="POST" id="admin_Login">
                                    <div class="form-group">
                                        <label for="">Username</label>
                                        <input type="text" class="form-control username" id="username" name="username" placeholder="username" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input type="password" class="form-control password" id="password" name="password" placeholder="password" required>
                                    </div>
                                    <input type="submit" class="btn btn-info float-right" name="login" value="login">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.js" charset="utf-8"></script>
    <script src="assets/js/admin.js" charset="utf-8"></script>
</body>
</html>