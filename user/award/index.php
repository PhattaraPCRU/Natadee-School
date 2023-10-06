<?php
$page_permission = 1;
include('../../php/utility_loader.php');

$sql = "SELECT * FROM award WHERE a_id IN (SELECT a_id FROM instructor_award WHERE i_id = (SELECT i_id FROM instructor WHERE i_username = '$_SESSION[username]'))";
$result = mysqli_execute_query($conn, $sql) or die(mysqli_error($conn));
?>
<html>
<head>
  <title>My Awards</title>
</head>
<body>
<div class="footer-wrapper">
  <?php include_once '../../php/nav_loader.php'; ?>
  <div class="footer-content" align="center">
    <!-- Content Here -->
    <table border="1" id="table_content">
      <tbody>
      <tr>
        <th width="80%" colspan="3" align="center"><?php echo $_SESSION["username"]; ?> Awards.</th>
        <td width="20%" align="center">
          <button class="btn btn-orange me-1" onclick="window.location.href='add/'" style="width: 40%">Add</button>
        </td>
      </tr>
      <tr class="column">
        <td width="10%"><b>Award Name</b></td>
        <td width="35%"><b>Year</b></td>
        <td width="35%"><b>From</b></td>
        <td width="20%" align="center"><b>Manage</b></td>
      </tr>
      <?php
      while ($rs = mysqli_fetch_array($result)) {
      ?>
      <tr>
        <td>
          <?php echo "$rs[a_name]"; ?>
        </td>
        <td>
          <?php echo "$rs[a_year]"; ?>
        </td>
        <td>
          <?php echo "$rs[a_org]"; ?>
        </td>
        <td align="center">
          <button class="btn btn-delete" onclick="window.location.href='delete/?a_id=<?php echo $rs['a_id']; ?>'">Delete</button>
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