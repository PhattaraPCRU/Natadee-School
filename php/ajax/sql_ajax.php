<?php
include("../auto/sql_util.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = json_decode(file_get_contents('php://input'), true);

    if (
        isset($requestData['action']) &&
        isset($requestData['table']) &&
        (isset($requestData['id']) || $requestData['action'] === 'add')
    ) {
        $action = $requestData['action'];
        $table = $requestData['table'];
        if($requestData['action'] !== 'add'){
            $id = $requestData['id'];
        }
        if ($action === 'delete' && $table === 'department') { // Delete Ajax
            $sql = "DELETE FROM department WHERE d_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();

            $response = array('status' => 'success', 'message' => 'Department deleted successfully');
            echo json_encode($response);
            exit;
        } if ($action === 'edit' && $table === 'department' && isset($requestData['name']) && isset($requestData['value'])) {
            $name = $requestData['name'];
            $value = $requestData['value'];

            $sql = "UPDATE department SET $name = ? WHERE d_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $value, $id);
            $stmt->execute();
            $stmt->close();

            $response = array('status' => 'success', 'message' => 'Department updated successfully');
            echo json_encode($response);
            exit;
        } if ($action === 'add' && $table === 'department' && isset($requestData['name']) && isset($requestData['value'])) {
            $name = $requestData['name'];
            $value = $requestData['value'];

            $sql = "INSERT INTO department ($name) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $value);
            $stmt->execute();
            $sql = "SELECT d_id FROM department WHERE $name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $value);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $id = $row['d_id'];
            $stmt->close();

            $response = array('status' => 'success', 'message' => 'Department added successfully', 'id' => $id, 'table' => $table, 'value' => $value);
            echo json_encode($response);
            exit;
        } if ($action === 'delete' && $table === 'position') { //Position Ajax
            $sql = "DELETE FROM position WHERE po_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();

            $response = array('status' => 'success', 'message' => 'Position deleted successfully');
            echo json_encode($response);
            exit;
        } if ($action === 'edit' && $table === 'position' && isset($requestData['name']) && isset($requestData['value'])) {
            $name = $requestData['name'];
            $value = $requestData['value'];

            $sql = "UPDATE position SET $name = ? WHERE po_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $value, $id);
            $stmt->execute();
            $stmt->close();

            $response = array('status' => 'success', 'message' => 'Position updated successfully');
            echo json_encode($response);
            exit;
        } if ($action === 'add' && $table === 'position' && isset($requestData['name']) && isset($requestData['value'])) {
            $name = $requestData['name'];
            $value = $requestData['value'];

            $sql = "INSERT INTO position ($name) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $value);
            $stmt->execute();
            $sql = "SELECT po_id FROM position WHERE $name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $value);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $id = $row['po_id'];
            $stmt->close();

            $response = array('status' => 'success', 'message' => 'Position added successfully', 'id' => $id, 'table' => $table, 'value' => $value);
            echo json_encode($response);
            exit;
        } if ($action === 'delete' && $table === 'instructor') { //Instructor Ajax
            $sql = "DELETE FROM instructor WHERE i_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();

            $response = array('status' => 'success', 'message' => 'Instructor deleted successfully');
            echo json_encode($response);
            exit;
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(array('status' => 'error', 'message' => 'Invalid action or table'));
            exit;
        }
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(array('status' => 'error', 'message' => 'Missing or invalid parameters'));
        exit;
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('status' => 'error', 'message' => 'Method not allowed'));
    exit;
}
?>
