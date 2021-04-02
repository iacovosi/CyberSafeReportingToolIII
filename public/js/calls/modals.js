// add a new post
$(function(){

  $(document).on('click', '.add-modal', function() {
    $('.modal-title').text('Add item');
    $('#addModal').modal('show');
  });

  $(document).on('click','.view-this', function(event){
    $.each(event.target.dataset, function(key,value){
      $('#view-modal #'+ key).val(value);
    });
      $('#view-modal').modal('show');
  });

  $(document).on('click','.testme',function(event){
    console.log(event);
    var target = $('#update-modal #submit-form').serialize();
    console.log(target);
  });
  
  /*
  | When clicked on the dropdown menu display it on the input menu
  | 
  */
  $(document).on('click','#update-modal,#addModal ul li',function (event){

    let inputname = event.target.innerHTML;
    let word = inputname.split(' ');

    if (inputname == 'undefined'){
      inputname = event.target.childNodes.text.data;
    }
    
    if (word.length > 2){
      inputname = event.target.text;
    }

    let idname = $(event.target).attr('id');

    if(idname == null){
      idname = $(event.target.innerHTML).attr('id');
    }
    
    if(idname == 'newactions'){
      $('#' + idname).append(inputname + ' ');
    } else {
      $('#' + idname).val(inputname);
    }
  });


  $( "#toggle-me" ).click(function() {
    $( "#toggle-this" ).toggle( "slow", function() {
      // Animation complete.
    });
  });
  
});

$(document).on('click','.update-this', function(event){
  $.each(event.target.dataset, function(key,value){
    var $this =  $('#update-modal #' + key);
      if ($this.is("input")) {
        console.log($this);
        $('#update-modal #' + key).val(value);
      } else if ($this.is("textarea")) {
        $('#update-modal #' + key).text(value);
      }
  });

  $('#update-modal .update-content').attr('data-id',event.target.dataset.id);
  setTimeout(function(){
    $('#update-modal').modal('show');
  }, 300);
  // console.log(event);
  // console.log(target);
});

$(document).find('#actionstaken').on('click',function(){
  let data = $('#actionstaken').val();
  $('#newactions').val( $('#newactions').val() + data + ' ' );
});

$(document).find('#update-modal').on('click','input', function (e) {
    console.log('da');
   e.preventDefault();
});