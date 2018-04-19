// START PART TO EVENTS
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

        $('#modal_add_event').modal('hide');

        var event_description = $("#event_description").val();
        var event_date = $("#event_date").val();
        var event_address = $("#event_address").val();
        var event_photo = $("#event_event_photo").val();
        var event_addres = $("#event_addres").val();
        var event_description = response.events_description;
        if (event_addres == "") {
          event_addres = 'Lugar desconocido...';
        }

        //Prepare the Card with data to create a new Event
        var createCard = '<div class="card d-inline-block col-xs-10 col-sm-6 col-md-4 mb-5 card-add" id="card-' + event_id + '">' +
          '<div class="imgTxtCard" id="imgTxtCard-' + event_id + '">' +
            '<img class="card-img-top" src="https://images.pexels.com/photos/67636/rose-blue-flower-rose-blooms-67636.jpeg?auto=compress&cs=tinysrgb&h=350" alt="Card image cap">' +
            '<div class="card-body">' +
              '<h5 class="card-title">'+ event_name +'</h5>' +
              '<p class="card-text">' + event_description + '</p>' +
            '</div>' +
          '</div>' +
          '<ul class="list-group list-group-flush">' +
            '<li class="list-group-item"><i class="far fa-calendar-alt"></i> ' + event_date + '</li>' +
            '<li class="list-group-item"><i class="fas fa-user"></i> Cantidad de personas que asisitieron</li>' +
            '<li class="list-group-item"><i class="fas fa-map-marker-alt"></i> ' + event_addres +' </li>' +
          '</ul>' +
          '<div class="bodyCard" id="bodyCard-' + event_id + '">' +
            '<div class="card-body">' +
            '<form class="w3-container formDelete" id="formGoEvent-' + event_id+ '" method="post" action="modals/user.php">' +
              '<input type="hidden" name="events_id" value="' + event_id + '">' +
              '<button type="submit" class="btn btn-primary ml-4 float-right float-bottom mb-3"><i class="fas fa-arrow-right"></i></button>' +
            '</form>' +

              '<button type="button" class="btn btn-success float-right float-bottom ml-4 mb-4"><i class="fas fa-file-excel"></i> Excel</i></button>' +
              '<form class="w3-container formDelete" id="formDelete-' + event_id + '" method="post" action="modals/deleteEvent.php">' +
                '<input type="hidden" name="events_id" value="' + event_id + '">' +
                '<input type="hidden" name="force_event" value="0">' +
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
    swal({
      title: '¿Segurisimo que deseas eliminar este evento y todos sus datos? &#x1F625',
      text: "Chan chan chaann...!",
      type: 'warning',
      showCancelButton: true,
      cancelButtonText: 'No, mejor no &#x1F600',
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, hagámoslo &#x1F631'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: action,
          method: 'POST',
          data: form.serialize(),
          dataType: "json",

          success: function(response){

            if (response.status) {
                $( '#card-' + id ).addClass("card-add");
                swal({
                  position: 'center',
                  type: 'warning',
                  title: 'Se eliminó el evento ' + response.event_name + ' correctamente',
                  showConfirmButton: false,
                  timer: 2400
                })
              $('#card-'+id).remove();
            }else {
              swal({
                type:'error',
                title:'Hubo un problema &#x1F61E',
                text:'El evento no se ha podido eliminar.',
                footer: '<a href="#" onclick="informationDeleteEvent(' + id +')">¿Por qué puede ser que me de error?</a>',
              })
            }
          },
          error: function (response){
            console.log(response);
          }

        });
      }
    })


}

function informationDeleteEvent(id){
  var event_id = id;
  var post_to_do = JSON.parse('{ "events_id": '+event_id +', "force_event":1}');

  swal({
    title: 'Probable error...',
    text: "El error problablemente sea que el evento que desea borrar tenga asociados usuarios que fueron a este evento. Pero usted igual puede forzar la eliminación, tras forzar la eliminación se borrarán todos los datos de este evento",
    type: 'warning',
    showCancelButton: true,
    cancelButtonText: 'Ok, muchas gracias &#x1F44D',
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Forzar el borrado'
  }).then((result) => {
    if (result.value) {
      console.log(event_id);
      $.ajax({
        url: 'modals/deleteEvent.php',
        method: 'POST',
        data: post_to_do,
        dataType: "json",

        success: function(response){

          if (response.status) {
              $( '#card-' + id ).addClass("card-add");
              swal({
                position: 'center',
                type: 'warning',
                title: 'Se eliminó el evento ' + response.event_name + ' correctamente',
                showConfirmButton: false,
                timer: 2400
              })
            $('#card-'+id).remove();
          }else {
            swal({
              type:'error',
              title:'Hubo un problema &#x1F61E',
              text:'El evento no se ha podido eliminar.',
              footer: '<a href="#" onclick="informationDeleteEvent(' + id +')">¿Por qué puede ser que me de error?</a>',
            })
          }
        },
        error: function (response){
          console.log(response);
        }

      });
    }
  })
}


// START PART TO USERS
function registrer_user(e){
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
    },
    error: function (response){
      console.log(response);
    }
  });

};
