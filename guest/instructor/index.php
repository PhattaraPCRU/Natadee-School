<?php
include('../../php/utility_loader.php');

if (isset($_POST['d_id']) && $_POST['d_id'] != ""){
    $d_id = $_POST['d_id'];
    $sql = "SELECT i.i_id, i.i_name, i.i_address, i.i_tel, i.i_pic, i.po_id, i.d_id, i.i_username, i.i_password, d.d_name FROM instructor AS i JOIN department AS d ON i.d_id = d.d_id WHERE i.d_id = '$d_id'";
}else{
    $sql = "SELECT i.i_id, i.i_name, i.i_address, i.i_tel, i.i_pic, i.po_id, i.d_id, i.i_username, i.i_password, d.d_name FROM instructor AS i JOIN department AS d ON i.d_id = d.d_id";
}
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo '<script>
                window.onload = function() {
                    swal_callback("Infomation", "There is no instructor in this department.", "info", "OK", function(confirmed) {
                        if (confirmed) {
                            window.location.href = "../instructor/";
                        }
                    });
                    var tableContent = document.getElementById("table_content");
                    if (tableContent) {
                        tableContent.parentNode.removeChild(tableContent);
                    }
                };
            </script>';
}

?>
<html>
<head>
  <title>Natadee-School</title>
</head>
<body>
<div class="footer-wrapper">
  <?php include_once '../../php/nav_loader.php'; ?>
  <div class="footer-content" align="center">
    <!-- Content Here -->
    <table border="1" id="table_content">
      <tbody>
      <tr>
        <th width="80%" colspan="2" align="center">Instructors infomation</th>
        <form action="" method="post">
        <td width="15%" align="center" style="border-right: none;">
            <select name="d_id" class="form-control me-2">
                <option value="">All</option>
                <?php
                $dept_sql = "SELECT * FROM department";
                $dept_result = $conn->query($dept_sql);
                while ($dept = mysqli_fetch_array($dept_result)) {
                    echo "<option value='$dept[d_id]'>$dept[d_name]</option>";
                }
                ?>
            </select>
        </td>
        <td width="5%" style="border-left: none;">
            <button class="btn btn-orange me-1" type="submit">Search</button>
        </td>
        </form>
      </tr>
      <tr class="column">
        <td width="40%"><b>Instructor Name</b></td>
        <td width="40%"><b>Department</b></td>
        <td width="20%" align="center" colspan="2"><b>Manage</b></td>
      </tr>
      <?php
      while ($rs = mysqli_fetch_array($result)) {
      ?>
      <tr>
        <td>
          <?php echo "$rs[i_name]"; ?>
        </td>
        <td>
          <?php echo "$rs[d_name]"; ?>
        </td>
        <td align="center"  colspan="2">
          <button class="btn btn-orange" onclick="window.location.href='/instructor/detail/guest/?i_id=<?php echo $rs['i_id']; ?>'">View detail</button>
        </td>
      </tr>
      <?php
      }
      ?>
      </tbody>
    </table>
  </div>
  <?PHP include_once '../../php/footer_loader.php'; ?>
</div>
<?php include_once '../../php/post_loader.php'; ?>
</body>
</html>