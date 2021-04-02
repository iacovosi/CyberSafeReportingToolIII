$(document).ready(function(){
	$( ".val" ).submit(function( event ) {
		let phone = $(".val #tel").val();
		// let age = $('.val #age').val();
		if(phone.length > 9){
			$('.error-panel').append('Maximum Phone number digits = 9 ');
			$('.error-panel').css('display','block');
			event.preventDefault();
		}else{
			$('.error-panel').css('display','none');
		}
		// if(age.length > 2){
		// 	$('.error-panel').append('Maximum Age number digits = 2 ');
		// 	$('.error-panel').css('display','block');
		// 	event.preventDefault();
		// }else{
		// 	$('.error-panel').css('display','none');
		// }
  			
	});
});