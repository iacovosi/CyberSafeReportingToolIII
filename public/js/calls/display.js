var formdata;
var evaluateformdata;
$(document).ready(function () {
    initial_sevaluation();
  $('.toggle-me').click(function (event) {

    // console.log(event.delegateTarget.dataset);

    console.log(formdata);
    $('#toggle-this').toggle();
  });
  $("input:checkbox").change(function () {
    checkboxesevaluation();
    if(JSON.stringify(formdata) === JSON.stringify(evaluateformdata)){
      $('#checkchanges').val('0');
    }
    else{
      $('#checkchanges').val('1');
    }
  })
});

function initial_sevaluation() {
  formdata = $("input:checkbox").map(function () {
    return $(this).is(":checked");
  }).get();
  return formdata;
}
function checkboxesevaluation() {
  evaluateformdata = $("input:checkbox").map(function () {
    return $(this).is(":checked");
  }).get();
  return evaluateformdata;
}