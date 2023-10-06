<?php
include('../../../php/utility_loader.php');

$i_id = $_GET['i_id'];
$sql = "SELECT * FROM instructor WHERE i_id = '$i_id'";
$result = $conn->query($sql);
$result = $result->fetch_assoc();

$sql = "SELECT * FROM award WHERE a_id IN (SELECT a_id FROM instructor_award WHERE i_id = '$i_id')";
$award_result = mysqli_execute_query($conn, $sql) or die(mysqli_error($conn));

?>
<html>
    <head>
        <title>Instructor infomation</title>
    </head>
    <body>
    <div class="footer-wrapper">
        <?php include_once '../../../php/nav_loader.php'; ?>
        <div class="footer-content" align="center">
            <!-- Content Here -->
        <table style="width: 40%;" border="1" id="table_content">
            <tr>
                <th colspan="2" align="center">Instructor infomation</th>
            </tr>
                <tr>
                    <td width="100%" colspan="2" align="center">
                        <div id="previewContainer" style="display: block;">
                            <img id="previewImage" src="../../../res/img/loading_cockroach.gif" height="180px">
                        </div>
                        <script>
                            <?PHP
                            if($result['i_pic'] == ""){
                                echo "document.getElementById('previewImage').src = '../../../res/img/No_Image_Available.jpg';";
                            }else{
                                echo "document.getElementById('previewImage').src = '../../../res/upload/".$result['i_pic']."';";
                            }
                            ?>
                        </script>
                    </td>
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
                        <button class="btn btn-orange" onclick="window.location.href = (document.referrer !== '') ? document.referrer : '/'">Back</button>
                    </td>
                </tr>
        </table>
        <table style="margin-top: 2%; width: 40%" width="80%" border="1" id="table_content">
          <tbody>
            <tr>
              <th width="100%" colspan="3" align="center">List of Awards</th>
            </tr>
            <tr class="column">
              <td width="43%"><b>Name</b></td>
              <td width="43%"><b>From</b></td>
              <td width="14%"><b>Year</b></td>
            </tr>
            <?php
            while ($award = mysqli_fetch_array($award_result)) {
            ?>
            <tr>
              <td>
                <?php echo "$award[a_name]";?>
              </td>
              <td>
                <?php echo "$award[a_org]";?>
              </td>
              <td>
                <?php echo "$award[a_year]";?>
              </td>
            </tr>
            <?php
            }
            ?>
          </tbody>
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