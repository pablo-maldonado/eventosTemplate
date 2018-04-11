<?php
//Connect the database
REQUIRE("modals/conexion.php");

//Prepare the consult
$sql = "SELECT * FROM events_";

//Execute the consult
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Eventos - Arkano</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/message.js"></script>
    <script type="text/javascript">
      //On click run the script to generate message
      $(document).on('click', '#btnRegister', register_event);
      $(document).on('click', '.btnDelete', delete_event);
    </script>
  </head>
  <body>

    <form action="busqueda.php" method="post">
      <input type="text" name="busqueda" placeholder="Ingrese nombre de persona a buscar">
      <button type="submit">Buscar</button>
    </form>

    <form class="w3-container" id="formRegister" method="post" action="modals/registerEvent.php">
      <p>
      <label>Nombre</label>
      <input class="w3-input" id="event_name" name="event_name" type="text"></p>
      <button type="submit" class="w3-btn w3-blue" id="btnRegister">Registrar</button>
      <span class="message" id="message" ></span>
    </form>


    <table id="mainTable" border="1" cellpadding="10">
      <thead>
        <tr>
          <th>ID del Evento</th>
          <th>Nombre del evento</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($row = mysqli_fetch_array($result)) {
          ?>
        <tr id="tr-<?= $row["events_id"];?>">
          <td><?= $row["events_id"];?></td>
          <td><?= $row["events_name"];?></td>
          <td>
            <form class="w3-container formDelete" id="formDelete-<?= $row["events_id"];?>" method="post" action="modals/deleteEvent.php">
              <input type="hidden" name="events_id" value="<?= $row["events_id"];?>">
              <button type="submit" class="w3-btn w3-red btnDelete" id="btnDelete-<?= $row["events_id"];?>">Eliminar</button>
            </form>
          </td>
          <td>
            <form action="modificar.php" method="post">
              <input type="hidden" name="modify" value="<?= $fila['nombre'];?>">
              <input type="hidden" name="dato" value="<?= $fila['id'];?>">
              <button type="submit" name="button">Modificar</button>
            </form>
          </td>
        </tr>
        <?php
        };
        ?>
      </tbody>
    </table>
  </body>
</html>
