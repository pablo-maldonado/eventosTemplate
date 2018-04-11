<?php
  REQUIRE("conexion.php");
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
  				}
  			},
  			error: function (response){
  				console.log(response);
  			}

  		});
  	}
  </script>
  </head>
  <body>

    <div class="w3-content" style="max-width: 750px;margin-top: 90px;">
      <h2>Registro Arkano</h2>
    <form class="w3-container" id="formRegistro" method="post" action="registro.php" style="background-color: skyblue; border-left: 5px solid orange; border-bottom: 5px solid skyblue; padding-bottom: 5px">
      <p>
      <label>Nombre</label>
      <input class="w3-input" name="nombre" type="text"></p>
      <p>
      <label>Apellido</label>
      <input class="w3-input" name="apellido" type="text"></p>
      <p>
      <label>Email</label>
      <input class="w3-input" name="email" value="" type="email"></p>
      <p>
      <label>Empresa</label>
      <input class="w3-input" name="empresa" type="text"></p>
      <p>
      <label>Fecha de nacimiento</label>
      <input class="w3-input w3-padding-16" name="birthdate" type="date" value="2000-01-01"></p>

      <button type="submit" class="w3-btn w3-blue" id="btnRegistro">Registrar</button>
      <span class="message" id="message"></span>
    </form>
</div>


  </body>
</html>
