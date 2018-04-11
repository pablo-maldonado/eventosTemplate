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

function delete_event(e){
    e.preventDefault();
    var id = $(this).attr('id').replace('btnDelete-', '');

var form =$(this).parent();
    var action = form.attr('action');

    $.ajax({
      url: action,
      method: 'POST',
      data: form.serialize(),
      dataType: "json",
      success: function(response){
        if (response.status) {
          $('#message').html(response.message);
          $('#tr-'+id).remove();
        }
      },
      error: function (response){
        console.log(response);
      }

    });
}
