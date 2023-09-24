<?php
include('../../php/utility_loader.php');

$c_id = $_GET['c_id'];
$sql = "SELECT c_id, c_name FROM classroom WHERE c_id = '$c_id'";
$result = mysqli_fetch_array(mysqli_execute_query($conn, $sql));
?>
<html>
    <head>
        <title>Delete Classroom</title>
    </head>
    <body>
    <div class="footer-wrapper">
        <?php include_once '../../php/nav_loader.php'; ?>
        <div class="footer-content" align="center">
            <!-- Content Here -->
        <table style="width: 40%;" border="1" id="table_content">
            <tr>
                <th colspan="2" align="center"><b>Delete Classroom</b></th>
            </tr>
            <form action="../../php/sql/sql_classroom.php">
                <input type="hidden" name="c_id" value="<?php echo $result['c_id']; ?>" readonly>
                <input type="hidden" name="operation" value="delete">
                <tr>
                    <td width="30%">Classroom Name</td>
                    <td width="70%"><input class="form-control" maxlength="40" type="text" name="c_name" readonly value="<?php echo isset($result['c_name']) ? ($result['c_name'] != '' ? $result['c_name'] : 'N/A') : 'N/A'; ?>"></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <button type="submit" class="btn btn-orange me-1">Submit</button>
                        <button type="reset" class="btn btn-delete me-1">Reset</button>
                        <button type="button" class="btn btn-delete" onclick="window.location.href = '../'">Cancel</button>
                        <script>
                            submitApply();
                        </script>
                    </td>
                </tr>
            </form>
        </table>
        </div>
        <?PHP include_once '../../php/footer_loader.php'; ?>
    </div>
    <!-- <script src="/js/ajax_delete.js"></script> -->
    <div id="scriptContainer">
    </div>
    <?php include_once '../../php/post_loaderV2.php'; ?>
    </body>
</html>