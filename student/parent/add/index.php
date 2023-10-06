<?php
$page_permission = 2;
include('../../../php/utility_loader.php');
?>
<html>
    <head>
        <title>Add Parent</title>
    </head>
    <body>
    <div class="footer-wrapper">
        <?php include_once '../../../php/nav_loader.php'; ?>
        <div class="footer-content" align="center">
            <!-- Content Here -->
        <table style="width: 40%;" border="1" id="table_content">
            <tr>
                <th colspan="2" align="center">Add Parent</th>
            </tr>
            <form action="../../../php/sql/sql_parent.php"><input type="hidden" name="operation" value="add">
                <tr>
                    <td width="20%">Thai National ID</td>
                    <td width="80%"><input class="form-control" type="text" name="p_id" pattern="[0-9]" maxlength="13"></td>
                </tr>
                <tr>
                    <td width="20%">Name</td>
                    <td width="80%"><input class="form-control" type="text" name="p_name" value=""></td>
                </tr>
                <tr>
                    <td width="20%">Job</td>
                    <td width="80%"><input class="form-control" type="text" name="p_job" value=""></td>
                </tr>
                <tr>
                    <td width="20%">Tel</td>
                    <td width="80%"><input class="form-control" type="tel" name="p_tel" pattern="[0-9]" maxlength="10"></td>
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