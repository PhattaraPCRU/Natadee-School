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

if ($operation === "add") {
    $i_id = $_POST['i_id'];
    $a_id = $_POST['a_id'];

    if (empty($i_id) || empty($a_id)) {
        $response["status"] = "warning";
        $response["message"] = ($i_id === "") ? "Instructor ID is empty" : "Award ID is empty";
        $response["callback"] = "document.querySelector('input[name=\"".($i_id === "" ? "i_id" : "a_id")."\"]').focus()";
        echo json_encode($response);
        exit;
    }

    $stmt = $conn->prepare("SELECT a_id FROM instructor_award WHERE a_id = ?");
    $stmt->bind_param("i", $a_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows != 0) {
        $response["status"] = "warning";
        $response["message"] = "Award already claimed by another instructor";
        $response["callback"] = "window.location.href = '../'";
        echo json_encode($response);
        exit;
    } else {
        $sql = "INSERT INTO instructor_award (i_id, a_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $i_id, $a_id);
        $stmt->execute();
    }

    if ($stmt->affected_rows > 0) {
        $response["status"] = "success";
        $response["message"] = "Award added";
        $response["callback"] = "window.location.href = '../'";
    } else {
        $response["status"] = "warning";
        $response["message"] = "No changes were made to award";
    }
} elseif ($operation === "delete") {
    $a_id = $_POST['a_id'];
    $i_id = $_POST['i_id'];

    if (!empty($a_id)) {
        $sql = "DELETE FROM instructor_award WHERE a_id = ? AND i_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $a_id, $i_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response["status"] = "success";
            $response["message"] = "Award deleted";
            $response["callback"] = "window.location.href = '../'";
        } else {
            $response["status"] = "warning";
            $response["message"] = "Award does not exist or might be deleted";
            $response["callback"] = "window.location.href = '../'";
        }
    } else {
        $response["status"] = "warning";
        $response["message"] = "Award ID is empty";
        $response["callback"] = "window.location.href = '../'";
    }
} else {
    $response["message"] = "Invalid operation";
}

echo json_encode($response);
?>
