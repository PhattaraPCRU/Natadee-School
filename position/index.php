<?php
$page_permission = 2;
include('../php/utility_loader.php');

$result = mysqli_execute_query($conn ,"SELECT * FROM position");
mysqli_close($conn);
?>
<html>
    <head>
        <title>Position</title>
    </head>
    <body>
    <div class="footer-wrapper">
        <?php include_once '../php/nav_loader.php'; ?>
        <div class="footer-content" align="center">
            <!-- Content Here -->
        <table width="80%" border="1" id="table_content">
          <tbody>
            <tr>
              <th width="90%" colspan="2" align="center">List of Position</th>
			  		  <td width="10%" align="center"><button class="btn btn-orange ajax-add-btn" colname="po_name">Add Position</button></td>
            </tr>
            <tr class="column">
              <td width="10%">Position ID</td>
              <td width="45%">Position Name</td>
              <td width="10%" align="center">Manage</td>
            </tr>
            <?php
            while ($rs = mysqli_fetch_array($result)) {
            ?>
            <tr class="<?php echo "id_$rs[po_id]" ?>">
              <td><?php echo "$rs[po_id]";?></td>
              <td class="name" colname="po_name"><?php echo "$rs[po_name]";?></td>
              <td align="center">
                <button class="btn btn-orange me-1 ajax-edit-btn" data-id="<?php echo $rs['po_id']; ?>">Edit</button>
                <button class="btn btn-delete ajax-delete-btn" data-id="<?php echo $rs['po_id']; ?>">Delete</button>
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