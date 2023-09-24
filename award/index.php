<?php
include('../php/utility_loader.php');

$sql = "SELECT * FROM award";
$result = mysqli_execute_query($conn ,$sql);

?>
<html>
    <head>
        <title>Awards</title>
    </head>
    <body>
    <div class="footer-wrapper">
        <?php include_once '../php/nav_loader.php'; ?>
        <div class="footer-content" align="center">
            <!-- Content Here -->
        <table width="80%" border="1" id="table_content">
          <tbody>
            <tr>
              <th width="90%" colspan="3" align="center">List of Awards</th>
			  		  <td width="10%" align="center"><button class="btn btn-orange" onclick="window.location.href='add/'">Add Award</button></td>
            </tr>
            <tr class="column">
              <td width="35%"><b>Name</b></td>
              <td width="35%"><b>From</b></td>
              <td width="10%"><b>Year</b></td>
              <td width="20%" align="center"><b>Manage</b></td>
            </tr>
            <?php
            while ($rs = mysqli_fetch_array($result)) {
            ?>
            <tr class="<?php echo "id_$rs[a_id]" ?>">
              <td>
                <?php echo "$rs[a_name]";?>
              </td>
              <td>
                <?php echo "$rs[a_org]";?>
              </td>
              <td>
                <?php echo "$rs[a_year]";?>
              </td>
              <td align="center">
                <button class="btn btn-orange me-1" onclick="window.location.href='edit/?a_id=<?php echo $rs['a_id']; ?>'">Edit</button>
                <button class="btn btn-delete" onclick="window.location.href='delete/?a_id=<?php echo $rs['a_id']; ?>'">Delete</button>
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