<?php
include("../auto/sql_util.php");

$response = array(
    "status" => "error",
    "message" => "An error occurred while processing the request",
    "callback" => ""
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['operation'])) {
        $operation = $_POST['operation'];

        if ($operation === "add") {
            $c_name = $_POST['c_name'];
            if (!empty($c_name)) {
                $sql = "SELECT * FROM classroom WHERE c_name = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $c_name);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $response["status"] = "warning";
                    $response["message"] = "Classroom $c_name already exists";
                    $response["callback"] = "document.querySelector('input[name=\"c_name\"]').focus();";
                } else {
                    $sql = "INSERT INTO classroom (c_name) VALUES (?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $c_name);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        $response["status"] = "success";
                        $response["message"] = "Classroom added";
                        $response["callback"] = "window.location.href = '../'";
                    }
                }
            } else {
                $response["status"] = "warning";
                $response["message"] = "Classroom name is empty";
                $response["callback"] = "document.querySelector('input[name=\"c_name\"]').focus();";
            }
        } elseif (in_array($operation, array("instructor", "leader"))) {
            $c_id = $_POST['c_id'];
            $id_to_update = ($operation === "instructor") ? "i_id" : "s_id";
            $value = (empty($_POST[$id_to_update])) ? NULL : $_POST[$id_to_update];
        
            $sql = "UPDATE classroom SET $id_to_update = ? WHERE c_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $value, $c_id);
            
            $target_to_update = ($operation === "instructor") ? "instructor" : "leader";
        
            try {
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    $response["status"] = "success";
                    $response["message"] = "Class $target_to_update updated";
                    $response["callback"] = "window.location.href = '../'";
                } else {
                    $response["status"] = "warning";
                    $response["message"] = "No changes were made to classroom $target_to_update";
                    $response["callback"] = "window.location.href = '../'";
                }
            } catch (Exception $e) {
                $response["status"] = "error";
                $response["message"] = "Failed to update classroom $target_to_update";
            }        
        } elseif ($operation === "delete") {
            $c_id = $_POST['c_id'];
            $sql = "DELETE FROM classroom WHERE c_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $c_id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response["status"] = "success";
                $response["message"] = "Classroom deleted";
                $response["callback"] = "window.location.href = '../'";
            } else {
                $response["status"] = "warning";
                $response["message"] = "Classroom does not exist";
                $response["callback"] = "window.location.href = '../'";
            }
        } else {
            $response["status"] = "error";
            $response["message"] = "Invalid operation";
        }
    } else {
        $response["status"] = "error";
        $response["message"] = "No operation provided";
    }
} else {
    $response["status"] = "error";
    $response["message"] = "No POST request";
}

echo json_encode($response);
mysqli_close($conn);
?>
