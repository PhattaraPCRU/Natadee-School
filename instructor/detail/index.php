<?php
include('../../php/utility_loader.php');

$i_id = $_GET['i_id'];
$sql = "SELECT * FROM instructor WHERE i_id = '$i_id'";
$result = $conn->query($sql);
$result = $result->fetch_assoc();

?>
<html>
    <head>
        <title>Detail-Instructor</title>
    </head>
    <body>
    <div class="footer-wrapper">
        <?php include_once '../../php/nav_loader.php'; ?>
        <div class="footer-content" align="center">
            <!-- Content Here -->
        <table style="width: 40%;" border="1" id="table_content">
            <tr>
                <th colspan="2" align="center">Detail Instructor</th>
            </tr>
                <tr>
                    <td width="100%" colspan="2" align="center">
                        <div id="previewContainer" style="display: block;">
                            <img id="previewImage" src="../../res/upload/<?php echo $result['i_pic']; ?>" height="180px">
                        </div>
                        <script>
                            <?PHP
                            if($result['i_pic'] == ""){
                                echo "document.getElementById('previewImage').src = '../../res/img/No_Image_Available.jpg';";
                            }
                            ?>
                        </script>
                    </td>
                </tr>
                <tr>
                    <td width="20%">Username</td>
                    <td width="80%"><input class="form-control" type="text" name="i_username" value="<?php echo $result['i_username']; ?>" readonly></td>
                </tr>
                <tr>
                    <td width="20%">Password</td>
                    <td width="80%"><input class="form-control" type="text" name="i_password" value="<?php echo $result['i_password']; ?>" readonly></td>
                </tr>
                <tr>
                    <td width="20%">Name</td>
                    <td width="80%"><input class="form-control" type="text" name="i_name" value="<?php echo $result['i_name']; ?>" readonly></td>
                </tr>
                <tr>
                    <td width="20%">Address</td>
                    <td width="80%"><textarea class="form-control" name="i_address" readonly><?php echo $result['i_address']; ?></textarea></td>
                </tr>
                <tr>
                    <td width="20%">Tel</td>
                    <td width="80%"><input class="form-control" type="text" name="i_tel" value="<?php echo $result['i_tel']; ?>" readonly></td>
                </tr>
                <tr>
                    <td width="20%">Department</td>
                    <td width="80%"><input class="form-control" type="text" name="i_department" value="<?php
                        $sql = "SELECT * FROM department WHERE d_id = '".$result['d_id']."'";
                        $result2 = $conn->query($sql);
                        $result2 = $result2->fetch_assoc();
                        echo $result2['d_name'];
                    ?>" readonly></td>
                </tr>
                <tr>
                    <td width="20%">Position</td>
                    <td width="80%"><input class="form-control" type="text" name="i_position" value="<?php
                        $sql = "SELECT * FROM position WHERE po_id = '".$result['po_id']."'";
                        $result2 = $conn->query($sql);
                        $result2 = $result2->fetch_assoc();
                        echo $result2['po_name'];
                    ?>" readonly></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <button class="btn btn-orange me-1" onclick="window.location.href = '../edit/?i_id=<?php echo $result['i_id']; ?>'">Edit</button>
                        <button class="btn btn-orange" onclick="window.location.href = '../'">Back</button>
                    </td>
                </tr>
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