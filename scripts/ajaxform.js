/**
 * Separate jQuery documents with speciffic Ajax calls for different forms 
 * Due to the similarities in code, the file should be submitted into a separate plugin
 * NOTE: As part of the code, forms are getting validated by jQuery before getting submittes
 */




// Custom method for submitting a joke punchiline
$(function(){
	$('form[id ^= myForm]').submit( function() {
		var ID =  $(this).attr('id');
		var PID = ID.replace(/[^0-9]/g, '');
                var UID =  $('#uid' + PID).val();
		var TARGET = '#addPunch' + PID;
                var TEXT = $(':text').val();
                var URL = $(this).attr('action');
                if($(':text').val().length < 10) {
                    $('#line' + PID).css('border', '2px solid red');
                    //alert(ID);
                    $('#error' + PID).html('You entry is too short.').css('color', 'maroon');
                } else {
                    $('#missing' + PID).fadeOut(1000);
                    $(TARGET).slideUp(1000);
                    $.ajax({
                            url     : $(this).attr('action'),
                            type    : $(this).attr('method'),
                            data    : $(this).serialize(),
                            success : function( data ) {
                                    //alert('Form is successfully submitted ');    
                            },
                            error   : function(){
                                    //alert('Something wrong');
                            }
                    });
                    $('#questionView' + PID).slideUp(1000);
                    
                    setTimeout(function(){
                        $('#questionView' + PID).load('./app/appPunchline.php?u=' + UID + '&p=' + PID, function(){
                            $(this).slideToggle(1000);
                        });
                    }, 2000);
                }
	return false;
	});
});


// Separate method for jokes voting
$(function(){
	$('form[id=getVotesResults]').submit( function() {
  		var FROM = $('#idFrom').val();
  		var TO = $('#idTo').val();
  		var MIN = $('#idMin').val();
  		var MAX = $('#idMax').val();
  		if (FROM.length > 3) var FROM_MSG = FROM;
  			else	FROM_MSG = "2013-01-29";
  		if (TO.length > 3)	var TO_MSG = TO;
  			else	TO_MSG = "today";
  		if (MIN.length > 0) var MIN_MSG = MIN;
  			else	MIN_MSG = "1";
  		if (MAX.length > 0)	var MAX_MSG = MAX;
  			else	MAX_MSG = "5";
  				   		  	  				   		  	
  		var URL = "./app/appResolts.php?from=" + FROM + "&to=" + TO + "&min=" + MIN + "&max=" + MAX;	
  		var MSG = "Showing all results for Punchlines submitted between " + FROM_MSG + " and " + TO_MSG +
  					" and with average score between " + MIN_MSG + " and " + MAX_MSG + ". ";

  		$('#errorVote').html(MSG);
  		$('#votesBody').load(URL, function(){
  			$(this).slideDown(1000);
  		});
	return false;
	});
});


// Separate method for submitting a joke, sketch or song into the database
$(function(){
	$('form[id=addMaterial]').submit( function() {
		var MSG = '';
		var M32 = $('#m32').val();
		var M51 = $('#m51').val();
		var M52 = $('#m52').val();
		var M53 = $('#m53').val();
		var LINE = $('textarea[id=linematerial]').val();
		var TYPE = $('#type').val();		
		var UID = $('#uid').val();
		var LANG = $('#lang').val();	
		var CHECK = $('#voteMaterial').prop('checked');		
 
					
		if (LINE.length < 20 || TYPE == 'NULL')	{
			MSG = '';
			if (LINE.length == 0) {
				MSG += M52;
				$('textarea[id=linematerial]').css('border', '2px solid red');
				$('#mError').html(MSG).css('color', 'maroon');
			} else if (LINE.length < 20) {
				MSG += M51;
				$('textarea[id=linematerial]').css('border', '2px solid red');
				$('#mError').html(MSG).css('color', 'maroon');				
			} else {
				$('textarea[id=linematerial]').css('border', '1px solid #000080');		
			} 
			
			if (TYPE == 'NULL') {
				MSG += '. ';
				MSG += M53;
				$('#type').css('border', '2px solid red');
				$('#mError').html(MSG).css('color', 'maroon');
			} else {
				$('#type').css('border', '1px solid #000080');		
			} 		
		}		
		 else {
		 		
				$.ajax({
					url     : $(this).attr('action'),
					type    : $(this).attr('method'),
					data    : $(this).serialize(),
					success : function( data ) {
//						alert('Form is successfully submitted ');    
					},
					error   : function(){
//						alert('Something wrong');
					}
					
			});
		 	$('#mError').html(M32).css('color', '#000080');
			$('#type').css('border', '1px solid #000080');
			$('textarea[id=linematerial]').css('border', '1px solid #000080').val('').focus();			
			$('#type').val('NULL');
			$('#mainBody').slideUp(500);
			
			if (CHECK == 'false') {
				var URL = './body/bodyArchive.php?lang=' + LANG + '&type=' + TYPE + '&period=month';		
				alert ('bodyArchive');
			} else {
				var URL = './body/bodyMaterialVote.php?lang=' + LANG;
				alert ('bodyMaterial')
			}		
					                    
			setTimeout(function(){
				$('#mainBody').load(URL, function(){
					$(this).slideToggle(1000);
				});
			}, 1000);
		}
		return false;
	});
});
		

// method for submittion of Joke setup
$(function(){
	$('form[id=addQuestion]').submit( function() {
		var M32 = $('#m32').val();
		var M51 = $('#m51').val();	
		var LINE = $('textarea[id=line]').val();	
		var UID = $('#uid').val();
		var LANG = $('#lang').val();	

	
		if (LINE.length < 20)	{
			$('#line').css('border', '2px solid red');
			$('#mError').html(M51).css('color', 'maroon');			
		}		
		 else if (LINE.length >= 20 && LINE.length != 0) {
		 	$('#mError').html(M32).css('color', '#000080');
			$('textarea[id=line]').css('border', '1px solid #000080');	
						
			$.ajax({
					url     : $(this).attr('action'),
					type    : $(this).attr('method'),
					data    : $(this).serialize(),
					success : function( data ) {
//						alert('Form is successfully submitted ');    
					},
					error   : function(){
//						alert('Something wrong');
					}
			});
			$('textarea[id=line]').val('').focus();

			$('#mainBody').slideUp(500);
			
			var URL = './body/bodyBrainstorm.php?lang=' + LANG;			                    
			setTimeout(function(){
				$('#mainBody').load(URL, function(){
					$(this).slideToggle(1000);
				});
			}, 1000);
		} else {
			alert ('ERROR');
		}
		return false;
	});
});
 
 