/**
 * [Ajac Post call , gets all the values of the #submit-form and sends them
 * to the url that the data-target attribute holds in]
 *
 */

$(document).on('click', '#save-this', function() {
  var target = $('#submit-form').serializeArray();
  var url = $('#save-this').data('target');
  $.ajax({
    headers: {
      'X-CSRF-Token': $('input[name=_token]').val(),
    },
    type: 'POST',
    url: '/' + url,
    data: target,

    success: function(data) {
      
      window.location.replace("/" + url);
      //Clear the error-panel and hide it.
      $('.error-panel ul').empty();
      $('.error-panel').css('display', 'none');

      //Clear the success panel to avoid duplicates.
      $('.success-panel').html('');
      //
      $('.success-panel').append('Saved');
      $('.success-panel').css('display', 'block');
    },
    error: function(data) {
      console.log(target);
      var errors = data.responseJSON;
      $('.success-panel').html('');
      $('.success-panel').css('display', 'none');
      $('.error-panel ul').empty();
      $.each(errors, function(i, val) {
        $('.error-panel ul').append('<li>' + val + '</li>');
      })
      $('.error-panel').css('display', 'block');

    }
  })
});

$(document).on('click', '#save-me', function() {
  var target = $('#addModal #submit-form').serialize();
  var url = $('#save-me').data('target');
  var place = $('#save-me').data('place');
  $.ajax({
    headers: {
      'X-CSRF-Token': $('input[name=_token]').val(),
    },
    type: 'POST',
    url: '/' + url,
    data: target,

    success: function(data) {
    
      window.location.replace("/" + place);
      //Clear the error-panel and hide it.
      $('.error-panel ul').empty();
      $('.error-panel').css('display', 'none');

      //Clear the success panel to avoid duplicates.
      $('.success-panel').html('');
      //
      $('.success-panel').append('Saved');
      $('.success-panel').css('display', 'block');
    },
    error: function(data) {
      console.log(target);
      var errors = data.responseJSON;
      $('.success-panel').html('');
      $('.success-panel').css('display', 'none');
      $('.error-panel ul').empty();
      $.each(errors, function(i, val) {
        $('.error-panel ul').append('<li>' + val + '</li>');
      })
      $('.error-panel').css('display', 'block');

    }
  })

});

/**
 * [Ajac Delete call , gets all the values of the #submit-form and sends them
 * to the url that the data-target attribute holds in]
 *
 */
$(document).on('click', '#delete-this', function() {
  //Multiple delete buttons might be in place, so putting it in a variable @this
  //will solve future issues and targeting wrong elements.
  
  var result = confirm("You are about to permanently delete this report/statistic and everything related. Are you sure?");

  if (result) {
    //Logic to delete the item
    var thistarget = this;
    var url = $(thistarget).data('target');
    var value = $(thistarget).data('id');

    $.ajax({
      headers: {
        'X-CSRF-Token': $('input[name=_token]').val(),
      },
      type: 'DELETE',
      url: '/' + url + '/' + value,
      success: function(data) {
        location.reload();
      },
      error: function(data) {
        $('#success-panel').css('display', 'none');
        $('#error-panel').css('display', 'block');
        $('#error-panel').text(data['responseJSON']);
      }
    })

  } 

});

/**
 * Mass delete
 * @return {[type]} [description]
 */
$(document).on('click', '#mass-delete', function() {
  var checkedvalues = [];

  console.log(data);
  if (typeof($("input:checked").val()) != "undefined" && $("input:checked").val() != "null") {
    $('input[type=checkbox]').each(function() {
      if ($(this).prop('checked') == true) {
        console.log($(this));
      }

    });
  }
});

/**
 *  Update calls
 */
$(document).on('click', '#update-this', function() {
  var target = $('#submit-form').serializeArray();
  var url = $('#update-this').data('target');
  var value = $('#update-this').data('id');

  $.ajax({
    headers: {
      'X-CSRF-Token': $('input[name=_token]').val(),
    },
    url: '/' + url + '/' + value,
    type: 'PUT',
    data: target,
    success: function(data) {
      console.log(data);
      $('.success-panel').html('');
      $('.success-panel').append('Sucessfully Updated');
      $('.success-panel').css('display', 'block');
      $('.error-panel').css('display', 'none');
      $('.error-panel ul').empty();
    },
    error: function(data) {
      var errors = data.responseJSON;
      console.log(data);
      $('.success-panel').html('');
      $('.success-panel').css('display', 'none');
      $('.error-panel ul').empty();
      $.each(errors, function(i, val) {
        console.log(val);
        $('.error-panel ul').append('<li>' + val + '</li>');
      })
      $('.error-panel').css('display', 'block');

    }

  })
});
$(document).on('click', '.testing', function(event) {

  event.preventDefault();
  /* Act on the event */
  var target = $('#submit-form').serializeArray();
  var data = {};
  var selected = [];
  $('input:checked').each(function() {
    selected.push($(this).attr('name'));
  });
  console.log(selected);
  // $(target).each(function(index, obj) {
  //   data[obj.name] = obj.value;
  // });
  var selected = [];
  $('input:checked').each(function() {
    selected.push($(this).attr('name'));
  });
  $.ajax({
      headers: {
        'X-CSRF-Token': $('input[name=_token]').val(),
      },
      url: '/users',
      type: 'PUT',
      data: target,
    })
    .done(function(data) {
      console.log(data);
      console.log("success");
    })
    .fail(function(data) {
      console.log("error");
      console.log(data);
    })

});


$(document).on('click', '#update-me ', function() {
  var target = $('#update-modal #submit-form').serialize();
  var url = $('#update-me').data('target');
  var value = $('#update-me').data('id');
     var place= $(this).data('place');
  $.ajax({
    headers: {
      'X-CSRF-Token': $('input[name=_token]').val(),
    },
    url: '/' + url + '/' + value,
    type: 'PUT',
    data: target,
    success: function(data) {

      if(place != null){
        window.location.replace("/home");
      }else{
        window.location.replace("/" + url);
      }
      console.log(data);
      $('.success-panel').html('');
      $('.success-panel').append('Sucessfully Updated');
      $('.success-panel').css('display', 'block');
      $('.error-panel').css('display', 'none');
      $('.error-panel ul').empty();
    },
    error: function(data) {
      var errors = data.responseJSON;
      console.log(data);
      $('.success-panel').html('');
      $('.success-panel').css('display', 'none');
      $('.error-panel ul').empty();
      $.each(errors, function(i, val) {
        console.log(val);
        $('.error-panel ul').append('<li>' + val + '</li>');
      })
      $('.error-panel').css('display', 'block');

    }

  })
});
