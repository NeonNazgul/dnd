$(document).ready(function(){
	
	required = $('.required');
	email = $("#email");
	emptyerror = "Please fill out this field.";
	emailerror = "Please enter a valid e-mail.";

	$('form').submit(function(){
	
	//Validate required fields
	for (i=0;i<required.length;i++) {
	
	var input = $(required[i]);
	if ((input.val() == "") || (input.val() == emptyerror)) {
		console.log(input[i] + ": I do not think this field has a value");
	input.parent().addClass("has-error");
	input.addClass("has-error");
	input.val(emptyerror);

	
	} else {
	input.parent().removeClass("has-error");
	input.removeClass("has-error");
	}
	}

	// Validate the e-mail.
	if (!/^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/.test(email.val())) {
	   email.addClass("has-error");
	   email.val(emailerror);
	}

	//if any inputs on the page have the class 'needsfilled' the form will not submit
	if ($(":input").hasClass("has-error")) {
	$('.overlay').hide();
	$('.loading').hide();
	return false;
	} else {
	errornotice.hide();
	return true;
	}
	});

	// Clears any fields in the form when the user clicks on them
	$(":input").focus(function(){
	  if ($(this).parent().hasClass("has-error") ) {
	$(this).val("");
	$(this).parent().removeClass("has-error");
	  }
	});


});