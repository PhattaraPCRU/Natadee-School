<?php
include('php/utility_loader.php');

if (isset($_POST['txt_search'])) {
    $txt_search = $_POST['txt_search'];
} else {
    $txt_search = "";
}

if ($txt_search != "") {	
    $sql = "SELECT instructor.i_id, instructor.i_name, department.d_name FROM instructor, department WHERE instructor.d_id = '$txt_search' AND instructor.d_id = department.d_id";
} else {
    $sql = "SELECT instructor.i_id, instructor.i_name, department.d_name FROM instructor, department WHERE instructor.d_id = department.d_id";
}

$result = mysqli_query($conn, $sql) or die("3. ไม่สามารถประมวลผลคำสั่งได้ " . mysqli_error($conn));
?>

<html>
<head>
    <title>Edit Award</title>
</head>
<body>
<div class="footer-wrapper">
    <?php include_once 'php/nav_loader.php'; ?>
    <div class="footer-content" align="center">
        <!-- Content Here -->
        <table style="width: 40%;" border="1" id="table_content">
            <tr>
                <td>
                    <p>&nbsp;</p>
                    <form id="form1" name="form1" method="post" action="index1.php">
                        <table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
                            <tr>
                                <td><strong>ชื่อกลุ่มสาระ</strong>
                                    <select name="txt_search" id="txt_search">
                                        <option value="" selected="selected">ทั้งหมด</option>
                                        <?php
                                        $sql2 = "SELECT * FROM department";
                                        $result2 = mysqli_query($conn, $sql2);
                                        while ($rs2 = mysqli_fetch_array($result2)) {
                                            echo "<option value=\"$rs2[d_id]\" ";
                                            if ("$txt_search" == "$rs2[d_id]") {
                                                echo 'selected';
                                            }
                                            echo ">$rs2[d_name]";
                                            echo "</option>\n";
                                        }
                                        ?>
                                    </select>
                                    <input type="submit" name="button" id="button" value="ค้นหา" />
                                </td>
                            </tr>
                        </table>
                    </form>
                    <p>&nbsp;</p>
                    <table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
                        <tr>
                            <td>รายงานข้อมูลครู</td>
                        </tr>
                    </table>
                    <table width="500" border="1" align="center" cellpadding="5" cellspacing="0">
                        <tr>
                            <td>ชื่อ</td>
                            <td>กลุ่มสาระ</td>
                            <td>&nbsp; </td>
                        </tr>
                        <?php
                        while ($rs = mysqli_fetch_array($result)) {
                            ?>        
                            <tr>
                                <td><?php echo "$rs[i_name]"; ?></td>
                                <td><?php echo "$rs[d_name]"; ?></td>
                                <td><?php echo "<a href=\"frm_showdetail.php?i_id=$rs[i_id]\">"; ?>รายละเอียด<?php echo "</a>"; ?></td>
                            </tr>
                            <?php
                        }
                        mysqli_close($conn);
                        ?>       
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <?PHP include_once 'php/footer_loader.php'; ?>
</div>
<div id="scriptContainer">
</div>
<?php include_once 'php/post_loaderV2.php'; ?>
</body>
</html>
