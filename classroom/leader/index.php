<?php
include('../../php/utility_loader.php');

$c_id = $_GET['c_id'];
$sql = "SELECT * FROM classroom WHERE c_id = '$c_id'";
$result = mysqli_fetch_array(mysqli_execute_query($conn, $sql));

?>
<html>
    <head>
        <title>Class Leader</title>
    </head>
    <body>
    <div class="footer-wrapper">
        <?php include_once '../../php/nav_loader.php'; ?>
        <div class="footer-content" align="center">
            <!-- Content Here -->
        <table style="width: 40%;" border="1" id="table_content">
            <tr>
                <th colspan="2" align="center"><b>Class Leader</b></th>
            </tr>
            <form action="../../php/sql/sql_classroom.php">
                <input type="hidden" name="c_id" value="<?php echo $c_id ?>" readonly>
                <input type="hidden" name="operation" value="leader" readonly>
                <tr>
                    <td width="20%"><b>Class Name</b></td>
                    <td width="80%">
                        <?php echo "$result[c_name]" ?>
                    </td>
                </tr>
                <tr>
                    <td width="20%"><b>Class Leader</b></td>
                    <td width="80%">
                        <select name="s_id" class="form-select">
                            <?php
                            echo "<option value=''>[Remove Leader]</option>";
                            $sql = "SELECT * FROM student";
                            $resultI = mysqli_execute_query($conn, $sql);
                            while ($rowI = mysqli_fetch_array($resultI)) {
                                if ($rowI['s_id'] === $result['s_id']) {
                                    echo "<option value='$rowI[s_id]' selected>$rowI[s_name]</option>";
                                } else {
                                    echo "<option value='$rowI[s_id]'>$rowI[s_name]</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
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