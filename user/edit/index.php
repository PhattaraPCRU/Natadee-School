<?php
include('../../php/utility_loader.php');
session_start();
if(!isset($_SESSION["valid_uname"]) || !isset($_SESSION["valid_pwd"]) || !isset($_SESSION["valid_instructor"])){
    echo "<script> swal_callback('Error', 'Please Login', 'error', 'OK', function() { window.location.href = '../../'; });</script>";
    exit();
}else{
    $sql = "SELECT * FROM instructor WHERE i_username='".$_SESSION["valid_uname"]."' AND i_password='".$_SESSION["valid_pwd"]."'";
    $result = $conn->query($sql);
    $result = $result->fetch_assoc();

}
?>
<html>
    <head>
        <title>Edit Infomation</title>
    </head>
    <body>
    <div class="footer-wrapper">
        <?php include_once '../../php/nav_loader.php'; ?>
        <div class="footer-content" align="center">
            <!-- Content Here -->
        <table style="width: 40%;" border="1" id="table_content">
            <tr>
                <th colspan="2" align="center">Edit Infomation</th>
            </tr>
            <form action="../../php/sql/edit_instructor.php"><input type="hidden" name="i_id" value="<?php echo $result['i_id']; ?>">
                <tr>
                    <td width="20%">Image</td>
                    <td width="80%">
                        <div id="previewContainer" style="display: block;">
                            <img id="previewImage" src="../../res/upload/<?php echo $result['i_pic']; ?>" height="180px">
                        </div>
                        <input id="fileInput" class="form-control" type="file" name="i_pic" accept="image/png, image/jpeg, image/jpg, image/gif">
                        <script>
                            <?PHP
                            if($result['i_pic'] == ""){
                                echo "document.getElementById('previewImage').src = '../../res/img/No_Image_Available.jpg';";
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
                    <td width="20%">Username</td>
                    <td width="80%"><input class="form-control" type="text" name="i_username" value="<?php echo $result['i_username']; ?>" readonly></td>
                </tr>
                <tr>
                    <td width="20%">Password</td>
                    <td width="80%"><input class="form-control" type="text" name="i_password" value="<?php echo $result['i_password']; ?>"></td>
                </tr>
                <tr>
                    <td width="20%">Name</td>
                    <td width="80%"><input class="form-control" type="text" name="i_name" value="<?php echo $result['i_name']; ?>"></td>
                </tr>
                <tr>
                    <td width="20%">Address</td>
                    <td width="80%"><textarea class="form-control" name="i_address"><?php echo $result['i_address']; ?></textarea></td>
                </tr>
                <tr>
                    <td width="20%">Tel</td>
                    <td width="80%"><input class="form-control" type="text" name="i_tel" value="<?php echo $result['i_tel']; ?>"></td>
                </tr>
                <tr>
                    <td width="20%">Position</td>
                    <td width="80%">
                        <select name="po_id" class="form-control">
                            <?php
                            $sql = "SELECT * FROM position";
                            $resultPosition = $conn->query($sql);
                            while($row = $resultPosition->fetch_assoc()){
                                if($row['po_id'] == $result['po_id']){
                                    echo "<option value='".$row['po_id']."' selected>".$row['po_name']."</option>";
                                }else{
                                    echo "<option value='".$row['po_id']."'>".$row['po_name']."</option>";
                                }
                            }
                            ?>
                    </td>
                </tr>
                <tr>
                    <td width="20%">Department</td>
                    <td width="80%">
                        <select name="d_id" class="form-control">
                            <?php
                            $sql = "SELECT * FROM department";
                            $resultDepartment = $conn->query($sql);
                            while($row = $resultDepartment->fetch_assoc()){
                                if($row['d_id'] == $result['d_id']){
                                    echo "<option value='".$row['d_id']."' selected>".$row['d_name']."</option>";
                                }else{
                                    echo "<option value='".$row['d_id']."'>".$row['d_name']."</option>";
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
                            const submitButton = document.querySelector('button[type="submit"]');
                            
                            submitButton.addEventListener('click', function(e) {
                                e.preventDefault();
                                const form = document.querySelector('form');
                                const formData = new FormData(form);
                                const xhr = new XMLHttpRequest();
                                xhr.open('POST', form.action, true);
                                xhr.onload = function() {
                                    if (xhr.status === 200) {
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