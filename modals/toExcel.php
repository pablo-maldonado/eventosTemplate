<?php
//Exportar datos de php a Excel
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Reportes.xls");

REQUIRE("conexion.php");
?>
<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <title>To Excel</title>
    </head>
  <body>
    <?php
    $sql = "SELECT * FROM events_";
    $result = mysqli_query($conn, $sql);
    ?>
    <table border=1 align="center" cellpadding=1 cellspacing=1>
      <tr>
        <td>events_id</td>
        <td>events_name</td>
      </tr>
        <?php
        while ($row = mysqli_fetch_array($result)) {
        ?>
          <tr>
            <td><?= $row["events_id"];?></td>
            <td><?= $row["events_name"];?></td>
          </tr>
        <?php
        }
        mysqli_free_result($result);
        mysqli_close($conn);
        ?>
  </table>
</body>
</html>
