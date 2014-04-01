$(document).ready(function(){
	var $overlay = ('.overlay');
	var $modal = ('.modal');
	var $loading = ('.loading');
	//unhide all elements with .js class
	$('.js').show();
	//Handle stat check dice rolls
	var rollResult = '#roll_result';
	
	$('.statcheck').on("click", function(){
		
		var d20 = Math.floor((Math.random()*20)+1);
		var mod = parseInt( $(this).attr('name') );
		var result = d20 + mod;
		if (mod > 0){var operand = "+"} else {var operand = ""}
		
			$($overlay).show();
			$($modal).fadeIn();


			$(rollResult).html(
				
				"<p class=\"d20result_modal\"> " + d20 + "</p><p class=\"modifier_modal\">"	 + " Modifier: " + operand + mod + "</p><p class=\"total\">Total:  " + result + "</p>"
				);
		
	});

	$($overlay).on('click', function(){
		$(this).hide();
		$($modal).hide();

	});
	
	$('#registersubmit').on("click", function(){
		$($overlay).show();
		$($loading).show();

	});

	
	
//Change 'a' class if current page	
	$('.toolbar a').each(function(){
	

			function getCurentFileName(){
				var pagePathName= window.location.pathname;
			//	console.log(pagePathName.substring(pagePathName.lastIndexOf("/") + 1));
				return pagePathName.substring(pagePathName.lastIndexOf("/") + 1);
				
			}
		if ($(this).attr('href')=== getCurentFileName()){
			$(this).addClass('disabled');
		}
	});
	
//Handle Character Delete button
	$('.deletebutton').on("click", function(event){
		return confirm('Are you sure you want to delete this?');
		
	});
//Remove Message/Error/Modal Div
	$('#remove').on("click", function(){
		//console.log("close button clicked");
		$(this).parent().hide();
		$($overlay).hide();
		
	});

//Handle add/subtract stat buttons
$('.math').on('click', function(){
	//console.log($(this).parent().parent().children().val());
	var $value = parseInt($(this).parent().parent().children().val());

	//console.log($value);
	if($(this).hasClass("add")){
		$value = $value+1;
	}
	else if ($(this).hasClass("subtract")){
	$value = $value-1;	
	}
	else {

		console.log("button undefined");
	}
	$(this).parent().parent().children().val($value);
	});


	
});
