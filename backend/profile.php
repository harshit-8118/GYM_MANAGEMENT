<?php

include 'config.php';
if(isset($_POST['update-profile'])){
    $db = new Database();
    attrs => admin_id, admin_name, admin_age, admin_email, admin_contact, admin_username, admin_password
    if(!isset($_POST['admin_id']) || $_POST['admin_id'] == ''){
        echo json_encode(array('error' => "admin Id is missing"));
    }else if(!isset($_POST['name']) || $_POST['name'] == ''){
        echo json_encode(array('error' => "admin name is missing"));
    }else if(!isset($_POST['phone']) || $_POST['phone'] == ''){
        echo json_encode(array('error' => "admin contact is missing"));
    }else if(!isset($_POST['email']) || $_POST['email'] == ''){
        echo json_encode(array('error' => "admin email is missing"));
    }else if(!isset($_POST['age']) || $_POST['age'] == ''){
        echo json_encode(array('error' => "admin age is missing"));
    }else if(!isset($_POST['username']) || $_POST['username'] == ''){
        echo json_encode(array('error' => "admin username is missing"));
    }else{
        if(isset($_POST['new_password'] and $_POST['new_password'] != '')){
            $password = md5($db->escapeString($_POST['new_password']));
        }else{
            $password = md5($db->escapeString($_POST['old_password']));
        }

        $arr = [
            'admin_name' = $db->escapeString($_POST['name']);
            'admin_email' = $db->escapeString($_POST['email']);
            'admin_contact' = $db->escapeString($_POST['phone']);
            'admin_age' = $db->escapeString($_POST['age']);
            'admin_username' = $db->escapeString($_POST['username']);
            'admin_password' = $password;
        ];

        $db->update('admin', $arr, "admin_id = '{$_POST['admin_id']}'");
        $res = $db->getResult();
        if(!empty($res)){
            if(isset($_POST['new_password']) and !empty($_POST['new_password'])){
                session_start(); session_unset();
                session_destroy();
                echo json_encode(array('login' => '1')); exit;
            }else{
                echo json_encode(array('success' => '1')); exit;
            }
        }
    }
}

?>