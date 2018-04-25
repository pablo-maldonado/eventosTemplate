<?php
//Connect the database
REQUIRE("modals/conexion.php");
header("Content-Type: text/html;charset=utf-8");
//Prepare the consult
$sql = "SELECT events_id, events_name, events_description, date_format (events_date,'%d-%m-%Y'), events_addres, events_photo from events_ ORDER BY events_id DESC";
$qntPerson = 0;
//Execute the consult
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Eventos - Arkano</title>

    <!-- Meta to inform Chrome about language page -->
    <meta http-equiv="Content-Language" content="es">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap cdn -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <!-- Fontawesome cdn -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

    <!-- AJAX/Jquery cdn -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- BootstrapJS cdn -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

    <!-- SweetAlert cdn -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

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
        $(document).on('dblclick', '.imgTxtCard', function(e){
        alert( "Hello World!" );
      });

    </script>

    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>

    <h1 class="text-center">Eventos - Arkano</h1>
    <button onclick="notifyMe()">Notify me!</button>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add_event">
    Add Event
    </button>
    <form class="" action="modals/toExcel.php" method="post">
      <input type="hidden" name="all_users" value="1">
      <button type="submit" id='download_users' class="btn btn-success"><i class="fas fa-file-excel"></i> Download all users</button>
    </form>

    <!-- Card template -->
    <div class="container">
      <div class="row">
          <?php
          while ($row = mysqli_fetch_array($result)) {
            ?>
      			<div class="card d-inline-block col-xs-10 col-sm-6 col-md-4 mb-5" id="card-<?= $row["events_id"];?>">
              <div class="imgTxtCard" id="imgTxtCard-<?= $row["events_id"];?>">
                <img class="card-img-top" src="<?=$row["events_photo"];?>" alt="Error al cargar la foto :(">
        			  <div class="card-body">
        			    <h5 class="card-title"><?= $row["events_name"];?></h5>
        			    <p class="card-text"><?= $row["events_description"];?></p>
        			  </div>
              </div>
      			  <ul class="list-group list-group-flush">
      			    <li class="list-group-item"><i class="far fa-calendar-alt mr-1"></i><?= $row["date_format (events_date,'%d-%m-%Y')"];?></li>
                <?php
                  // $row_personQnt = 0
                  $events_id = $row['events_id'];
                  $sqlQnt = "SELECT COUNT(user_email) FROM user_event WHERE events_id = $events_id";
                  $resultQnt = mysqli_query($conn, $sqlQnt);
                  $row_personQnt = $resultQnt->num_rows;
                  while ($rowQnt = mysqli_fetch_array($resultQnt)) {
                        $qntPerson = $rowQnt[0];
                  }
                ?>
      			    <li class="list-group-item"><i class="fas fa-user"></i> <?=$qntPerson ?> personas asisitieron al evento</li>
      			    <li class="list-group-item"><i class="fas fa-map-marker-alt mr-1"></i> <?=$row["events_addres"]?></li>
      			  </ul>
              <div class="bodyCard" id="bodyCard-<?= $row["events_id"];?>">
                <div class="card-body">
                  <form class="w3-container formDelete" id="formGoEvent-<?= $row["events_id"];?>" method="post" action="modals/user.php">
                    <input type="hidden" name="events_id" value="<?= $row["events_id"];?>">
                    <button type="submit" class="btn btn-primary ml-4 float-right float-bottom mb-3"><i class="fas fa-arrow-right"></i></button>
                  </form>
                  <form class="" action="modals/toExcel.php" method="post">
                    <input type="hidden" name="event_id" value="<?= $row["events_id"]?>">
                    <button type="submit" class="btn btn-success float-right float-bottom ml-4 mb-4"><i class="fas fa-file-excel"></i> Excel</button>
                  </form>
                  <form class="w3-container formDelete" id="formDelete-<?= $row["events_id"];?>" method="post" action="modals/deleteEvent.php">
                    <input type="hidden" name="events_id" value="<?= $row["events_id"];?>">
                    <input type="hidden" name="force_event" value="0">
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

    <!-- The Modal -->
    <div class="modal fade" id="modal_add_event">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Nuevo evento!!! &#x1F389</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <form class="w3-container" id="formRegister" method="post" action="modals/registerEvent.php">
              <div class="form-group">
                <label for="lbl_name">Nombre</label>
                <input class="form-control" id="event_name" name="event_name" type="text" placeholder="Ej: Smart Talent">
              </div>
              <div class="form-group">
                <label for="lbl_description">Descripción</label>
                <input class="form-control" id="event_description" name="event_description" type="text" placeholder="Ej: Smart Talent es una iniciativa de Uruguay XXI a través del Programa de Apoyo...">
              </div>
              <div class="form-group">
                <label for="lbl_date">Fecha</label>
                <input class="form-control" id="event_date" name="event_date" type="date">
              </div>
              <div class="form-group">
                <label for="lbl_addres">Dirección</label>
                <!-- <div id="googleMap" style="width:100%;height:400px;"></div> -->
                <input class="form-control" id="event_addres" name="event_addres" type="text" placeholder="Address">
              </div>
              <div class="form-group">
                <label for="lbl_photo">Foto de portada</label>
                <input class="form-control" id="event_photo" name="event_photo" type="text" placeholder="Aquí debe ingresar el link de la imagen">
              </div>
              <div class="form-group">
                <span class="message" id="message"></span>
              </div>
              <div class="button_padding_border">
                <button type="button" class="btn btn-danger float-right ml-3" data-dismiss="modal">Cancelar</button>
              </div>
              <button type="submit" class="btn btn-success float-right" id="btnRegister">Registrar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
