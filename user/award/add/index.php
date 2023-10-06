<?php
$page_permission = 1;
include('../../../php/utility_loader.php');
$sql = "SELECT a.* FROM award a LEFT JOIN instructor_award ia ON a.a_id = ia.a_id AND ia.i_id = (SELECT i_id FROM instructor WHERE i_username = '$_SESSION[username]') WHERE ia.a_id IS NULL";
$result = mysqli_execute_query($conn, $sql) or die(mysqli_error($conn));

if (mysqli_num_rows($result) == 0) {
    echo '<script>
                window.onload = function() {
                    swal_callback("Infomation", "There is no awards left\nPlease contact school administration.", "info", "Go Back", function(confirmed) {
                        if (confirmed) {
                            window.location.href = "../";
                        }
                    });
                    var tableContent = document.getElementById("table_content");
                    if (tableContent) {
                        tableContent.parentNode.removeChild(tableContent);
                    }
                };
            </script>';
}

?>
<html>
    <head>
        <title>Add award | <?php echo $_SESSION["username"]; ?></title>
    </head>
    <body>
    <div class="footer-wrapper">
        <?php include_once '../../../php/nav_loader.php'; ?>
        <div class="footer-content" align="center">
            <!-- Content Here -->
        <table style="width: 40%;" border="1" id="table_content">
            <tr>
                <th colspan="2" align="center"><b>Choose award</b></th>
            </tr>
            <form action="../../../php/sql/sql_instructor_award.php">
                <input type="hidden" name="i_id" value="<?php $i_id = mysqli_fetch_array(mysqli_execute_query($conn, "SELECT i_id FROM instructor WHERE i_username = '$_SESSION[username]'")); echo $i_id['i_id']; ?>" readonly>
                <input type="hidden" name="operation" value="add" readonly>
                <tr>
                    <td width="20%"><b>Award</b></td>
                    <td width="80%">
                        <select name="a_id" class="form-select">
                            <?php
                            while ($rs = mysqli_fetch_array($result)) {
                                echo "<option value='$rs[a_id]'>$rs[a_name] ($rs[a_year])</option>";
                            }
                            ?>
                        </select>
                    </td>
                <tr>
                    <td colspan="2" align="center">
                        <button type="submit" class="btn btn-orange me-1">Submit</button>
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