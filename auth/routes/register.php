<?php
require_once '../../config.php';
require_once '../../functions.php';

header("Content-Type: application/json");

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = $_POST;
    $account_type  = $data["account_type"];
    $fname = $data["fname"];
    $lname = $data["lname"];
    $cnum = $data["cnum"];
    $bday = date("Y-m-d",strtotime($data["bday"]));
    $age = $data["age"];
    $address = $data["address"];
    $email = $data["email"];
    $password = $data["password"];
    $department = $data["department"];
    $facebook = $data["facebook"];
    $linkedin = $data["linkedin"];
    $instagram = $data["instagram"];
    $degree_title = $data["degree_title"];
    $school_name = $data["school_name"];
    $school_address = $data["school_address"];
    $school_year_attended = $data["school_year_attended"];
    $achievement = $data["achievement"];

    function message($status,$message){
        $msg = array(
            "success" => $status,
            "message" => $message
        );
        echo arraytojson($msg);
        die();
    }

    if($fname == ""){
        message(false,"Please enter your first name.");
    }
    if($lname == ""){
        message(false,"Please enter your last name.");
    }
    if($cnum == ""){
        message(false,"Please enter your contact number.");
    }elseif(strlen($cnum) < 11){
        message(false,"Contact no. must contains 11 digits.");
    }
    if($bday == "" || $bday == "1970-01-01"){
        message(false,"Please enter your birth day.");
    }
    if($age == ""){
        message(false,"Please enter your age.");
    }
    if($address == ""){
        message(false,"Please enter your address.");
    }
    if($email == ""){
        message(false,"Please enter your email.");
    }
    if($password == ""){
        message(false,"Please enter your password.");
    }elseif(strlen($password) < 6){
        message(false,"Password must be 6 characters or more.");
    }
    if($department == ""){
        message(false,"Please select department.");
    }

    $allowed = array('jpeg', 'png', 'jpg');
    $filename = $_FILES['valid_photo']['name'][0];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if (!in_array($ext, $allowed)) {
        message(false,"Image must be jpeg, png, jpg.");
    }
    // echo '<pre>';
    // print_r($_POST);
    // print_r($_FILES);
    // echo '</pre>';

    //check if email is already registered
    $check_email = mysqli_query($con,"SELECT * FROM `tbl_accounts` WHERE `email` = '$email'");
    if($check_email) {
        if(hasResult($check_email)){
            message(false,"The email is already in use, Please try another.");
        }
    }else{
        message(false,"There was a problem with your email address.");
    }

    $fileTmpPath = $_FILES['valid_photo']['tmp_name'][0];
    $fileName = $_FILES['valid_photo']['name'][0];
    $fileSize = $_FILES['valid_photo']['size'][0];
    $fileType = $_FILES['valid_photo']['type'][0];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

    // directory in which the uploaded file will be moved
    $uploadFileDir = '../../assets/images/';
    $dest_path = $uploadFileDir . $newFileName;
    
    if(move_uploaded_file($fileTmpPath, $dest_path)) {
        //register_account
        $register_account = mysqli_query($con,"
        INSERT INTO `tbl_accounts`(
            `firstname`,
            `lastname`,
            `cnum`,
            `bday`,
            `age`,
            `address`,
            `email`,
            `password`,
            `type`,
            `department`,
           `facebook`,
           `linkedin`,
           `instagram`,
           `degree_title`,
           `school_name`,
           `school_address`,
           `school_year_attended`,
           `achievement`,
           `prof_id_image`,
           `status_id`,
           `verification_state`
        )
        VALUES(
                '$fname',
                '$lname',
                '$cnum',
                '$bday',
                $age,
                '$address',
                '$email',
                '$password',
                $account_type,
                '$department',
                '$facebook',
                '$linkedin',
                '$instagram',
                '$degree_title',
                '$school_name',
                '$school_address',
                '$school_year_attended',
                '$achievement',
                '$dest_path',
                1,
                2
            )
        ");

        if($register_account){
            message(true,"Your account has been registered!");
        }else{
            message(false,"Failed to register your account");
        }
    } else {
        message(false,"Failed to register your account");
    }
    
    
}
?>