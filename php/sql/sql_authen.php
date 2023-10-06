<?php
session_start();
include("../auto/sql_util.php");

$response = array(
    "status" => "error",
    "message" => "An error occurred while processing the request",
    "callback" => ""
);

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST['operation'])) {
    $response["message"] = "Invalid request";
    echo json_encode($response);
    exit;
}

$operation = $_POST['operation'];

if ($operation === "login") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userrole = $_POST['userrole'];

    if (empty($username) || empty($password) || empty($userrole)) {
        $response["status"] = "warning";
        $response["message"] = (empty($username)) ? "Please enter username" : "Please enter password";
        $response["callback"] = (empty($username)) ? "document.getElementById('username').focus();" : "document.getElementById('password').focus();";
        echo json_encode($response);
        exit;
    }

    if ($userrole === "admin") {
        $sql = "SELECT admin_username, admin_password FROM administrator WHERE admin_username = ?";
    } elseif ($userrole === "instructor") {
        $sql = "SELECT i_username, i_password FROM instructor WHERE i_username = ?";
    } else {
        $response["status"] = "warning";
        $response["message"] = "Invalid user role";
        $response["callback"] = "location.reload();";

        echo json_encode($response);
        exit;
    }
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($userrole === "admin" && $password === $row['admin_password']) {
            $response["status"] = "success";
            $response["message"] = "Login successful";
            $response["callback"] = "window.location.href = '../department/'";
            $_SESSION['userrole'] = $userrole;
            $_SESSION['username'] = $username;
        } else if ($userrole === "instructor" && $password === $row['i_password']) {
            $response["status"] = "success";
            $response["message"] = "Login successful";
            $response["callback"] = "window.location.href = '../user/edit/'";
            $_SESSION['userrole'] = $userrole;
            $_SESSION['username'] = $username;
        } else {
            $response["status"] = "warning";
            $response["message"] = "Invalid password";
            $response["callback"] = "document.getElementById('password').value = ''; document.getElementById('password').focus();";
        }
    } else {
        $response["status"] = "warning";
        $response["message"] = "Invalid username";
        $response["callback"] = "document.getElementById('username').value = ''; document.getElementById('password').value = ''; document.getElementById('username').focus();";
    }

    $stmt->close();
    $conn->close();
} else if ($operation === "logout") {
    session_unset();
    session_destroy();
    $response["status"] = "success";
    $response["message"] = "Logout successful";
    $response["callback"] = "window.location.href = '/login/'";
} else {
    $response["message"] = "Invalid operation";
}

echo json_encode($response);
?>
