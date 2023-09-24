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
    $p_name = $_POST['p_name'];
    $p_job = $_POST['p_job'];
    $p_tel = $_POST['p_tel'];
    $p_id = $_POST['p_id'];

    if (empty($p_id) || empty($p_name)) {
        $response["status"] = "warning";
        $response["message"] = "Parent ID and Parent Name are required";
        $response["callback"] = "document.querySelector('input[name=\"p_id\"]').focus();";
        echo json_encode($response);
        exit;
    } elseif (!preg_match('/^\d{13}$/', $p_id)) {
        $response["status"] = "warning";
        $response["message"] = "Parent ID must be exactly 13 digits long and contain only numbers.";
        $response["callback"] = "document.querySelector('input[name=\"p_id\"]').focus();";
        echo json_encode($response);
        exit;
    } else if (!preg_match('/^\d{10}$/', $p_tel)) {
        $response["status"] = "warning";
        $response["message"] = "Parent Telephone must be exactly 10 digits long and contain only numbers.";
        $response["callback"] = "document.querySelector('input[name=\"p_tel\"]').focus();";
        echo json_encode($response);
        exit;
    }
    
    // If the code reaches this point, both $p_id, $p_name, and $p_tel (if provided) are valid.
    // You can continue processing.
    

    if ($operation === "add") {
        // Check if the parent ID already exists in the table
        $check_sql = "SELECT COUNT(*) FROM parent WHERE p_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $p_id);
        $check_stmt->execute();
        $check_stmt->bind_result($count);
        $check_stmt->fetch();
        $check_stmt->close();

        if ($count > 0) {
            $response["status"] = "warning";
            $response["message"] = "Parent ID already exists";
            echo json_encode($response);
            exit;
        }

        $sql = "INSERT INTO parent (p_id, p_name, p_job, p_tel) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $p_id, $p_name, $p_job, $p_tel);
    } elseif ($operation === "edit") {
        $sql = "UPDATE parent SET p_name = ?, p_job = ?, p_tel = ? WHERE p_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $p_name, $p_job, $p_tel, $p_id);
    }

    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response["status"] = "success";
        $response["message"] = "Parent " . ($operation === "add" ? "added" : "updated");
        $response["callback"] = "window.location.href = '../'";
    } else {
        $response["status"] = "warning";
        $response["message"] = "No changes were made to parent information";
    }
} elseif ($operation === "delete") {
    $p_id = $_POST['p_id'];

    if (!empty($p_id)) {
        $sql = "DELETE FROM parent WHERE p_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $p_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response["status"] = "success";
            $response["message"] = "Parent deleted";
        } else {
            $response["status"] = "warning";
            $response["message"] = "Parent does not exist";
        }
    } else {
        $response["status"] = "warning";
        $response["message"] = "Parent ID is empty";
    }
} else {
    $response["message"] = "Invalid operation";
}

echo json_encode($response);
?>
