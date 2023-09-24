<?php
include("../auto/sql_util.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $d_id = $_POST['d_id'];
    $i_id = $_POST['i_id'];
    if (empty($i_id)) {
        $i_id = NULL;
    }
    $sql = "UPDATE department SET i_id = ? WHERE d_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $i_id, $d_id);
    if ($stmt->execute()) {
        $response = array('status' => 'success', 'message' => 'Department information updated successfully.');
    } else {
        $response = array('status' => 'error', 'message' => 'Failed to update department information.');
    }
    $stmt->close();

    // Return a JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>