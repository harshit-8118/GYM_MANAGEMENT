<?php
ob_start();
if(file_exists('../backend/database.php')){
    include '../backend/config.php';
    header('location: index.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gym-management</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
    <style>
        body{
            padding: 120px 0 0;
        }
        h1{
            background-color: #e7e7e7;
            font-size: 30px;
            font-weight: 600;
            padding: 15px;
            margin: 0;
        }
        .tab{
            border: 1px dotted #e7e7e7;
        }
        .tab .tab-content{
            color: #333;
			background: linear-gradient(to bottom right, #f5f5f5 50%, transparent 50%);
            font-size: 14px;
            letter-spacing: 1px;
            text-align: center;
			line-height: 25px;
            padding: 20px;
            position: relative;
        }
        .tab .tab-content h3{
            color: #777;
            font-size: 22px;
            font-weight: 600;
            text-transform: capitalize;
            text-align: center;
            letter-spacing: 1px;
            margin: 0 0 12px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="offset-3 col-6">
                    <h1 class="text-center">Fitness Camp</h1>
                    <div class="tab" role="tabpanel">
                        <form class="tab-content tabs" action="<?php  echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <div role="tabpanel"  class="tab-pane active" id="section1">
                                <h3>welcome to fitness mela</h3>
                                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Magni atque voluptatem consectetur recusandae accusantium dolorem doloribus tempore nemo ullam numquam?</p>
                                <ul class="nav justify-content-center">
                                    <li class="nav-item">
                                        <a href="#section2" class="nav-link btn btn-success mx-2" data-toggle="tab" role="tab">Next</a>
                                    </li>
                                </ul>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="section2">
								<h3>Database Settings</h3>
								<div class="form-group">
									<input type="text" class="form-control" name="host" placeholder="Host Name" required>
								</div>
								<div class="form-group">
									<input type="text" class="form-control" name="dbname" placeholder="Database Name" required>
								</div>
								<div class="form-group"> 
									<input type="text" class="form-control" name="dbuser" placeholder="Database Username" required>
								</div>
								<div class="form-group">
									<input type="text" class="form-control" name="dbpwd" placeholder="Database Password">
								</div>
								<ul class="nav justify-content-center">
									<li class="nav-item">
										<a href="#section1" class="nav-link btn btn-success mx-2" data-toggle="tab" role="tab" >Previous</a>
									</li>
									<li class="nav-item">
										<a href="#section3" class="nav-link btn btn-success mx-2" data-toggle="tab" role="tab" >Next</a>
									</li>
								</ul>
							</div>
                            <div role="tabpanel" class="tab-pane" id="section3">
                                <h3>Admin login credentials</h3>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="username" placeholder="user name" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" placeholder="password" required>
                                </div>
                                <ul class="nav justify-content-center">
                                    <li class="nav-item">
                                        <a href="#section2" class="nav-link btn btn-success mx-2" data-toggle="tab" role="tab">Prev</a>
                                    </li>
                                    <li class="nav-item">
                                        <input type="submit" name="install" class="nav-link btn btn-success mx-2" value="Install"/>
                                    </li>
                                </ul>
                            </div>
                        </form>
                        <?php
                            if(isset($_POST['install'])){
                                // print_r($_POST);
                                // exit();
                                if(!isset($_POST['host']) || $_POST['host'] == ""){
                                    echo '<div class="alert alert-danger">host required</div>';
                                }
                                else if(!isset($_POST['dbname']) || $_POST['dbname'] == ""){
                                    echo '<div class="alert alert-danger">dbname required</div>';
                                }
                                else if(!isset($_POST['dbuser']) || $_POST['dbuser'] == ""){
                                    echo '<div class="alert alert-danger">dbuser required</div>';
                                }
                                else if(!isset($_POST['username']) || $_POST['username'] == ""){
                                    echo '<div class="alert alert-danger">username required</div>';
                                }
                                else if(!isset($_POST['password']) || $_POST['password'] == ""){
                                    echo '<div class="alert alert-danger">password required</div>';
                                }else{
                                    $host = trim($_POST['host']);
                                    $dbname = trim($_POST['dbname']);
                                    $dbuser = trim($_POST['dbuser']);
                                    $dbpwd = trim($_POST['dbpwd']);
                                    $username = trim($_POST['username']);
                                    $password = md5(trim($_POST['password']));
                                    
                                    $conn = @mysqli_connect($host, $dbuser, $dbpwd, $dbname);
                                    if(mysqli_connect_error()){
                                        $warning = mysqli_connect_error();
                                        echo '<div class="alert alert-danger">'.$warning.'</div>';
                                    }
                                    else{
                                        copy("install.inc.php", "../backend/database.php");
                                        $content = "../backend/database.php";
                                        // echo $content;
                                        // exit();
                                        file_put_contents($content, str_replace('hostname', $host, file_get_contents($content)));
                                        file_put_contents($content, str_replace('dbuser', $dbuser, file_get_contents($content)));
                                        file_put_contents($content, str_replace('dbpass', $dbpwd, file_get_contents($content)));
                                        file_put_contents($content, str_replace('dbname', $dbname, file_get_contents($content)));

                                        $filename = 'install.sql';

                                        $templine = '';
                                        $lines = file($filename);

                                        foreach($lines as $line){
                                            if(substr($line, 0, 2) == '--' || $line == '')
                                                continue;
                                            $templine .= $line;
                                            if(substr(trim($line), -1, 1) == ';'){
                                                $conn->query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . $conn->error() . '<br /><br />');
                                                $templine = '';
                                            }
                                        }

                                        include '../backend/config.php';
                                        $db = new Database();
                                        $db->update('admin', array("admin_username"=>$username, "admin_password"=>$password), "admin_id=1");
                                        $res = $db->getResult;
                                        header('location: ../index.php');
                                    }
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script>
        $('.nav-link').click(()=>{
            $('.nav-link').removeClass('active');
        })
    </script>
</body>

</html>