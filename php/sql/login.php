<?php
ob_start();
include('../php/utility_loader.php');

$login = $_POST['login'];
$passwd = $_POST['passwd'];
$user_status = $_POST['user_status'];
if (!empty($login) && !empty($passwd)) {
    if ($user_status == '1') {
        $sql = "SELECT * FROM instructor WHERE (i_username='$login' AND i_password='$passwd')";
        $result = mysqli_query($conn, $sql);
        $total = mysqli_num_rows($result);
        if ($total > 0) {
            session_start();
            $_SESSION["valid_uname"] = $login;
            $_SESSION["valid_pwd"] = $passwd;
            $_SESSION["valid_instructor"] = $user_status;
            mysqli_close($conn);
            echo "<script> alert('Welcome User'); window.location='frm_editme.php';</script> ";
            exit();
        } else {
            echo "<script> alert('User not found'); window.history.go(-1);</script> ";
            exit();
        }
    } else {
        // Admin section
        if ($login == "Admin" && $passwd == "Admin") {
            session_start();
            $_SESSION["valid_uname"] = $login;
            $_SESSION["valid_pwd"] = $passwd;
            $_SESSION["valid_admin"] = $user_status;
            mysqli_close($conn);
            echo "<script> alert('Welcome Admin'); window.location='showdept.php';</script> ";
            exit();
        } else {
            echo "<script> alert('Admin not found'); window.history.go(-1);</script> ";
            exit();
        }
    }
} else {
    echo "<script> alert('Sorry...!! Please fill in all the information'); window.history.go(-1);</script> ";
    exit();
}
?>