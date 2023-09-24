<?php
include("../auto/sql_util.php");

$response = array(
    "status" => "error",
    "message" => "An error occurred while processing the request",
    "callback" => ""
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["operation"])) {
        $operation = $_POST["operation"];

        if ($operation == "add") {
            $a_name = $_POST["a_name"];
            $a_org = $_POST["a_org"];
            $a_year = $_POST["a_year"];

            if (!empty($a_name) && !empty($a_org) && !empty($a_year) && strlen($a_year) === 4) {
                $sql = "INSERT INTO award (a_name, a_org, a_year) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $a_name, $a_org, $a_year);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $response["status"] = "success";
                    $response["message"] = "Add award successfully";
                    $response["callback"] = "window.location.href = '../'";
                } else {
                    $response["message"] = "Error: add award failed";
                }
            } else {
                $response["status"] = "warning";
                if (empty($a_name) || empty($a_org) || empty($a_year)) {
                    $response["message"] = "Please fill in all fields";
                } else if (strlen($a_year) !== 4) {
                    $response["message"] = "Year must have exactly 4 characters";
                }
            }
        } else if ($operation == "update") {
            $a_id = $_POST["a_id"];
            $a_name = $_POST["a_name"];
            $a_org = $_POST["a_org"];
            $a_year = $_POST["a_year"];

            if (!empty($a_name) && !empty($a_org) && !empty($a_year) && strlen($a_year) === 4) {
                $sql = "SELECT a_name, a_org, a_year FROM award WHERE a_id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $a_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if ($row["a_name"] == $a_name && $row["a_org"] == $a_org && $row["a_year"] == $a_year) {
                        $response["status"] = "warning";
                        $response["message"] = "No changes to update";
                        $response["callback"] = "window.location.href = '../'";
                    } else {
                        $sql = "UPDATE award SET a_name=?, a_org=?, a_year=? WHERE a_id=?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("sssi", $a_name, $a_org, $a_year, $a_id);
                        $stmt->execute();

                        if ($stmt->affected_rows > 0) {
                            $response["status"] = "success";
                            $response["message"] = "Update award successfully";
                            $response["callback"] = "window.location.href = '../'";
                        } else {
                            $response["message"] = "Error: update award failed";
                        }
                    }
                } else {
                    $response["message"] = "Error: award not found";
                }
            } else {
                $response["status"] = "warning";
                if (empty($a_name) || empty($a_org) || empty($a_year)) {
                    $response["message"] = "Please fill in all fields";
                    if (empty($a_name)) {
                        $response["callback"] = "document.querySelector('input[name=\"a_name\"]').focus();";
                    } else if (empty($a_org)) {
                        $response["callback"] = "document.querySelector('input[name=\"a_org\"]').focus();";
                    } else if (empty($a_year)) {
                        $response["callback"] = "document.querySelector('input[name=\"a_year\"]').focus();";
                    }
                } else if (strlen($a_year) !== 4) {
                    $response["message"] = "Year must have exactly 4 characters";
                    $response["callback"] = "document.querySelector('input[name=\"a_year\"]').focus();";
                }
            }
        } else if ($operation == "delete") {
            $a_id = $_POST["a_id"];

            $sql = "SELECT a_name FROM award WHERE a_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $a_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $sql = "DELETE FROM award WHERE a_id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $a_id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $response["status"] = "success";
                    $response["message"] = "Delete award successfully";
                    $response["callback"] = "window.location.href = '../'";
                } else {
                    $response["message"] = "Error: delete award failed";
                }
            } else {
                $response["status"] = "warning";
                $response["message"] = "Award does not exist";
                $response["callback"] = "window.location.href = '../'";
            }
        }

        $conn->close();
    } else {
        $response["message"] = "Error: operation not set";
    }
} else {
    $response["message"] = "Error: request method not POST";
}

echo json_encode($response);
?>
