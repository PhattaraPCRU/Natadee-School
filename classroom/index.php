<?php
include('../php/utility_loader.php');

$sql = "SELECT * FROM classroom";
$result = mysqli_execute_query($conn ,$sql);

?>
<html>
    <head>
        <title>Classroom</title>
    </head>
    <body>
    <div class="footer-wrapper">
        <?php include_once '../php/nav_loader.php'; ?>
        <div class="footer-content" align="center">
            <!-- Content Here -->
        <table width="80%" border="1" id="table_content">
          <tbody>
            <tr>
              <th width="75%" colspan="4" align="center">List of Classroom</th>
			        <td width="25%" align="center"><button class="btn btn-orange" onclick="window.location.href='add/'">Add Classroom</button></td>
            </tr>
            <tr class="column">
              <td width="9%"><b>Class ID</b></td>
              <td width="20%"><b>Class Name</b></td>
              <td width="23%"><b>Class Leader</b></td>
              <td width="23%"><b>Class Teacher</b></td>
              <td width="25%" align="center"><b>Manage</b></td>
            </tr>
            <?php
            while ($rs = mysqli_fetch_array($result)) {
            ?>
            <tr class="<?php echo "id_$rs[c_id]" ?>">
                <td>
                    <?php echo "$rs[c_id]"; ?>
                </td>
                <td>
                    <?php echo "$rs[c_name]"; ?>
                </td>
                <td>
                  <?php
                  if ($rs['s_id'] == NULL){
                    echo "<font color='red'>No Class Leader</font>";
                  }else{
                    $sql = "SELECT * FROM student WHERE s_id = '$rs[s_id]'";
                    $result2 = mysqli_execute_query($conn ,$sql);
                    $rs2 = mysqli_fetch_array($result2);
                    echo "$rs2[s_name]";
                  }
                  ?>
                </td>
                <td>
                  <?php
                  if ($rs['i_id'] == NULL){
                    echo "<font color='red'>No Class Teacher</font>";
                  }else{
                    $sql = "SELECT * FROM instructor WHERE i_id = '$rs[i_id]'";
                    $result2 = mysqli_execute_query($conn ,$sql);
                    $rs2 = mysqli_fetch_array($result2);
                    echo "$rs2[i_name]";
                  }
                  ?>
                </td>
              <td align="center">
                <button class="btn btn-orange me-1" onclick="window.location.href='leader/?c_id=<?php echo $rs['c_id']; ?>'">Leader</button>
                <button class="btn btn-orange me-1" onclick="window.location.href='instructor/?c_id=<?php echo $rs['c_id']; ?>'">Instructor</button>
                <button class="btn btn-delete" onclick="window.location.href='delete/?c_id=<?php echo $rs['c_id']; ?>'">Delete</button>
              </td>
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
        </div>
        <?PHP include_once '../php/footer_loader.php'; ?>
    </div>
    <?php include_once '../php/post_loader.php'; ?>
    </body>
</html>