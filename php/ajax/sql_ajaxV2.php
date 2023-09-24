<?php
include("../auto/sql_util.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    if ((isset($_POST['action'], $_POST['table'])) || (isset($requestData['action'], $requestData['table']))) {
        $action = isset($_POST['action']) ? $_POST['action'] : $requestData['action'];
        $table = isset($_POST['table']) ? $_POST['table'] : $requestData['table'];

        if ($table === 'instructor') {
            if ($action === 'add' || $action === 'edit') {
                $i_id = ($action === 'edit' ? $_POST['i_id'] : null);
                $i_name = $_POST['i_name'];
                $i_address = $_POST['i_address'];
                $i_tel = $_POST['i_tel'];
                $po_id = $_POST['po_id'];
                $d_id = $_POST['d_id'];
                $i_username = $_POST['i_username'];
                $i_password = $_POST['i_password'];
                $i_pic = null;

                if ($action === 'add') {
                    $sql = "SELECT i_id FROM instructor WHERE i_username = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('s', $i_username);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();

                    if ($result->num_rows > 0) {
                        http_response_code(400); // Bad Request
                        echo json_encode(array('status' => 'error', 'message' => 'Username already exists'));
                        exit;
                    }
                }

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

                if ($action === 'edit') {
                    $sql = "SELECT i_pic FROM instructor WHERE i_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('i', $i_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $stmt->close();
    
                    if ($i_pic === null) {
                        $i_pic = $row['i_pic'];
                    } else {
                        unlink("../../res/upload/{$row['i_pic']}");
                    }
                }
    
                $sql = ($action === 'add' ?
                    "INSERT INTO instructor (i_name, i_address, i_tel, i_pic, po_id, d_id, i_username, i_password) VALUES(?, ?, ?, ?, ?, ?, ?, ?)" :
                    "UPDATE instructor SET i_name = ?, i_address = ?, i_tel = ?, i_pic = ?, po_id = ?, d_id = ?, i_username = ?, i_password = ? WHERE i_id = ?");
                $stmt = $conn->prepare($sql);
    
                $paramTypes = 'ssssiiss';
                $paramValues = [$i_name, $i_address, $i_tel, $i_pic, $po_id, $d_id, $i_username, $i_password];
    
                if ($action === 'edit') {
                    $paramTypes .= 's';
                    $paramValues[] = $i_id;
                }
    
                $stmt->bind_param($paramTypes, ...$paramValues);
                $stmt->execute();
                $stmt->close();
    
                $response = array('status' => 'success', 'message' => 'Instructor ' . ($action === 'add' ? 'added' : 'updated') . ' successfully');
                echo json_encode($response);
                exit;
            } elseif ($action === 'delete') {
                $i_id = $requestData['id'];

                $stmt = $conn->prepare("DELETE FROM instructor WHERE i_id = ?");
                $stmt->bind_param('i', $i_id);
                $stmt->execute();
                $stmt->close();

                $response = array('status' => 'success', 'message' => 'Instructor deleted successfully');
                echo json_encode($response);
                exit;
            } elseif ($action === 'check') {
                $i_username = $_POST['i_username'];

                $stmt = $conn->prepare("SELECT i_id FROM instructor WHERE i_username = ?");
                $stmt->bind_param('s', $i_username);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                if ($result->num_rows > 0) {
                    http_response_code(400); // Bad Request
                    echo json_encode(array('status' => 'error', 'message' => 'Username already exists'));
                    exit;
                } else {
                    $response = array('status' => 'success', 'message' => 'Username available');
                    echo json_encode($response);
                    exit;
                }
            } elseif ($action === 'get') {
                $i_id = $requestData['id'];

                $stmt = $conn->prepare("SELECT * FROM instructor WHERE i_id = ?");
                $stmt->bind_param('i', $i_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $stmt->close();

                $response = array('status' => 'success', 'data' => $row);
                echo json_encode($response);
                exit;
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(array('status' => 'error', 'message' => 'Invalid action'));
                exit;
            }
        } elseif ($table === 'position') {
            if ($action === 'add' || $action === 'edit') {
                $po_id = ($action === 'edit' ? $_POST['po_id'] : null);
                $po_name = $_POST['po_name'];

                if ($action === 'add') {
                    $sql = "SELECT po_id FROM position WHERE po_name = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('s', $po_name);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();

                    if ($result->num_rows > 0) {
                        http_response_code(400); // Bad Request
                        echo json_encode(array('status' => 'error', 'message' => 'Position already exists'));
                        exit;
                    }
                }

                $sql = ($action === 'add' ?
                    "INSERT INTO position (po_name) VALUES(?)" :
                    "UPDATE position SET po_name = ? WHERE po_id = ?");
                $stmt = $conn->prepare($sql);

                $paramTypes = 's';
                $paramValues = [$po_name];

                if ($action === 'edit') {
                    $paramTypes .= 'i';
                    $paramValues[] = $po_id;
                }

                $stmt->bind_param($paramTypes, ...$paramValues);
                $stmt->execute();
                $stmt->close();

                $response = array('status' => 'success', 'message' => 'Position ' . ($action === 'add' ? 'added' : 'updated') . ' successfully');
                echo json_encode($response);
                exit;
            } elseif ($action === 'delete') {
                $po_id = $requestData['id'];

                $stmt = $conn->prepare("DELETE FROM position WHERE po_id = ?");
                $stmt->bind_param('i', $po_id);
                $stmt->execute();
                $stmt->close();

                $response = array('status' => 'success', 'message' => 'Position deleted successfully');
                echo json_encode($response);
                exit;
            } elseif ($action === 'get') {
                $po_id = $requestData['id'];

                $stmt = $conn->prepare("SELECT * FROM position WHERE po_id = ?");
                $stmt->bind_param('i', $po_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $stmt->close();

                $response = array('status' => 'success', 'data' => $row);
                echo json_encode($response);
                exit;
            } elseif ($action === 'get_all') {
                $stmt = $conn->prepare("SELECT * FROM position");
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                $departmentOptions = array();
                while ($rs = mysqli_fetch_array($result)) {
                    $departmentOptions[] = array(
                        'value' => $rs['po_id'],
                        'text' => $rs['po_name']
                    );
                }

                $response = array('status' => 'success', 'data' => $departmentOptions);
                echo json_encode($response);
                exit;
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(array('status' => 'error', 'message' => 'Invalid action'));
                exit;
            }
        } elseif ($table === 'department') {
            if ($action === 'add' || $action === 'edit') {
                $d_id = ($action === 'edit' ? $_POST['d_id'] : null);
                $d_name = $_POST['d_name'];

                if ($action === 'add') {
                    $sql = "SELECT d_id FROM department WHERE d_name = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('s', $d_name);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();

                    if ($result->num_rows > 0) {
                        http_response_code(400); // Bad Request
                        echo json_encode(array('status' => 'error', 'message' => 'Department already exists'));
                        exit;
                    }
                }

                $sql = ($action === 'add' ?
                    "INSERT INTO department (d_name) VALUES(?)" :
                    "UPDATE department SET d_name = ? WHERE d_id = ?");
                $stmt = $conn->prepare($sql);

                $paramTypes = 's';
                $paramValues = [$d_name];

                if ($action === 'edit') {
                    $paramTypes .= 'i';
                    $paramValues[] = $d_id;
                }

                $stmt->bind_param($paramTypes, ...$paramValues);
                $stmt->execute();
                $stmt->close();

                $response = array('status' => 'success', 'message' => 'Department ' . ($action === 'add' ? 'added' : 'updated') . ' successfully');
                echo json_encode($response);
                exit;
            } elseif ($action === 'delete') {
                $d_id = $requestData['id'];

                $stmt = $conn->prepare("DELETE FROM department WHERE d_id = ?");
                $stmt->bind_param('i', $d_id);
                $stmt->execute();
                $stmt->close();

                $response = array('status' => 'success', 'message' => 'Department deleted successfully');
                echo json_encode($response);
                exit;
            } elseif ($action === 'get') {
                $d_id = $requestData['id'];

                $stmt = $conn->prepare("SELECT * FROM department WHERE d_id = ?");
                $stmt->bind_param('i', $d_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $stmt->close();

                $response = array('status' => 'success', 'data' => $row);
                echo json_encode($response);
                exit;
            } elseif ($action === 'get_all') {
                $stmt = $conn->prepare("SELECT * FROM department");
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                $departmentOptions = array();
                while ($rs = mysqli_fetch_array($result)) {
                    $departmentOptions[] = array(
                        'value' => $rs['d_id'],
                        'text' => $rs['d_name']
                    );
                }

                $response = array('status' => 'success', 'data' => $departmentOptions);
                echo json_encode($response);
                exit;
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(array('status' => 'error', 'message' => 'Invalid action'));
                exit;
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(array('status' => 'error', 'message' => 'Invalid table'));
            exit;
        }
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(array('status' => 'error', 'message' => 'Missing action or table'));
        exit;
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('status' => 'error', 'message' => 'Method not allowed'));
    exit;
}
?>
