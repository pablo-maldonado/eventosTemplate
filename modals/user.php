<?php
  REQUIRE("conexion.php");

  $events_id=$_POST['events_id'];


 ?>

<!DOCTYPE html>
<html>
  <head>
  <title>Registro Arkano</title>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="../css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>
  <script src="../js/message.js"></script>

  <script src="../js/stylesJS.js"></script>

  <script type="text/javascript">
  	$(document).ready(function(){
  		$('#btnRegistro').on('click', registrar);
  	});

  	function registrar(e){
  		e.preventDefault();
  		var action =  $(this).parent().attr('action');
  		$.ajax({
  			url: action,
  			method: 'POST',
  			data: $('#formRegistro').serialize(),
  			dataType: "json",
  			success: function(response){
				$('#message').html(response.message);

				if (response.status) {
					$('form input').val('');
          $('#events_id').val(response.events_id);
  				}


        }

  			},

  			error: function (response){
  				console.log(response);
  			}

  		});
  	}
  </script>

  </head>
  <body style="background-image:url(../img/arkano_fondo_chiquito.png)">




      <div class="w3-content" style="max-width: 750px;margin-top: 90px;">

        <form class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin" id="formRegistro" method="post" action="registro.php" >
      <h2 class="w3-center">Registro Arkano</h2>

        <div class="w3-row w3-section">
          <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
          <div class="w3-rest">
            <input class="w3-input w3-border" name="nombre" type="text" placeholder="Nombre">
          </div>
        </div>

        <div class="w3-row w3-section">
          <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
            <div class="w3-rest">
              <input class="w3-input w3-border" name="apellido" type="text" placeholder="Apellido">
            </div>
        </div>

        <div class="w3-row w3-section">
          <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope-o"></i></div>
          <div class="w3-rest">
            <input class="w3-input w3-border" name="email" type="email" placeholder="Email">
          </div>
        </div>

        <div class="w3-row w3-section">
          <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-building"></i></div>
          <div class="w3-rest">
            <input class="w3-input w3-border" name="empresa" type="text" placeholder="Empresa"></p>
          </div>
        </div>

      <p>
      <label style="padding-bottm:5px;">Fecha de nacimiento</label>
      <input class="w3-input w3-border" name="birthdate" type="date" value="2000-01-01" max="2017-12-31"></p>
      <input id="events_id" type="text" name="events_id" value="<?= ["events_id"];?>">

      <button type="submit" class="w3-btn w3-block w3-section w3-blue w3-ripple w3-padding" id="btnRegistro" style="margin-bottom : 5px;">Registrar</button>

      <span class="message" id="message"></span>
    </form>


  <img src="../img/logoArkanoBlanco.png" style="max-width: 20%;  height: auto;  position: absolute;    bottom: 8px;    left: 16px; z-index:-1 ;">

</div>
  </body>
</html>
