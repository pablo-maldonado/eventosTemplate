function register_event(e){
    e.preventDefault();
    var action =  $(this).parent().attr('action');
    $.ajax({
      url: action,
      method: 'POST',
      data: $('#formRegister').serialize(),
      dataType: "json",
      success: function(response){
      $('#message').html(response.message);
      if (response.status) {
        // $('#myTable tr:last').after('<tr>...</tr><tr>...</tr>');
        var event_name = $('#event_name').val();
        var event_id = response.events_id;
        swal({
          position: 'top-end',
          type: 'success',
          title: 'Se registró el evento ' + event_name + ' correctamente',
          showConfirmButton: false,
          timer: 2000
        })

        $('#mainTable').append(
            '<tr id= tr-' + event_id + '>'+
              '<td>' + event_id +
              '<td>' + event_name + '</td>' +
              '<td>' +
                    '<form class="w3-container formDelete" id="formDelete-' + event_id + '" method="post" action="modals/deleteEvent.php">' +
                      '<input type="hidden" id="events_id" name="events_id" value="cosoReLoco">' +
                      '<button type="submit" class="w3-btn w3-red btnDelete" id="btnDelete-' + event_id + '">Eliminar</button>' +
                    '</form>' +
               '</td>' +
            '</tr>'
          );
        $('#event_name').val('');
        $("#formDelete-"+event_id).find('#events_id').val(event_id);
      }
      },
      error: function (response){
        console.log(response);
      }

    });
}

//Ejemplo sobre borrado de tupla de BBDD en PHP (?
function delete_event(e){
  // e.preventDefault lo que hace es frenar todo lo que se iba a hacer por defecto en la página
  // (en este caso iba a ir a la página "deleteEvent.php")
    e.preventDefault();
    //Pongo en la variable id los datos de la id que voy a borrar
    var id = $(this).attr('id').replace('btnDelete-', '');

    //Igaulo la variable form al formulario
    //DATO IMPORTANTE, el ".parent" lo que hace es ir al atributo anteriror dentro de la jerarquía html
    //Ejemplo:
    /*
    <div id="soyElPadre">
      <div id="xd">
        <p>Hola wuapo</p>
      </div>
    </div>
    */
    //el ".parent" de p sería el div "xd"
    //y el ".parent" del div "xd" sería el div "soyElPadre"
    var form =$(this).parent();

    //Igualo a la variable action el action del form, en este caso "modals/deleteEvent.php"
    var action = form.attr('action');

    //Inicio el ajax
    $.ajax({
      //Url es hacia donde es que ejecuta la consulta
      url: action,
      //Método el método (POST o GET)
      method: 'POST',
      //Data es la información que vos le vas a pasar
      data: form.serialize(),
      //dataType el tipo de dato que vas a recibir
      dataType: "json",
      //succes se ejecuta si todo sale bien, entonces si todo sale bien ejecuto esa función que hice
      //Y response es la variable que yo mando desde PHP (deleteEvent.php)
      success: function(response){
        //Si el atributo status de response es true ejecuto
        if (response.status) {
          //en el span con id "message" pongo el mensaje que paso del array
          $('#message').html(response.message);
          $('#card-'+id).remove();
          console.log(response);
        }
      },
      //Y error se ejecuta cuando no sale bien (lo contrario a succes xd)
      error: function (response){
        console.log(response);
      }

    });
}
