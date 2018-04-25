<?php
//Exportar datos de php a Excel
REQUIRE("conexion.php");
if (isset($_POST["all_users"])) {
  $sql = "SELECT user_.user_name, user_.user_surname, user_.user_email, user_.user_company, user_birthdate FROM user_";
  $result = mysqli_query($conn, $sql);
  $event_name = "Registro de usarios en eventos - Arkano";
  $title = "Personas que asistieron a los eventos";
}else {
  $event_id = $_POST["event_id"];
  $sqlName = "SELECT events_name FROM events_ WHERE events_id = $event_id";
  $resultName = mysqli_query($conn, $sqlName);
  if ($resultName) {
    while ($row_name = mysqli_fetch_array($resultName)) {
      $event_name = "Evento " . $row_name["events_name"];
      $title = $event_name;
    }
  }else {
    $event_name = "Error";
    $title = "Error";
  }

  $sql = "SELECT user_.user_name, user_.user_surname, user_.user_email, user_.user_company, events_name FROM user_event INNER JOIN user_ ON user_.user_email = user_event.user_email INNER JOIN events_ ON events_.events_id = user_event.events_id WHERE events_.events_id=$event_id";
  $result = mysqli_query($conn, $sql);
}

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=$event_name.xls");

?>
<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <title>Descargando Excel</title>
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

    <h2><?=$title . " - Arkano";?></h2>

    <table>
      <tr>
        <th><b>Nombre</b></td>
        <th><b>Mail</b></td>
        <th><b>Empresa</b></td>
        <th><b>Evento al que asistió</b></td>
      </tr>
        <?php
        while ($row = mysqli_fetch_array($result)) {
        ?>
          <tr>
            <td><?= $row["user_name"] . " " . $row["user_surname"];?></td>
            <td><?= $row["user_email"];?></td>
            <td><?= $row["user_company"];?></td>
            <?php
            if (!isset($_POST["all_users"])) {
            ?>
            <td><?= $row["events_name"];?></td>
            <?php
            }else {
            ?>
            <td><?= $row["user_birthdate"];?></td>
            <?php
            }
            ?>
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
