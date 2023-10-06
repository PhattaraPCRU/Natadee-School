<?php
include("../auto/sql_util.php");

$response = [
    "status" => "error",
    "message" => "An error occurred while processing the request",
    "callback" => ""
];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['operation'])) {
    $operation = $_POST['operation'];

    if ($operation === "update") {
        $quote = trim($_POST['quote']);

        if (!empty($quote)) {
            $sql = "INSERT INTO quotes (quote, date) VALUES (?, NOW())";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("s", $quote);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $response["status"] = "success";
                    $response["message"] = "Quote added successfully";
                } else {
                    $response["message"] = "Failed to add quote";
                }
            } else {
                $response["message"] = "Database error: " . mysqli_stmt_error_list($conn)[0]['error'];
            }
        } else {
            $response["status"] = "warning";
            $response["message"] = "Please enter a quote";
        }
    } elseif ($operation === "clear") {
        $sql = "TRUNCATE TABLE quotes";
        if ($conn->query($sql)) {
            $response["status"] = "success";
            $response["message"] = "Quote cleared successfully";
        } else {
            $response["message"] = "Failed to clear quotes: " . mysqli_stmt_error_list($conn)[0]['error'];
        }
    } else {
        $response["message"] = "Invalid operation";
    }
}
echo json_encode($response);
?>
