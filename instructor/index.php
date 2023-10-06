<?php
$page_permission = 2;
include('../php/utility_loader.php');

$result = mysqli_execute_query($conn ,"SELECT i.i_id, i.i_name, p.po_name, d.d_name, d.d_id, p.po_id FROM instructor AS i JOIN position AS p ON i.po_id = p.po_id JOIN department AS d ON i.d_id = d.d_id;");

$sql1 = "SELECT * FROM position";
$result1 = mysqli_query($conn, $sql1);
$positionOptions = array();
while ($rs1 = mysqli_fetch_array($result1)) {
    $positionOptions[] = array(
        'value' => $rs1['po_id'],
        'text' => $rs1['po_name']
    );
}

$sql2 = "SELECT * FROM department";
$result2 = mysqli_query($conn, $sql2);
$departmentOptions = array();
while ($rs2 = mysqli_fetch_array($result2)) {
    $departmentOptions[] = array(
        'value' => $rs2['d_id'],
        'text' => $rs2['d_name']
    );
}

mysqli_close($conn);

$jsonPositionOptions = json_encode($positionOptions);
$jsonDepartmentOptions = json_encode($departmentOptions);
?>
<html>
    <head>
        <title>Instructor</title>
    </head>
    <body>
    <div class="footer-wrapper">
        <?php include_once '../php/nav_loader.php'; ?>
        <div class="footer-content" align="center">
            <!-- Content Here -->
        <table width="80%" border="1" id="table_content">
          <tbody>
            <tr>
              <th width="90%" colspan="4" align="center">List of Instructor</th>
			  		  <td width="20%" align="center"><button class="btn btn-orange ajax-add-btn" colname="i_id" onclick="addInstructorBtn()">Add Instructor</button></td>
            </tr>
            <tr class="column">
              <td width="10%">Instructor ID</td>
              <td width="30%">Instructor Name</td>
              <td width="15%">Position</td>
              <td width="25%">Department</td>
              <td width="20%" align="center">Manage</td>
            </tr>
            <?php
            while ($rs = mysqli_fetch_array($result)) {
            ?>
            <tr class="<?php echo "id_$rs[i_id]" ?>">
              <td><?php echo "$rs[i_id]";?></td>
              <td class="name" colname="i_name"><?php echo "$rs[i_name]";?></td>
              <td colname="po_name" data-id="<?php echo $rs['po_id']; ?>"><?php echo "$rs[po_name]";?></td>
              <td colname="d_name" data-id="<?php echo $rs['d_id']; ?>"><?php echo "$rs[d_name]";?></td>
              <td align="center">
                <button class="btn btn-orange me-1" data-id="<?php echo $rs['i_id']; ?>" onclick="window.location.href = 'detail/?i_id=<?php echo $rs['i_id']; ?>'">View</button>
                <button class="btn btn-orange me-1 ajax-edit-btn" data-id="<?php echo $rs['i_id']; ?>" onclick="window.location.href = 'edit/?i_id=<?php echo $rs['i_id']; ?>'">Edit</button>
                <button class="btn btn-delete ajax-delete-btn" data-id="<?php echo $rs['i_id']; ?>">Delete</button>
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
    <!-- <script src="/js/ajax_delete.js"></script> -->
    <div id="scriptContainer">
      <script>
        function addInstructorBtn(){
          swal_add_instructor(<?php echo json_encode($departmentOptions); ?>, <?php echo json_encode($positionOptions); ?>, function(result, value) {
            if(result){
              handleAdd(value, "instructor");
            }});
        }
      </script>
    </div>
    <?php include_once '../php/post_loaderV2.php'; ?>
    </body>
</html>