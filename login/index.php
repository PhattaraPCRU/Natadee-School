<?php
include('../php/utility_loader.php');

ob_start();

?>

<html>
<head>
    <title>Login</title>
</head>
<body>
<div class="footer-wrapper">
    <?php include_once '../php/nav_loader_guest.php'; ?>
    <div class="footer-content" align="center">
        <!-- Content Here -->
        <form action="../php/sql/login.php" method="post" name="form1" id="form1">
            <table border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#ff9933" >
                <tr>
                    <td height="29" colspan="3" bgcolor="#ff9933"><div align="center"><strong>เข้าระบบ</strong></div></td>
                </tr>
                <tr>
                    <td width="120">ชื่อล็อกอิน</td>
                    <td width="240"><input name="login" class="form-control" type="text" size="20" /></td>
                </tr>
                <tr>
                    <td>รหัสผ่าน</td>
                    <td><input name="passwd" class="form-control" type="password" id="passwd" size="20" /></td>
                </tr>
                <tr>
                    <td>สถานะ</td>
                    <td><p>
                            <label>
                                <input name="user_status" type="radio" id="user_status_0" value="1" checked="checked" />
                                ครูอาจารย์</label>
                            <br />
                            <label>
                                <input type="radio" name="user_status" value="0" id="user_status_2" />
                                ผู้ดูแลระบบ</label>
                            <br />
                        </p></td>
                </tr>

                <tr>
                    <td colspan="2" align="center">
                       <button class="btn btn-orange" type="submit" name="Submit" value="เข้าสู่ระบบ">เข้าสู่ระบบ</button>
                    </td>
                </tr>
            </table>
      </form>
    </div>
    <?PHP include_once '../php/footer_loader.php'; ?>
</div>
<div id="scriptContainer">
</div>
<?php include_once '../php/post_loaderV2.php'; ?>
</body>
</html>
