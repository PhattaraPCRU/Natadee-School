<?php
$page_permission = 2;
include('../../php/utility_loader.php');
?>
<html>
    <head>
        <title>Add Award</title>
    </head>
    <body>
    <div class="footer-wrapper">
        <?php include_once '../../php/nav_loader.php'; ?>
        <div class="footer-content" align="center">
            <!-- Content Here -->
        <table style="width: 40%;" border="1" id="table_content">
            <tr>
                <th colspan="2" align="center"><b>Add Award</b></th>
            </tr>
            <form action="../../php/sql/sql_award.php">
            <input type="hidden" name="operation" value="add">
                <tr>
                    <td width="20%">Award Name</td>
                    <td width="80%"><input class="form-control" maxlength="40" type="text" name="a_name" required></td>
                </tr>
                <tr>
                    <td width="20%">Award From</td>
                    <td width="80%"><input class="form-control" maxlength="30" type="text" name="a_org" required></td>
                </tr>
                <tr>
                    <td width="20%">Award Year</td>
                    <td width="80%"><input class="form-control" maxlength="4" type="number" name="a_year" required></td>
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