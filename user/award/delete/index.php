<?php
$page_permission = 1;
include('../../../php/utility_loader.php');
$a_id = $_GET['a_id'];
$sql = "SELECT * FROM award WHERE a_id = $a_id";
$result = mysqli_execute_query($conn, $sql) or die(mysqli_error($conn));

$instructor = mysqli_fetch_array(mysqli_execute_query($conn, "SELECT i_id FROM instructor WHERE i_username = '$_SESSION[username]'"));

if (mysqli_num_rows($result) == 0) {
    echo '<script>
                window.onload = function() {
                    swal_callback("Error", "Award does not exist or might be deleted!.", "error", "Go Back", function(confirmed) {
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
        <title>Delete award | <?php echo $_SESSION["username"]; ?></title>
    </head>
    <body>
    <div class="footer-wrapper">
        <?php include_once '../../../php/nav_loader.php'; ?>
        <div class="footer-content" align="center">
            <!-- Content Here -->
        <table style="width: 40%;" border="1" id="table_content">
            <tr>
                <th colspan="2" align="center"><b>Delete award</b></th>
            </tr>
            <form action="../../../php/sql/sql_instructor_award.php">
                <input type="hidden" name="operation" value="delete" readonly>
                <tr>
                    <td width="20%"><b>Award</b></td>
                    <td width="80%">
                        <select name="a_id" class="form-select" disabled>
                            <?php
                            while ($rs = mysqli_fetch_array($result)) {
                                echo "<option value='$rs[a_id]'>$rs[a_name] ($rs[a_year])</option>";
                            }
                            ?>
                        </select>
                        <input type="hidden" name="a_id" value="<?php echo $a_id; ?>" readonly>
                        <input type="hidden" name="i_id" value="<?php echo $instructor["i_id"]; ?>" readonly>
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