<?php
$page_permission = 2;
include('../php/utility_loader.php');

$result = mysqli_execute_query($conn ,"SELECT * FROM department");
?>
<html>
    <head>
        <title>Department</title>
    </head>
    <body>
    <div class="footer-wrapper">
        <?php include_once '../php/nav_loader.php'; ?>
        <div class="footer-content" align="center">
            <!-- Content Here -->
            <table width="80%" border="1" id="table_content">
            <tbody>
            <tr>
              <th width="80%" colspan="3" align="center">List of Departments</th>
			  		  <td width="20%" align="center"><button class="btn btn-orange ajax-add-btn" colname="d_name">Add Department</button></td>
            </tr>
            <tr class="column">
              <td width="10%">Department ID</td>
              <td width="35%">Department Name</td>
              <td width="35%">Head of Department</td>
              <td width="20%" align="center">Manage</td>
            </tr>
            <?php
            while ($rs = mysqli_fetch_array($result)) {
            ?>
            <tr class="<?php echo "id_$rs[d_id]" ?>">
              <td><?php echo "$rs[d_id]";?></td>
              <td class="name" colname="d_name"><?php echo "$rs[d_name]";?></td>
              <td>
                <?php
                if ($rs['i_id'] == null) {
                  echo "<font color='#FF9933'>No Head of Department Assigned.</font>";
                } else {
                  $result1 = mysqli_execute_query($conn ,"SELECT * FROM instructor WHERE i_id = '$rs[i_id]'");
                  $result1 = mysqli_fetch_array($result1);
                  echo "$result1[i_name]";
                }
                ?>
              </td>
              <td align="center">
                <button class="btn btn-orange me-1" onclick="window.location.href = 'head/?d_id=<?php echo $rs['d_id']; ?>'">Assign</button>
                <button class="btn btn-orange me-1 ajax-edit-btn" data-id="<?php echo $rs['d_id']; ?>">Edit</button>
                <button class="btn btn-delete ajax-delete-btn" data-id="<?php echo $rs['d_id']; ?>">Delete</button>
              </td>
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>            
        </div>
        <!-- <script>
            $(document).ready( function () {
                $('#table_content').DataTable(); 
            } );
        </script> -->
        <?PHP include_once '../php/footer_loader.php'; ?>
    </div>
    <?php include_once '../php/post_loader.php'; ?>
    </body>
</html>