<?php
include('../../php/utility_loader.php');
?>
<html>
    <head>
        <title>Add Student</title>
    </head>
    <body>
    <div class="footer-wrapper">
        <?php include_once '../../php/nav_loader.php'; ?>
        <div class="footer-content" align="center">
            <!-- Content Here -->
        <table style="width: 40%;" border="1" id="table_content">
            <tr>
                <th colspan="2" align="center">Add Student</th>
            </tr>
            <form action="../../php/sql/sql_student.php"><input type="hidden" name="operation" value="add">
                <tr>
                    <td width="20%">Name</td>
                    <td width="80%"><input class="form-control" type="text" name="s_name" value=""></td>
                </tr>
                <tr>
                    <td width="20%">Address</td>
                    <td width="80%"><textarea class="form-control" name="s_address"></textarea></td>
                </tr>
                <tr>
                    <td width="20%">Tel</td>
                    <td width="80%"><input class="form-control" type="tel" name="s_tel" value=""></td>
                </tr>
                <tr>
                    <td width="20%">Image</td>
                    <td width="80%">
                        <div id="previewContainer" style="display: block;">
                            <img id="previewImage" src="" height="180px">
                        </div>
                        <input id="fileInput" class="form-control" type="file" name="s_pic" accept="image/png, image/jpeg, image/jpg, image/gif">
                        <script>
                            document.getElementById('previewImage').src = '../../res/img/No_Image_Available.jpg';
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
                            $sql1 = "SELECT * FROM parent";
                            $result1 = $conn->query($sql1);
                            while($row = $result1->fetch_assoc()){
                                echo "<option value='".$row['p_id']."'>".$row['p_name']."</option>";
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
                            $sql2 = "SELECT * FROM classroom";
                            $result2 = $conn->query($sql2);
                            while($row = $result2->fetch_assoc()){
                                echo "<option value='".$row['c_id']."'>".$row['c_name']."</option>";
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