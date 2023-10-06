<?php
include("../auto/sql_util.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $i_id = $_POST['i_id'];
    $i_username = $_POST['i_username'];
    $i_password = $_POST['i_password'];
    $i_name = $_POST['i_name'];
    $i_address = $_POST['i_address'];
    $i_tel = $_POST['i_tel'];
    $po_id = $_POST['po_id'];
    $d_id = $_POST['d_id'];

    $i_pic = '';

    if (!empty($_FILES['i_pic']['name'])) {
        $fileExtension = pathinfo($_FILES['i_pic']['name'], PATHINFO_EXTENSION);
        $timestamp = time();
        $newFilename = "{$i_username}_{$timestamp}.{$fileExtension}";
        $uploadDirectory = '../../res/upload/';
        $uploadPath = $uploadDirectory . $newFilename;

        if (move_uploaded_file($_FILES['i_pic']['tmp_name'], $uploadPath)) {
            $i_pic = $newFilename;
        }
    }

    // Update the instructor information in the database
    $sql = (empty($i_pic)) ?
    "UPDATE instructor SET i_password = ?, i_name = ?, i_address = ?, i_tel = ?, po_id = ?, d_id = ? WHERE i_id = ?" :
    "UPDATE instructor SET i_password = ?, i_name = ?, i_address = ?, i_tel = ?, i_pic = ?, po_id = ?, d_id = ? WHERE i_id = ?";
    $stmt = $conn->prepare($sql);
    if (empty($i_pic)) {
        $stmt->bind_param("ssssiii", $i_password, $i_name, $i_address, $i_tel, $po_id, $d_id, $i_id);
    } else {
        $stmt->bind_param("ssssssii", $i_password, $i_name, $i_address, $i_tel, $i_pic, $po_id, $d_id, $i_id);
    }
    if ($stmt->execute()) {
        $response = array('status' => 'success', 'message' => 'Instructor information updated successfully.', 'callback' => 'history.back();');
    } else {
        $response = array('status' => 'error', 'message' => 'Failed to update instructor information.', 'callback' => 'location.reload();');
    }

    $stmt->close();

    // Return a JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
