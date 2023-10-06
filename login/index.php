<?php
include '../php/utility_loader.php';
ob_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<div class="footer-wrapper">
    <?php include_once '../php/nav_loader.php'; ?>
    <div class="footer-content" align="center">
        <form action="../php/sql/sql_authen.php" method="post" name="form1" id="form1">
            <table class="login-table" align="center" cellpadding="10"><input type="hidden" name="operation" value="login">
                <tr>
                    <td colspan="2" class="header-cell">Login</td>
                </tr>
                <tr>
                    <td class="label-cell">Username</td>
                    <td><input name="username" class="form-control" type="text" size="20" id="username"/></td>
                </tr>
                <tr>
                    <td class="label-cell">Password</td>
                    <td><input name="password" class="form-control" type="password" size="20" id="password"/></td>
                </tr>
                <tr>
                    <td class="label-cell">Role</td>
                    <td>
                        <label>
                            <input name="userrole" type="radio" value="instructor" checked="checked" />
                            Instructor
                        </label>
                        <br />
                        <label>
                            <input name="userrole" type="radio" value="admin" />
                            Administrator
                        </label>
                        <br />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <button class="btn btn-orange me-3" type="submit" name="Submit">Login</button>
                        <button type="button" class="btn btn-orange" onclick="window.location.href = '../'">Cancel</button>
                        <script>
                            submitApply();
                        </script>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <?php include_once '../php/footer_loader.php'; ?>
</div>
<div id="scriptContainer"></div>
<?php include_once '../php/post_loaderV2.php'; ?>
</body>
</html>
