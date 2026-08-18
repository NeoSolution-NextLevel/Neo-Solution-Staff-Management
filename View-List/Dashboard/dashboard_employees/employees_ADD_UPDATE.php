<?php

require_once "data/data_ADD_UPDATE.php";
require_once "database.php";
require_once "data/data_SINGLE_DATA.php";

$json = array();

if($_SERVER["REQUEST_METHOD"] === "POST"){
    
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
    $email_address = isset($_POST['email_address']) ? $_POST['email_address'] : '';
    $department = isset($_POST['department']) ? $_POST['department'] : '';
    $job_roles = isset($_POST['job_roles']) ? $_POST['job_roles'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $joined_date = isset($_POST['joined_date']) ? $_POST['joined_date'] : '';


    $obj = new data_ADD_UPDATE();

    //Delete data
    if(isset($_POST['id'])){
        $obj->set_id($_POST['id']);

        if(isset($_POST['del']) && $_POST['del'] == '1'){
            $obj->remove();
            if($obj->process_update()){
                $state['error'] = "0";
                $state['id'] = $_POST['id'];
            }
            else{
                $state['error'] = $obj->get_error();
            }

            $json[] = $state;//
            echo json_encode($json);
            exit;
        }
    }  
    $obj->get_data( $fullname, $email_address, $department, $job_role, $status, $joined_date);

    //Update data
    if(isset($_POST['id'])){
        $get_id = $_POST['id'];
        $obj->set_id($get_id);
        if($obj->process_update()){
            $state['error'] = "0";
            $state['id'] = $get_id;
        }
        else{
            $state['error'] = $obj->get_error();
        }
    }
    else{
        //New Record
        if($obj->process_new_record()){
            $state['error'] = "0";
            $state['id'] = $obj->get_id();
        }
        else{
            $state['error'] = $obj->get_error();
        }
    }
    $json[] = $state;
}
else{
    $json[] = $state;
}

echo json_encode($json);

?>