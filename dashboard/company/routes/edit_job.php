<?php

session_start();
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../session.php';

header("Content-Type: application/json");

if($_SERVER['REQUEST_METHOD'] === 'POST'){


    $id = mysqli_value($con,"id");
    $position_name = mysqli_value($con,"position_name");
    $position_age = mysqli_value($con,"position_age");
    $minimum_salary = mysqli_value($con,"minimum_salary");
    $maximum_salary = mysqli_value($con,"maximum_salary");
    $currency_symbol = mysqli_value($con,"currency_symbol");
    $description = mysqli_value($con,"description");
    $status = mysqli_value($con,"status_atvie");
    $time_type = mysqli_value($con,"time_type");

    function message($status,$message){
        $msg = array(
            "success" => $status,
            "message" => $message
        );
        echo arraytojson($msg);
        die();
    }

    if($position_name == ""){
        message(false, "Please enter the position name.");
    }
    if($position_age == ""){
        message(false, "Please enter the qualification age.");
    }elseif($position_age < 18){
        message(false, "The qualification age must be 18 years old and above.");
    }
    if($minimum_salary == ""){
        message(false, "Please enter the minimum salary.");
    }
    if($maximum_salary == ""){
        message(false, "Please enter the maximum salary.");
    }
    if($currency_symbol == ""){
        message(false, "Please select currency symbol.");
    }
    if($description == ""){
        message(false, "Please enter the job description.");
    }


    if($status == ""){
        message(false, "Please enter the Status.");
    }


    $update_job = mysqli_query($con,"
    UPDATE
        `tbl_jobs`
    SET
        `j_name` = '$position_name',
        `j_age` = $position_age,
        `j_min` = $minimum_salary,
        `j_max` = $maximum_salary,
        `j_currency_symbol` = '$currency_symbol',
        `j_description` = '$description',
        `status_type` = $status,
        `time_type` = '$time_type'
    WHERE
        `id` = $id
    ");


    if($update_job){
        message(true,"Successfully saved.");
    }else{
        message(false,"Failed to update the selected job.");
    }
}