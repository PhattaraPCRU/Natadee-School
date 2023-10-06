<?php
$page_permission = 2;
include('../../php/utility_loader.php');

$sql = "SELECT * FROM parent";
$result = mysqli_execute_query($conn ,$sql) or die(mysqli_error($conn));
?>
<html>
    <head>
        <title>Parent List</title>
    </head>
    <body>
    <div class="footer-wrapper">
        <?php include_once '../../php/nav_loader.php'; ?>
        <div class="footer-content" align="center">
            <!-- Content Here -->
        <table width="80%" border="1" id="table_content">
          <tbody>
            <tr>
              <th width="80%" colspan="4" align="center">List of Students</th>
			  <td width="20%" align="center">
          <button class="btn btn-orange" onclick="window.location.href='add/'" style="width: 40%">New</button>
        </td>
            </tr>
            <tr class="column">
              <td width="10%"><b>ID</b></td>
              <td width="30%"><b>Name</b></td>
              <td width="20%"><b>Job</b></td>
              <td width="20%"><b>Tel</b></td>
              <td width="20%" align="center"><b>Manage</b></td>
            <?php
            while ($rs = mysqli_fetch_array($result)) {
            ?>
            <tr class="<?php echo "id_$rs[p_id]" ?>">
                <td>
                    <?php echo "$rs[p_id]"; ?>
                </td>
                <td>
                    <?php echo "$rs[p_name]"; ?>
                </td>
                <td>
                    <?php echo "$rs[p_job]"; ?>
                </td>
                <td>
                    <?php echo "$rs[p_tel]"; ?>
                </td>
              <td align="center">
                <button class="btn btn-orange me-1" onclick="window.location.href='edit/?p_id=<?php echo $rs['p_id']; ?>'">Edit</button>
                <button class="btn btn-delete" onclick="window.location.href='delete/?p_id=<?php echo $rs['p_id']; ?>'">Delete</button>
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