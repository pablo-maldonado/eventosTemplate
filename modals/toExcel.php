<?php
//Exportar datos de php a Excel
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Reportes.xls");

REQUIRE("conexion.php");
$event_id = $_POST["event_id"];

?>
<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <title>To Excel</title>
      <style>
      table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
      }

      td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
      }

      tr:nth-child(even) {
        background-color: #dddddd;
      }
      }
      </style>
    </head>
  <body>

    <?php
    $sql = "SELECT user_.user_name, user_.user_surname, user_.user_email, user_.user_company, events_name FROM user_event INNER JOIN user_ ON user_.user_email = user_event.user_email INNER JOIN events_ ON events_.events_id = user_event.events_id WHERE events_.events_id=$event_id";
    $result = mysqli_query($conn, $sql);
    ?>
    <h2>Personas registradas en eventos</h2>

    <table>
      <tr>
        <th>Nombre y Apellido</td>
        <th>Mail</td>
        <th>Empresa</td>
        <th>Evento al que asistió</td>
      </tr>
        <?php
        while ($row = mysqli_fetch_array($result)) {
        ?>
          <tr>
            <td><?= $row["user_name"] . " " . $row["user_surname"];?></td>
            <td><?= $row["user_email"];?></td>
            <td><?= $row["user_company"];?></td>
            <td><?= $row["events_name"];?></td>
          </tr>
        <?php
        }
        ?>
    </table>
        <?php
        mysqli_free_result($result);
        mysqli_close($conn);
        ?>
</body>
</html>
