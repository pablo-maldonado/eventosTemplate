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
    $sql = "SELECT user_.user_name, user_.user_surname, user_.user_email, user_.user_company, events_name FROM user_event INNER JOIN user_ ON user_.user_email = user_event.user_email INNER JOIN events_ ON events_.events_id = user_event.events_id";
    $result = mysqli_query($conn, $sql);
    ?>
    <table border=1 align="center" cellpadding=1 cellspacing=1>
      <tr style="text-align: center;">
        Personas registradas en eventos
      </tr>
      <tr>
        <td>Nombre y Apellido</td>
        <td>Mail</td>
        <td>Empresa</td>
        <td>Evento al que asistió</td>
      </tr>
        <?php
        while ($row = mysqli_fetch_array($result)) {
        ?>
          <tr>
            <td><?= $row["user_name"] . " " . $row["events_surname"];?></td>
            <td><?= $row["user_email"];?></td>
            <td><?= $row["user_company"];?></td>
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
