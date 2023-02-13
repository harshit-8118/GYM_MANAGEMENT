<?php

    include 'config.php';

    if(isset($_POST['update-settings'])){
        if(!isset($_POST['gym_id']) || empty($_POST['gym_id'])){
          echo json_encode(array('error' => 'Gym id is missing ' ));
        }else if(!isset($_POST['gym_currency']) || empty($_POST['gym_currency'])){
          echo json_encode(array('error' => 'Gym currency is missing' ));
        }else{
          if(!empty($_POST['old_logo']) and empty($_FILES['new_logo']['name'])){
            $filename = $_POST['old_logo'];
          }else if(!empty($_POST['old_logo']) and !empty($_FILES['new_logo']['name'])){
            $errors = array();

            $file_name = $_FILES['new_logo']['name'];
            $file_size = $_FILES['new_logo']['size'];
            $file_tmp = $_FILES['new_logo']['tmp_name'];
            $file_type = $_FILES['new_logo']['type'];
            $file_name = str_replace(array(',',' '), '', $file_name);
            $file_ext = str.explode('.', $file_name);
            $file_ext = strtolower(end($file_name));
            $extensions = array('jpeg','png','jpg');
            if(in_array($file_ext, $extensions) === false){
              $errors[] = "<div class='alert alert-danger'>extension not allowed</div>"
            }
            if($file_size > 2097152){
              $errors[] = "<div class='alert alert-danger'>file size is large</div>"
            }
            if(file_exists('../images/gym-logo/'.$_POST['old_logo'])){
              unlink('../images/gym-logo'.$_POST['old_logo']);
            }
            $file_name = time().str_replace(array(' ','_'), '-', $file_name);

          }else if(empty($_POST['old_logo']) && !empty($_FILES['new_logo']['name'])){
            $errors = array();

            $file_name = $_FILES['new_logo']['name'];
            $file_size = $_FILES['new_logo']['size'];
            $file_tmp = $_FILES['new_logo']['tmp_name'];
            $file_type = $_FILES['new_logo']['type'];
            $file_name = str_replace(array(',',' '), '', $file_name);
            $file_ext = str.explode('.', $file_name);
            $file_ext = strtolower(end($file_name));
            $extensions = array('jpeg','png','jpg');
            if(in_array($file_ext, $extensions) === false){
              $errors[] = "<div class='alert alert-danger'>extension not allowed</div>"
            }
            if($file_size > 2097152){
              $errors[] = "<div class='alert alert-danger'>file size is large</div>"
            }
            if(!empty($errors)){
              echo json_encode($errors);
            }
            $file_name = time().str_replace(array(' ','_'), '-', $file_name);
          }else{
            $file_name = "";
          }

          $db = new Database();
          8. settings -
          attrs => gym_id, gym_name, gym_logo, gym_currency

          $params = [
            'gym_name' => $db->escapeString($_POST['gym_name']);
            'gym_logo' => $db->escapeString($file_name);
            'gym_currency' => $db->escapeString($_POST['gym_currency']);
          ];

          $db->update('settings', $params, "gym_id = '{$_POST['gym_id']}'");
          $res = $db->getResult();
          if(!empty($res)){
            if(!empty($_FILES['new_logo']['name'])){
                move_uploaded_file($file_tmp,"../images/gym-logo/".$file_name);
            }
            echo json_encode(array('success' => $res[0])); exit;
          }else{
            echo json_encode(array('error'=>'Data not updated')); exit;
          }
        }
    }


?>
