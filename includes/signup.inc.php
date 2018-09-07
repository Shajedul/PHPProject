<?php
if (isset($_POST['submit'])) {
    include_once('dbh.inc.php');
    $first = mysqli_real_escape_string($con, $_POST['first']);
    $last = mysqli_real_escape_string($con, $_POST['last']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $uid = mysqli_real_escape_string($con, $_POST['uid']);
    $pwd = mysqli_real_escape_string($con, $_POST['pwd']);
    //Error Handlers
    if (empty($first) || empty($last) || empty($email) || empty($uid) || empty($pwd)) {
        header("Location: ../signup.php?signup=empty");
        exit();
    } else {
        if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) {
            header("Location: ../signup.php?signup=Invalid");
            exit();
        } else {
            if (filter_var(!$email, FILTER_VALIDATE_EMAIL)) {
                header("Location: ../signup.php?signup=InvalidEmail");
                exit();
            } else {
                $sql = "select *from users where uid = '$uid'";
                $result = mysqli_query($con, $sql);
                $resultCheck = mysqli_num_rows($result);

                if ($resultCheck > 0) {
                    header("Location: ../signup.php?signup=UsernameExists");
                    exit();
                } else {
                    //HashPassword
                    $hasheddpwd = password_hash($pwd, PASSWORD_DEFAULT);
                    $sql = "Insert into users( user_first , user_last , user_email , user_uid , user_pwd) values('$first' , '$last' , '$email' , '$uid' , '$hasheddpwd')";
                    mysqli_query($con, $sql);
                    header("Location: ../signup.php?signup=Success");
                    exit();

                }
            }
        }

    }
} else {
    header("Location: ../signup.php");
    exit();

}