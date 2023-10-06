<?php
include('../../../php/utility_loader.php');

$s_id = $_GET['s_id'];
$sql = "SELECT * FROM student WHERE s_id = '$s_id'";
$result = $conn->query($sql);
$result = $result->fetch_assoc();

?>
<html>
    <head>
        <title>Student infomation</title>
    </head>
    <body>
    <div class="footer-wrapper">
        <?php include_once '../../../php/nav_loader.php'; ?>
        <div class="footer-content" align="center">
            <!-- Content Here -->
        <table style="width: 40%;" border="1" id="table_content">
            <tr>
                <th colspan="2" align="center">Student infomation</th>
            </tr>
                <tr>
                    <td width="100%" colspan="2" align="center">
                        <div id="previewContainer" style="display: block;">
                            <img id="previewImage" src="../../../res/img/loading_cockroach.gif" height="180px">
                        </div>
                        <script>
                            <?PHP
                            if($result['s_pic'] == ""){
                                echo "document.getElementById('previewImage').src = '../../../res/img/No_Image_Available.jpg';";
                            }else{
                                echo "document.getElementById('previewImage').src = '../../../res/upload/student/".$result['s_pic']."';";
                            }
                            ?>
                        </script>
                    </td>
                </tr>
                <tr>
                    <td width="20%">Name</td>
                    <td width="80%"><input class="form-control" type="text" name="s_name" value="<?php echo $result['s_name']; ?>" readonly></td>
                </tr>
                <tr>
                    <td width="20%">Address</td>
                    <td width="80%"><textarea class="form-control" name="s_address" readonly><?php echo $result['s_address']; ?></textarea></td>
                </tr>
                <tr>
                    <td width="20%">Tel</td>
                    <td width="80%"><input class="form-control" type="text" name="s_tel" value="<?php echo $result['s_tel']; ?>" readonly></td>
                </tr>
                <tr>
                    <td width="20%">Classroom</td>
                    <td width="80%"><input class="form-control" type="text" name="c_Id" value="<?php
                        $sql = "SELECT * FROM classroom WHERE c_id = '".$result['c_id']."'";
                        $result2 = $conn->query($sql);
                        $result2 = $result2->fetch_assoc();
                        echo $result2['c_name'];
                    ?>" readonly></td>
                </tr>
                <tr>
                    <td width="20%">Parent</td>
                    <td width="80%"><input class="form-control" type="text" name="p_id" value="<?php
                        $sql = "SELECT * FROM parent WHERE p_id = '".$result['p_id']."'";
                        $result2 = $conn->query($sql);
                        $result2 = $result2->fetch_assoc();
                        echo $result2['p_name'];
                    ?>" readonly></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <button class="btn btn-orange" onclick="window.location.href = (document.referrer !== '') ? document.referrer : '/'">Back</button>
                    </td>
                </tr>
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