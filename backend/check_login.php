<?php

    include 'config.php';

    if(isset($_POST['login'])){
        if(!isset($_POST['name']) || $_POST['name'] == ''){
            echo json_encode(array("error" => "username can't be empty")); exit;
        }
        else if(!isset($_POST['password']) || $_POST['password'] == ''){
            echo json_encode(array("error" => "password can't be empty")); exit;
        }
        else{
            $db = new Database();
            $username = $db->escapeString($_POST['name']);
            $password = md5($_POST['password']);

            $db->select('admin', 'admin_name', null, "admin_username = '$username' and password = '$password'", null, 0);
            $res = $db->getResult();
            if(count($res)){
                session_start();

                $_SESSION['admin_name'] = $res[0]['admin_name'];
                echo json_encode(array('success'=>true)); exit;
            }else{
                echo json_encode(array('error'=>false)); exit;
            }
        }
    }
    if(isset($_POST['logout'])){
        session_start();
        session_unset();
        session_destroy();
        echo '1';
        exit;
    }
?>
