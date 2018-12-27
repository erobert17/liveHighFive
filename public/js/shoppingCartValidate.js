$(document).ready(function(){
	$('button#proceedToPayment').click(function(){
		var errorFound = false;
		proceedToPaymentClick(errorFound);
	});
});

function proceedToPaymentClick(errorFound) {
  
  if( $("input[name='firstName']").val().length == 0 ){
  	  	$("input[name='firstName']").css('background','#feb7b7');
  	errorFound = true;
  };

  if( $("input[name='lastName']").val().length == 0 ){
  	  	$("input[name='lastName']").css('background','#feb7b7');
  	errorFound = true;
  };

  if( $("input[name='phone1']").val().length == 0 ){
  	  	$("input[name='phone1']").css('background','#feb7b7');
  	errorFound = true;
  };

  if( $("input[name='email1']").val().length == 0 ){
  	  	$("input[name='email1']").css('background','#feb7b7');
  	errorFound = true;
  };

  if( $("input[name='email2']").val().length == 0 ){
  	  	$("input[name='email2']").css('background','#feb7b7');
  	errorFound = true;
  };

  var email1 = $("input[name='email1']").val();
  email1 = email1.toString();
  var email2 = $("input[name='email2']").val();
  email2 = email2.toString();
  if(email1.indexOf(email2) === -1){
  	$("input[name='email1']").css('background','#feb7b7');
  	$("input[name='email2']").css('background','#feb7b7');
  	alert("Emails Do Not Match.");
  	errorFound = true;
  }

  if( $("input[name='street']").val().length == 0 ){
  	  	$("input[name='street']").css('background','#feb7b7');
  	errorFound = true;
  };

  if( $("input[name='city']").val().length == 0 ){
  	  	$("input[name='city']").css('background','#feb7b7');
  	errorFound = true;
  };

  if($("select[name='state']").find(":selected").val() == ""){

  	if($("input[name='state2']").val().length == 0){
  		$("select[name='state']").css('background','#feb7b7');
  		$("input[name='state2']").css('background','#feb7b7');
  		errorFound = true;
  	}

  }

  if( $("input[name='zip']").val().length == 0 ){
  	  	$("input[name='zip']").css('background','#feb7b7');
  	errorFound = true;
  };

  if(errorFound == false){
  	
  	$('#singleItemCheckoutStepTwo').submit();
  }


}