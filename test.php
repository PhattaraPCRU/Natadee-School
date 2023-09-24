<?php
include "connect.php";

$std_name = $_POST['std_name'];
$std_address = $_POST['std_address'];
$std_tel = $_POST['std_tel'];
$pa_id = $_POST['pa_id'];
$c_id = $_POST['c_id'];

$fileupload = $_FILES['photo']['tmp_name'];
$fileupload_name = $_FILES['photo']['name'];

if ($std_name != "") {
	$sql = "SELECT * FROM student WHERE std_name = '$std_name' ";
	$result = mysqli_query($conn, $sql);
	$total = mysqli_num_rows($result);
	if ($total == 0) {
		if ($fileupload != "") {
			$fileExtension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
			$timestamp = time();
			$newfilename = "{$std_name}_{$timestamp}.{$fileExtension}";
			copy($fileupload, "picture/" . $newfilename);
			$sql = "INSERT INTO student (std_name, std_address, std_tel, pa_id, c_id, std_pic) VALUES ('$std_name', '$std_address', '$std_tel', '$pa_id', '$c_id', '$newfilename')";
		} else {
			$sql = "INSERT INTO student (std_name, std_address, std_tel, pa_id, c_id) VALUES ('$std_name', '$std_address', '$std_tel', '$pa_id', '$c_id')";
		}
		mysqli_query($conn, $sql)
			or die("Can't query sql");

		mysqli_close($conn);

		echo "<script language=\"javascript\">";
		echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว');";
		echo "window.location = 'showstudent.php';";
		echo "</script>	";
	} else {
		echo "<script language=\"javascript\">";
		echo "alert('กรุณาป้อนข้อมูล');";
		echo "window.history.back();";
		echo "</script>	";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Untitled Document</title>
</head>

<body>
</body>

</html>