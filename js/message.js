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
        var event_name = $('#event_name').val();
        var event_id = response.events_id;

        //Show the SweetAlert
        swal({
          position: 'center',
          type: 'success',
          title: 'Se registró el evento ' + event_name + ' correctamente',
          showConfirmButton: false,
          timer: 2400
        })

        //Prepare the Card with data to create a new Event
        var createCard = '<div class="card d-inline-block col-xs-10 col-sm-6 col-md-4 mb-5 card-add" id="card-' + event_id + '">' +
          '<div class="imgTxtCard" id="imgTxtCard-' + event_id + '">' +
            '<img class="card-img-top" src="https://images.pexels.com/photos/67636/rose-blue-flower-rose-blooms-67636.jpeg?auto=compress&cs=tinysrgb&h=350" alt="Card image cap">' +
            '<div class="card-body">' +
              '<h5 class="card-title">'+ event_name +'</h5>' +
              '<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card´s content. (Descripción del evento)</p>' +
            '</div>' +
          '</div>' +
          '<ul class="list-group list-group-flush">' +
            '<li class="list-group-item"><i class="far fa-calendar-alt"></i> Fecha del Evento</li>' +
            '<li class="list-group-item"><i class="fas fa-user"></i> Cantidad de personas que asisitieron</li>' +
            '<li class="list-group-item"><i class="fas fa-map-marker-alt"></i> Lugar de realización</li>' +
          '</ul>' +
          '<div class="bodyCard" id="bodyCard-' + event_id + '">' +
            '<div class="card-body">' +
              '<button type="button" class="btn btn-success float-right float-bottom ml-4 mb-4"><i class="fas fa-file-excel"></i> Excel</i></button>' +
              '<form class="w3-container formDelete" id="formDelete-' + event_id + '" method="post" action="modals/deleteEvent.php">' +
                '<input type="hidden" name="events_id" value="' + event_id + '">' +
                '<button type="submit" id="btnDelete-' + event_id + '" class="btn btn-danger float-right float-bottom mb-3 btnDelete"><i class="fas fa-trash-alt"></i> Borrar evento</button>' +
              '</form>' +
            '</div>' +
          '</div>' +
        '</div>';

        //Put the Card in HTML
        $('.row').prepend(createCard);

        //Wait 100 milliseconds to execute the effect to show the new card
        setTimeout(function(){
          $( '#card-' +event_id ).removeClass("card-add");
        }, 100);

        //Reset the values inside the form
        $('#event_name').val('');
        // $("#formDelete-"+event_id).find('#events_id').val(event_id); -- I don't remember this line, and i think is unnecessary
      }
      },
      error: function (response){
        console.log(response);
      }

    });
}

//Delete event
function delete_event(e){
  // e.preventDefault lo que hace es frenar todo lo que se iba a hacer por defecto en la página
  // (en este caso iba a ir a la página "deleteEvent.php")
    e.preventDefault();
    //Pongo en la variable id los datos de la id que voy a borrar
    var id = $(this).attr('id').replace('btnDelete-', '');

    //Data from form (this = button) => (this.parent = form)
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

          // setTimeout(function(){
            $( '#card-' + id ).addClass("card-add");
          // }, 100);
          //Show the SweetAlert
            swal({
              position: 'center',
              type: 'warning',
              title: 'Se eliminó el evento ' + response.event_name + ' correctamente',
              showConfirmButton: false,
              timer: 2400
            })
          setTimeout($('#card-'+id).remove(), 3000);
        }
      },
      //Y error se ejecuta cuando no sale bien (lo contrario a succes xd)
      error: function (response){
        console.log(response);
      }

    });
}
