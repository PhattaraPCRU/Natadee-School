<?php
include('../../php/utility_loader.php');

$sql = "SELECT * FROM student WHERE s_id = '".$_GET['s_id']."'";
$result = mysqli_execute_query($conn ,$sql) or die(mysqli_error($conn));
$result = mysqli_fetch_array($result);

?>
<html>
    <head>
        <title>Edit Student</title>
    </head>
    <body>
    <div class="footer-wrapper">
        <?php include_once '../../php/nav_loader.php'; ?>
        <div class="footer-content" align="center">
            <!-- Content Here -->
        <table style="width: 40%;" border="1" id="table_content">
            <tr>
                <th colspan="2" align="center">Edit Student</th>
            </tr>
            <form action="../../php/sql/sql_student.php"><input type="hidden" name="operation" value="edit">
            <input type="hidden" name="s_id" value="<?php echo $result['s_id']; ?>">
                <tr>
                    <td width="20%">Name</td>
                    <td width="80%"><input class="form-control" type="text" name="s_name" value="<?php echo $result['s_name']; ?>"></td>
                </tr>
                <tr>
                    <td width="20%">Address</td>
                    <td width="80%"><textarea class="form-control" name="s_address"><?php echo $result['s_address']; ?></textarea></td>
                </tr>
                <tr>
                    <td width="20%">Tel</td>
                    <td width="80%"><input class="form-control" type="tel" name="s_tel" value="<?php echo $result['s_tel']; ?>"></td>
                </tr>
                <tr>
                    <td width="20%">Image</td>
                    <td width="80%">
                        <div id="previewContainer" style="display: block;">
                            <img id="previewImage" src="" height="180px">
                        </div>
                        <input id="fileInput" class="form-control" type="file" name="s_pic" accept="image/png, image/jpeg, image/jpg, image/gif">
                        <script>
                            <?PHP
                            if($result['s_pic'] == ""){
                                echo "document.getElementById('previewImage').src = '../../res/img/No_Image_Available.jpg';";
                            }else{
                                echo "document.getElementById('previewImage').src = '../../res/upload/student/".$result['s_pic']."';";
                            }
                            ?>
                            const fileInput = document.getElementById('fileInput');
                            const previewContainer = document.getElementById('previewContainer');
                            const previewImage = document.getElementById('previewImage');

                            fileInput.addEventListener('change', function() {
                                const file = fileInput.files[0];
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function(event) {
                                        previewImage.src = event.target.result;
                                        previewContainer.style.display = 'block';
                                    };
                                    reader.readAsDataURL(file);
                                } else {
                                    previewImage.src = '';
                                    previewContainer.style.display = 'none';
                                }
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td width="20%">Parent</td>
                    <td width="80%">
                        <select name="p_id" class="form-control">
                            <option value="">Unassigned</option>
                            <?php
                            $sql = "SELECT * FROM parent";
                            $resultParent = $conn->query($sql);
                            while($row = $resultParent->fetch_assoc()){
                                if($row['p_id'] == $result['p_id']){
                                    echo "<option value='".$row['p_id']."' selected>".$row['p_name']."</option>";
                                }else{
                                    echo "<option value='".$row['p_id']."'>".$row['p_name']."</option>";
                                }
                            }
                            ?>
                    </td>
                </tr>
                <tr>
                    <td width="20%">Classroom</td>
                    <td width="80%">
                        <select name="c_id" class="form-control">
                            <option value="">Unassigned</option>
                            <?php
                            $sql = "SELECT * FROM classroom";
                            $resultClassroom = $conn->query($sql);
                            while($row = $resultClassroom->fetch_assoc()){
                                if($row['c_id'] == $result['c_id']){
                                    echo "<option value='".$row['c_id']."' selected>".$row['c_name']."</option>";
                                }else{
                                    echo "<option value='".$row['c_id']."'>".$row['c_name']."</option>";
                                }
                            }
                            ?>
                    </td>
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