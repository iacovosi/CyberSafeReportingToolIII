// add a new post
$(document).on('click', '.add-modal', function() {
  $('.modal-title').text('Add');
  $('#addModal').modal('show');
});
$(document).on('click', '.add', function() {
  console.log($('input[name=_token]').val());
  $.ajax({
    type: 'POST',
    url: 'permissions',
    data: {
      '_token': $('input[name=_token]').val(),
      'name': $('#name').val(),
      'display_name': $('#display_name').val(),
      'description': $('#description').val()
    },
    success: function(data) {
      console.log(data);
      $('.errorTitle').addClass('hidden');
      $('.errorContent').addClass('hidden');
        $('#postTable').append(
          "<tr class='item" + data.id + "'><td class='col1'></td><td>" +
          data.id + "</td><td>" + data.display_name + "</td><td>" + data.description +
           "</td><td>None</td><td class='text-center'>Right now</td>");

        $('.col1').each(function(index) {
          $(this).html(index + 1);
        });

    },
    error: function(data){
      console.log(data);
    }
  })
});
