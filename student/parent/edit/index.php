<?php
$page_permission = 2;
include('../../../php/utility_loader.php');

$sql = "SELECT * FROM parent WHERE p_id = '".$_GET['p_id']."'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

?>
<html>
    <head>
        <title>Edit Parent</title>
    </head>
    <body>
    <div class="footer-wrapper">
        <?php include_once '../../../php/nav_loader.php'; ?>
        <div class="footer-content" align="center">
            <!-- Content Here -->
        <table style="width: 40%;" border="1" id="table_content">
            <tr>
                <th colspan="2" align="center">Edit Parent</th>
            </tr>
            <form action="../../../php/sql/sql_parent.php"><input type="hidden" name="operation" value="edit">
                <input type="hidden" name="p_id" value="<?php echo $row['p_id']; ?>">
                <tr>
                    <td width="20%">Thai National ID</td>
                    <td width="80%"><input class="form-control" type="text" name="p_id" pattern="[0-9]" maxlength="13"value="<?php echo $row['p_id']; ?>" disabled></td>
                </tr>
                <tr>
                    <td width="20%">Name</td>
                    <td width="80%"><input class="form-control" type="text" name="p_name" value="<?php echo $row['p_name']; ?>"></td>
                </tr>
                <tr>
                    <td width="20%">Job</td>
                    <td width="80%"><input class="form-control" type="text" name="p_job" value="<?php echo $row['p_job']; ?>"></td>
                </tr>
                <tr>
                    <td width="20%">Tel</td>
                    <td width="80%"><input class="form-control" type="tel" name="p_tel" pattern="[0-9]" maxlength="10" value="<?php echo $row['p_tel']; ?>"></td>
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
        <?PHP include_once '../../../php/footer_loader.php'; ?>
    </div>
    <!-- <script src="/js/ajax_delete.js"></script> -->
    <div id="scriptContainer">
    </div>
    <?php include_once '../../../php/post_loaderV2.php'; ?>
    </body>
</html>