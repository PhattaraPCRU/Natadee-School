<?php
include "util/sql_util.php";
$d_id=$_POST['d_id'];
$sql="DELETE FROM department WHERE d_id='$d_id'";
mysqli_query($conn,$sql) or die("Can't query sql");
mysqli_close($conn);
?>
<script language="javascript">
    alert('ลบข้อมูลเรียบร้อยแล้ว');
    window.location = '/department/';
</script>