/**
 * Main jQuery methods used to generate some UI magic on the page 
 */	
	
	
$('input[type=text]').css('background-color', 'white').css('border', '1px solid #000080');

$('input[type=button]').css('background-color', 'C0C0C0').css('border', '1px solid Black');


function showPunchline(DIV, URL) {
	$(DIV).slideToggle('slow', function(event) {
		$(this).load(URL);
	});
}

$(window).bind('load', function() {
	
	$('#linematerial').focus();
	
	

	//$('#adminLinksTable').hide();
	//$('#SetupStatTable').hide();
	//$('#PunchStatTable').hide();  // show
	
	
	
	
				
	$('#TailsTable').hide();



	$('#idAddMaterial').click(function() {
		var UID = $(this).attr('uid');
		var LANG = $(this).attr('lang');
		var URL = './app/addMaterial.php?u=' + UID + '&lang=' + LANG;
		$('#topBody').fadeOut(1000, function(){
			$(this).load(URL);		
		}); 
		$('#topBody').fadeIn(1000);
	});


	$('#idAddQuestion').click(function() {
		var UID = $(this).attr('uid');
		var LANG = $(this).attr('lang');
		var URL = './app/appQuestion.php?u=' + UID + '&lang=' + LANG;	
		$('#topBody').fadeOut(1000, function(){
			$(this).load(URL);		
		}); 
		$('#topBody').fadeIn(1000);
		
	});



	
	$('#idTailsLink').click(function () {
            $('#TailsTable').load('./menu/menuTails.php', function () {
                $(this).slideToggle(1000);
            });
	});
	
	$('#idOnlineLink').click(function () {
		var LANG = $(this).attr('lang');
            $('#OnlineUsersTable').load('./menu/menuOnline.php?lang=' + LANG, function () {
                $(this).slideToggle(1000);
            });
	});                                
                                
                                
                                
	$('#idPunchStatLink').click(function () {
		$('#PunchStatTable').slideToggle('slow');
	});
				
	$('#idSetupStatLink').click(function () {
		$('#SetupStatTable').slideToggle('slow');
	});
	$('#idAdminLinks').click(function () {
		$('#adminLinksTable').slideToggle('slow');
	});
	
	$('#idNavLinks').click(function () {
		$('#NavLinksTable').slideToggle('slow');
	});
	
	$('#idActLinks').click(function () {
		$('#ActLinksTable').slideToggle('slow');
	});


		 		$('select[id=lang]').change(function(){
		 			var URL = './mainPage.php?lang=' + $(this).val();
		 			$(location).attr('href', URL);
 
		 		});
	
});





	function divClicked(selectedDiv) {
		$('.UsersClass').slideUp('slow');
		$(selectedDiv).slideToggle('slow');
	// alert(selectedDiv);
	}


// Methods are a legacy code from the previous projects.
// Should be excahanged with projer jQuery function

function openWin3(URL1) {
	aWindow1 = window.open(URL1, '_blank', 'width=550, height=350, scrollbars=0, resizable=1, toolbar=0, status=0, menubar=0');	
}


function openWin1(URL1) {
	aWindow1 = window.open(URL1, '_blank', 'width=450, height=250, scrollbars=0, resizable=0, toolbar=0, status=0, menubar=0');	
}

function openWin2(URL2) {
	aWindow2 = window.open(URL2, '_blank', 'width=550, height=350, scrollbars=1, resizable=0, toolbar=0, status=0, menubar=0');	
}	

function openWin_x(URL_x) {
	aWindow2 = window.open(URL_x, '_blank', 'width=450, height=375, scrollbars=0, resizable=0, toolbar=0, status=0, menubar=0');	
}	