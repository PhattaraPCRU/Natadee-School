<?php
$page_permission = 2;
include('../php/utility_loader.php');

$sql = "SELECT * FROM student";
$result = mysqli_execute_query($conn ,$sql) or die(mysqli_error($conn));
?>
<html>
<head>
  <title>Students List</title>
</head>
<body>
<div class="footer-wrapper">
  <?php include_once '../php/nav_loader.php'; ?>
  <div class="footer-content" align="center">
    <!-- Content Here -->
    <table width="80%" border="1" id="table_content">
      <tbody>
      <tr>
        <th width="80%" colspan="3" align="center">List of Students</th>
        <td width="20%" align="center">
          <button class="btn btn-orange me-1" onclick="window.location.href='add/'" style="width: auto">New</button>
          <button class="btn btn-orange" onclick="window.location.href='parent/'" style="width: auto">Parents</button>
        </td>
      </tr>
      <tr class="column">
        <td width="10%"><b>Student ID</b></td>
        <td width="35%"><b>Student Name</b></td>
        <td width="35%"><b>Student Class</b></td>
        <td width="20%" align="center"><b>Manage</b></td>
      </tr>
      <?php
      while ($rs = mysqli_fetch_array($result)) {
      ?>
      <tr class="<?php echo "id_$rs[s_id]" ?>">
        <td>
          <?php echo "$rs[s_id]"; ?>
        </td>
        <td>
          <?php echo "$rs[s_name]"; ?>
        </td>
        <td>
          <?php
          if ($rs['c_id'] == NULL){
            echo "<font color='red'>No Class Assigned</font>";
          }else{
            $sql = "SELECT * FROM classroom WHERE c_id = '$rs[c_id]'";
            $result2 = mysqli_execute_query($conn ,$sql);
            $rs2 = mysqli_fetch_array($result2);
            echo "$rs2[c_name]";
          }
          ?>
        </td>
        <td align="center">
          <button class="btn btn-orange me-1" onclick="window.location.href='detail/?s_id=<?php echo $rs['s_id']; ?>'">Detail</button>
          <button class="btn btn-orange me-1" onclick="window.location.href='edit/?s_id=<?php echo $rs['s_id']; ?>'">Edit</button>
          <button class="btn btn-delete" onclick="window.location.href='delete/?s_id=<?php echo $rs['s_id']; ?>'">Delete</button>
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