<?php 

session_start();
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../session.php';

header("Content-Type: application/json");


function message($status,$message){
    $msg = array(
        "success" => $status,
        "message" => $message
    );
    echo arraytojson($msg);
    die();
}
if($islogin){
    $id = mysqli_value($con,"id");
    $action = mysqli_value($con,"action");

    $update_status = mysqli_query($con,"UPDATE `tbl_applicants` SET `status` = $action WHERE `tbl_applicants`.`id` = $id");
    if($update_status){
        message(true,"Successfully updated.");
    }else{
        message(false,"Failed to update the status, Please try again.");
    }
}else{
    message(false,"Auth error");
}
?>