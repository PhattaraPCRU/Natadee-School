<?php
include('../../php/utility_loader.php');

if (isset($_POST['c_id']) && $_POST['c_id'] != ""){
    $c_id = $_POST['c_id'];
    $sql = "SELECT s.s_id, s.s_name, s.s_pic, s.c_id, c.c_name FROM student AS s JOIN classroom AS c ON s.c_id = c.c_id WHERE s.c_id = '$c_id'";
}else{
    $sql = "SELECT s.s_id, s.s_name, s.s_pic, s.c_id, c.c_name FROM student AS s JOIN classroom AS c ON s.c_id = c.c_id";
}
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo '<script>
                window.onload = function() {
                    swal_callback("Infomation", "There is no student in this classroom.", "info", "OK", function(confirmed) {
                        if (confirmed) {
                            window.location.href = "../student/";
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
        <th width="80%" colspan="2" align="center">Student infomation</th>
        <form action="" method="post">
        <td width="15%" align="center" style="border-right: none;">
            <select name="c_id" class="form-control me-2">
                <option value="">All</option>
                <?php
                $class_sql = "SELECT * FROM classroom";
                $class_result = $conn->query($class_sql);
                while ($class = mysqli_fetch_array($class_result)) {
                    echo "<option value='$class[c_id]'>$class[c_name]</option>";
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
        <td width="40%"><b>Student Name</b></td>
        <td width="40%"><b>Classroom</b></td>
        <td width="20%" align="center" colspan="2"><b>Manage</b></td>
      </tr>
      <?php
      while ($rs = mysqli_fetch_array($result)) {
      ?>
      <tr>
        <td>
          <?php echo "$rs[s_name]"; ?>
        </td>
        <td>
          <?php echo "$rs[c_name]"; ?>
        </td>
        <td align="center"  colspan="2">
          <button class="btn btn-orange" onclick="window.location.href='/student/detail/guest/?s_id=<?php echo $rs['s_id']; ?>'">View detail</button>
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