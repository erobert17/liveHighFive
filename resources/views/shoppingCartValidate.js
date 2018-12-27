$(document).ready(function(){

});

function proceedToPaymentClick() {
  var errorFound = false;
  if( $("input[name='firstName']").val().length == 0 ){
  	  	$("input[name='firstName']").css('background','rgba(245, 68, 68, 0.62)');
  	errorFound = true;
  };

  if( $("input[name='lastName']").val().length == 0 ){
  	  	$("input[name='lastName']").css('background','rgba(245, 68, 68, 0.62)');
  	errorFound = true;
  };

  if( $("input[name='phone1']").val().length == 0 ){
  	  	$("input[name='phone1']").css('background','rgba(245, 68, 68, 0.62)');
  	errorFound = true;
  };

  if( $("input[name='email1']").val().length == 0 ){
  	  	$("input[name='email1']").css('background','rgba(245, 68, 68, 0.62)');
  	errorFound = true;
  };

  if( $("input[name='email2']").val().length == 0 ){
  	  	$("input[name='email2']").css('background','rgba(245, 68, 68, 0.62)');
  	errorFound = true;
  };

  if( $("input[name='street']").val().length == 0 ){
  	  	$("input[name='street']").css('background','rgba(245, 68, 68, 0.62)');
  	errorFound = true;
  };

  if( $("input[name='city']").val().length == 0 ){
  	  	$("input[name='city']").css('background','rgba(245, 68, 68, 0.62)');
  	errorFound = true;
  };

  if($("select[name='state']").find(":selected").val() == ""){

  	if($("input[name='state2']").val().length == 0){
  		$("select[name='state']").css('background','rgba(245, 68, 68, 0.62)');
  		$("input[name='state2']").css('background','rgba(245, 68, 68, 0.62)');
  	}
  	errorFound = true;

  }


}