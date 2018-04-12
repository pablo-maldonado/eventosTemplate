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
    <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap cdn -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <!-- Fontawesome cdn -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

    <!-- Jquery cdn -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- SweetAlert cdn -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>

    <!-- Link to js (message) -->
    <script src="js/message.js"></script>

    <script src="js/stylesJS.js"></script>

    <script type="text/javascript">
      //On click run the script to generate message
      $(document).on('click', '#btnRegister', register_event);
      $(document).on('click', '.btnDelete', delete_event);
      $(document).on('click', '.imgTxtCard', slideBodyCard);
      $(document).on('click', 'body', function(e){
        if (e.target.nodeName == "BODY"){
          $(".bodyCard").slideUp(520);
        }
        }
      );

      $(document).on('click', '#alertTest', swal);

    </script>

    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>

    <!-- <form action="busqueda.php" method="post">
      <input type="text" name="busqueda" placeholder="Ingrese nombre de persona a buscar">
      <button type="submit">Buscar</button>
    </form> -->
    <h1 class="text-center">Eventos - Arkano</h1>
    <!-- From to register events -->
    <form class="w3-container" id="formRegister" method="post" action="modals/registerEvent.php">
      <label>Nombre</label>
      <input class="w3-input" id="event_name" name="event_name" type="text">
      <input class="w3-input" id="event_coso" name="event_coso" type="text">
      <button type="submit" class="w3-btn w3-blue" id="btnRegister">Registrar</button>
      <span class="message" id="message" ></span>
    </form>

    <button id="alertTest" type="button" name="button">Alert?</button>

    <!-- Card template -->
      <div class="container">
        <div class="row">
            <?php
            while ($row = mysqli_fetch_array($result)) {
              ?>
        			<div class="card d-inline-block col-xs-10 col-sm-6 col-md-4 mb-5" id="card-<?= $row["events_id"];?>">
                <div class="imgTxtCard" id="imgTxtCard-<?= $row["events_id"];?>">
                  <img class="card-img-top" src="https://images.pexels.com/photos/67636/rose-blue-flower-rose-blooms-67636.jpeg?auto=compress&cs=tinysrgb&h=350" alt="Card image cap">
          			  <div class="card-body">
          			    <h5 class="card-title"><?= $row["events_name"];?></h5>
          			    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content. (Descripción del evento)</p>
          			  </div>
                </div>
        			  <ul class="list-group list-group-flush">
        			    <li class="list-group-item"><i class="far fa-calendar-alt"></i> Fecha del Evento</li>
        			    <li class="list-group-item"><i class="fas fa-user"></i> Cantidad de personas que asisitieron</li>
        			    <li class="list-group-item"><i class="fas fa-map-marker-alt"></i> Lugar de realización</li>
        			  </ul>
                <div class="bodyCard" id="bodyCard-<?= $row["events_id"];?>">
                  <div class="card-body">
                    <button type="button" class="btn btn-success float-right float-bottom ml-4 mb-4"><i class="fas fa-file-excel"></i> Excel</i></button>

                    <form class="w3-container formDelete" id="formDelete-<?= $row["events_id"];?>" method="post" action="modals/deleteEvent.php">
                      <input type="hidden" name="events_id" value="<?= $row["events_id"];?>">
                      <button type="submit" id="btnDelete-<?= $row["events_id"];?>" class="btn btn-danger float-right float-bottom mb-3 btnDelete"><i class="fas fa-trash-alt"></i> Borrar evento</button>
                    </form>

                  </div>
                </div>
        	    </div>
              <?php
              };
              ?>
        </div>
      </div>

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
          <form action="modals/user.php" method="post">
            <input type="hidden" name="events_id" value="<?= $row["events_id"];?>" />
            <td>
              <button type="submit"><?= $row["events_name"];?></button>
            </td>
          </form>
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
