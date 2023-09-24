<?php
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

if ($operation === "add" || $operation === "edit") {
    $s_name = $_POST['s_name'];
    $s_address = $_POST['s_address'];
    $s_tel = $_POST['s_tel'];
    $p_id = $_POST['p_id'];
    $c_id = $_POST['c_id'];
    $new_file_name = '';

    if (empty($s_name)) {
        $response["status"] = "warning";
        $response["message"] = "Student name is required";
        $response["callback"] = "document.querySelector('input[name=\"s_name\"]').focus();";
        echo json_encode($response);
        exit;
    }

    
    if (!empty($_FILES['s_pic']['name'])) {
        $file_name = $_FILES['s_pic']['name'];
        $file_tmp = $_FILES['s_pic']['tmp_name'];
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = $s_name . "_" . time() . "." . $file_extension;
        $file_destination = "../../res/upload/student/" . $new_file_name;

        if (!move_uploaded_file($file_tmp, $file_destination)) {
            $response["status"] = "error";
            $response["message"] = "Failed to upload student picture";
            echo json_encode($response);
            exit;
        }
    }

    if ($operation === "add") {
        $sql = "INSERT INTO student (s_name, s_address, s_tel, s_pic, p_id, c_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $s_name, $s_address, $s_tel, $new_file_name, $p_id, $c_id);
    } elseif ($operation === "edit") {
        $s_id = $_POST['s_id'];
    
        if (empty($s_id)) {
            $response["status"] = "warning";
            $response["message"] = "Student ID is empty";
            $response["callback"] = "window.location.href = '../'";
            echo json_encode($response);
            exit;
        }
    
        $sql = "UPDATE student SET s_name = ?, s_address = ?, s_tel = ?, s_pic = ?, p_id = ?, c_id = ? WHERE s_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiii", $s_name, $s_address, $s_tel, $new_file_name, $p_id, $c_id, $s_id);
    }
    
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response["status"] = "success";
        $response["message"] = "Student " . ($operation === "add" ? "added" : "updated");
        $response["callback"] = "window.location.href = '../'";
    } else {
        $response["status"] = "warning";
        $response["message"] = "No changes were made to student information";
    }
} elseif ($operation === "delete") {
    $s_id = $_POST['s_id'];

    if (!empty($s_id)) {
        $sql = "DELETE FROM student WHERE s_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $s_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response["status"] = "success";
            $response["message"] = "Student deleted";
            $response["callback"] = "window.location.href = '../'";
        } else {
            $response["status"] = "warning";
            $response["message"] = "Student does not exist";
            $response["callback"] = "window.location.href = '../'";
        }
    } else {
        $response["status"] = "warning";
        $response["message"] = "Student ID is empty";
        $response["callback"] = "window.location.href = '../'";
    }
} else {
    $response["message"] = "Invalid operation";
}

echo json_encode($response);
?>
