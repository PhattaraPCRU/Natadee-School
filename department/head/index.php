<?php
$page_permission = 2;
include('../../php/utility_loader.php');

$d_id = $_GET['d_id'];
$result = mysqli_execute_query($conn ,"SELECT * FROM department WHERE d_id = '$d_id'");
$result = mysqli_fetch_array($result);

?>
<html>
    <head>
        <title>Edit-Head of Department</title>
    </head>
    <body>
    <div class="footer-wrapper">
        <?php include_once '../../php/nav_loader.php'; ?>
        <div class="footer-content" align="center">
            <!-- Content Here -->
        <table style="width: 40%;" border="1" id="table_content">
            <tr>
                <th colspan="2" align="center">Head of Department</th>
            </tr>
            <form action="../../php/sql/edit_detail_department.php"><input type="hidden" name="i_id" value="<?php echo $result['i_id']; ?>">
                <tr>
                    <td width="20%">Department</td>
                    <td width="80%">
                        <?php echo "$result[d_name]" ?>
                        <input type="hidden" name="d_id" value="<?php echo $result['d_id']; ?>">
                    </td>
                </tr>
                <tr>
                    <td width="20%">Head of Department</td>
                    <td width="80%">
                        <select name="i_id" class="form-select">
                            <?php
                            echo "<option value=''>[Remove Head of Department]</option>";
                            $result1 = mysqli_execute_query($conn ,"SELECT * FROM instructor WHERE d_id = '$result[d_id]'");
                            while ($rs = mysqli_fetch_array($result1)) {
                                echo "<option value='$rs[i_id]' ";
                                if ($rs['i_id'] == $result['i_id']) {
                                    echo "selected";
                                }
                                echo ">$rs[i_name]</option>";
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
                            const submitButton = document.querySelector('button[type="submit"]');
                            
                            submitButton.addEventListener('click', function(e) {
                                e.preventDefault();
                                const form = document.querySelector('form');
                                const formData = new FormData(form);
                                const xhr = new XMLHttpRequest();
                                xhr.open('POST', form.action, true);
                                xhr.onload = function() {
                                    if (xhr.status === 200) {
                                        console.log(xhr.response.message);
                                        swal_callback('Success', xhr.response.message, 'success', 'OK', function() {
                                            window.location.href = '../';
                                        });
                                    } else {
                                        swal.fire('Error', xhr.response.message, 'error');
                                    }
                                };
                                xhr.send(formData);
                            });
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