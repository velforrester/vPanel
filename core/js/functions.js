function previewFile(e,f,g,h) {
	var preview = document.getElementById(e);
	var file    = document.getElementById(f).files[0];
	var reader  = new FileReader();
	reader.addEventListener("load", function () {
		preview.src = reader.result;
		$(g).removeClass('hide');
		$(h).removeClass('hide');
	}, false);
	if (file) {
		reader.readAsDataURL(file);
	}
}

function loadPage(link){
	$('.mainContent').load(link);
	$('header').addClass('slideup');
}

function closePage(){
	$('.container').remove();
	$('header').removeClass('slideup');
}

function ajaxLoadPage(type,url,data){
	$.ajax({
		type: type, // post or get
		url: url,
		data: {data:data},
		success: function(html){
			$('.mainContent').html(html);
		}
	});
	$('header').addClass('slideup');
}

function deleteUser(e){
	var id = e;
	var alerttext = 'Are you sure you want to delete this user? (' + id + ')';
	if(confirm(alerttext)){
		$.ajax({
			type: "POST",
			url: "core/user/deleteUser.php",
			data: {id:id},
			success: function(data) {
				var data = JSON.parse(data);
				var vpaneltheme = data['vpaneltheme'];
				var logout = data['logout'];
				if(logout != 'true'){
					$('.mainContent').load('themes/' + vpaneltheme + '/layout/vPanel/users/editUsers.php');
				}else{
					window.location.replace('core/user/logout.php');
				}
			}
		});	
	}else{
	};
};
	
function deleteAccountType(e,f){
	var id = e;
	var name = f;
	var alerttext = 'Are you sure you want to delete this account type? (' + name + ')';
	if(confirm(alerttext)){
		$.ajax({
			type: "POST",
			url: "core/account/deleteAccountType.php",
			data: {id:id},
			success: function(data) {
				var data = JSON.parse(data);
				var vpaneltheme = data['vpaneltheme'];
				$('.mainContent').load('themes/' + vpaneltheme + '/layout/vPanel/accountTypes/editAccountTypes.php');
			}
		});	
	}else{
	};
};

var idleTime = 0;

function idleInterval(){
	idleTime ++;
	if(idleTime > 19){ // 19 = 20 minutes
		window.location.replace('core/user/logout.php');
	}
}


$(document).ready(function(){

	if($('#login').length == 0){
		var logout = setInterval(idleInterval, 60000); // 60000 = 1 minute
		$(this).mousemove(function() {
			idleTime = 0;
		});
		$(this).keypress(function() {
			idleTime = 0;
		});
	}

	$('#userIconDelete').live('click', function(){
		$('#userIcon').attr('src','');
		$(this).addClass('hide');
		$('#userIcon').addClass('hide');
		$('input[name=userIcon]').attr('data-delete','true').val('');
	});
	
	$('#userBgDelete').live('click', function(){
		$('#userBg').attr('src','');
		$(this).addClass('hide');
		$('#userBg').addClass('hide');
		$('input[name=userBg]').attr('data-delete','true').val('');
	});
	
	
	// CREATE ACCOUNT TYPE -----------------------------------------------------------------------------------------------------------------------
	
	
	$('#createAccountType').live('submit', function(e){
		var name = $('input[name=name]');
		var menu = $('input[name=menu]');
		var specials = $('input[name=specials]');
		var businessinfo = $('input[name=businessinfo]');
		var sitesettings = $('input[name=sitesettings]');
		if(name.val() == ''){
			alert('Please enter a name for your account type!');
			$('.nameLabel').css({
				'font-weight' : 'bold',
				'color' : '#f00'
			});
			name.focus();
			return false;
		}
		var formData = new FormData(this);
		$.ajax({
			type : 'POST',
			url : 'core/account/createAccountType.php',
			data : formData,
			cache:false,
			contentType: false,
			processData: false,
			success : function(data){
				var data = JSON.parse(data);
				var vpaneltheme = data['vpaneltheme'];
				$('.mainContent').load('themes/' + vpaneltheme + '/layout/vPanel/accountTypes/editAccountTypes.php');
			},
			error : function(data){
				var array = JSON.parse(data);
				var html = array['message'];
				$('.container').html(html);
			}
		});
		e.preventDefault();
	});
	

	// EDIT ACCOUNT TYPE -----------------------------------------------------------------------------------------------------------------------


	$('#editAccountType').live('submit', function(e){
		var id = $('input[name=id]');
		var name = $('input[name=name]');
		var menu = $('input[name=menu]');
		var specials = $('input[name=specials]');
		var businessinfo = $('input[name=businessinfo]');
		var sitesettings = $('input[name=sitesettings]');
		if(name.val() == ''){
			alert('Please enter a name for your account type!');
			$('.nameLabel').css({
				'font-weight' : 'bold',
				'color' : '#f00'
			});
			name.focus();
			return false;
		}
		var formData = new FormData(this);
		$.ajax({
			type : 'POST',
			url : 'core/account/editAccountType.php',
			data : formData,
			cache:false,
			contentType: false,
			processData: false,
			success : function(){
				$('#message').html('Account Type updated successfully!');
				$('#message').css({
						'font-weight' : '600',
						'color' : '#009917'
					});
				setTimeout(function(){
					$('#message').html('Use this form to edit the selected account type.');
					$('#message').css({
						'font-weight' : '500',
						'color' : '#000'
					});
				}, 6000);
			},
			error : function(data){
				var array = JSON.parse(data);
				var html = array['message'];
				$('.container').html(html);
			}
		});
		e.preventDefault();
	});
	
	
	// CREATE USER -----------------------------------------------------------------------------------------------------------------------
	
	
	$('#addUser').live('submit', function(e){
		var userId = $('input[name=userId]');
		var password = $('input[name=password]');
		var confirmPassword = $('input[name=confirmPassword]');
		if(userId.val() == ''){
			alert('Please enter a User ID!');
			$('.idLabel').css({
				'font-weight' : 'bold',
				'color' : '#f00'
			});
			userId.focus();
			return false;
		}
		if(userId.val().indexOf(' ') >= 0){
			alert('User ID can not contain spaces!');
			$('.idLabel').css({
				'font-weight' : 'bold',
				'color' : '#f00'
			});
			userId.focus();
			return false;
		}
		if(password.val() == ''){
			alert('Please enter a password!');
			$('.passwordLabel').css({
				'font-weight' : 'bold',
				'color' : '#f00'
			});
			$('.idLabel').css({
				'font-weight' : 'unset',
				'color' : '#000'
			});
			password.focus();
			return false;
		}
		if(password .val() != confirmPassword.val()){
			alert('Passwords do not match!');
			$('.confirmLabel').css({
				'font-weight' : 'bold',
				'color' : '#f00'
			});
			$('.passwordLabel').css({
				'font-weight' : 'unset',
				'color' : '#000'
			});
			confirmPassword.focus();
			return false;
		}
		var formData = new FormData(this);
		var userLevel = $('select[name=accountType]').val();
		var userIcon = $('input[name=userIcon]').val();
		var userBg = $('input[name=userBg]').val();
		formData.append('userLevel', userLevel);
		formData.append('userIcon', userIcon);
		formData.append('userBg', userBg);
		$.ajax({
			type : 'POST',
			url : 'core/user/createUser.php',
			data : formData,
			cache:false,
			contentType: false,
			processData: false,
			success : function(data){
				var data = JSON.parse(data);
				if(typeof data['duplicate'] != 'undefined'){
					alert('User ID not available!');
					$('.idLabel').css({
						'font-weight' : 'bold',
						'color' : '#f00'
					});
					$('.passwordLabel').css({
						'font-weight' : 'unset',
						'color' : '#000'
					});
					$('.confirmLabel').css({
						'font-weight' : 'unset',
						'color' : '#000'
					});
					userId.focus();
					return false;
				}else if(typeof data['error'] != 'undefined'){
					var error = data['error'];
					alert(error);
					return false;
				}else{
					var vpaneltheme = data['vpaneltheme'];
					$('.mainContent').load('themes/' + vpaneltheme + '/layout/vPanel/users/editUsers.php');
				}
			},
			error : function(data){
				var array = JSON.parse(data);
				var html = array['message'];
				$('.container').html(html);
			}
		});
		e.preventDefault();
	});
	
	
	// EDIT USER -----------------------------------------------------------------------------------------------------------------------
	
	
	$('#editUser').live('submit', function(e){
		var userId = $('input[name=userId]');
		var password = $('input[name=password]');
		var confirmPassword = $('input[name=confirmPassword]');
		if(userId.val() == ''){
			alert('Please enter a User ID!');
			$('.idLabel').css({
				'font-weight' : 'bold',
				'color' : '#f00'
			});
			$('.passwordLabel').css({
				'font-weight' : 'unset',
				'color' : '#000'
			});
			$('.confirmLabel').css({
				'font-weight' : 'unset',
				'color' : '#000'
			});
			userId.focus();
			return false;
		}
		if(userId.val().indexOf(' ') >= 0){
			alert('User ID can not contain spaces!');
			$('.idLabel').css({
				'font-weight' : 'bold',
				'color' : '#f00'
			});
			$('.passwordLabel').css({
				'font-weight' : 'unset',
				'color' : '#000'
			});
			$('.confirmLabel').css({
				'font-weight' : 'unset',
				'color' : '#000'
			});
			userId.focus();
			return false;
		}
		if(password.val() == ''){
			alert('Please enter a password!');
			$('.passwordLabel').css({
				'font-weight' : 'bold',
				'color' : '#f00'
			});
			$('.idLabel').css({
				'font-weight' : 'unset',
				'color' : '#000'
			});
			$('.confirmLabel').css({
				'font-weight' : 'unset',
				'color' : '#000'
			});
			password.focus();
			return false;
		}
		if(password .val() != confirmPassword.val()){
			alert('Passwords do not match!');
			$('.confirmLabel').css({
				'font-weight' : 'bold',
				'color' : '#f00'
			});
			$('.idLabel').css({
				'font-weight' : 'unset',
				'color' : '#000'
			});
			$('.passwordLabel').css({
				'font-weight' : 'unset',
				'color' : '#000'
			});
			confirmPassword.focus();
			return false;
		}
		var formData = new FormData(this);
		var userLevel = $('select[name=accountType]').val();
		var userIcon = $('input[name=userIcon]').val();
		var oldUserIcon = $('input[name=oldUserIcon]').val();
		var userBg = $('input[name=userBg]').val();
		var oldUserBg = $('input[name=oldUserBg]').val();
		formData.append('userLevel', userLevel);
		formData.append('userIcon', userIcon);
		formData.append('userBg', userBg);
		var uid = 'false';
		var ubgd = 'false';
		if($('input[name=userIcon]').attr('data-delete') == 'true'){
			var uid = 'true';
		}
		if(userIcon != '' && userIcon != oldUserIcon && oldUserIcon != ''){
			var uid = 'true';
		}
		if($('input[name=userBg]').attr('data-delete') == 'true'){
			var ubgd = 'true';
		}
		if(userBg != '' && userBg != oldUserBg && oldUserBg != ''){
			var ubgd = 'true';
		}
		formData.append('userIconDelete', uid);
		formData.append('userBgDelete', ubgd);
		$.ajax({
			type : 'POST',
			url : 'core/user/editUser.php',
			data : formData,
			cache:false,
			contentType: false,
			processData: false,
			success : function(data){
				var data = JSON.parse(data);
				if(typeof data['error'] != 'undefined'){
					var error = data['error'];
					alert(error);
					return false;
				}else{
					$('#message').html('User updated successfully!');
					$('#message').css({
							'font-weight' : '600',
							'color' : '#009917'
						});
					setTimeout(function(){
						$('#message').html('Use this form to edit the selected user account.');
						$('#message').css({
							'font-weight' : '500',
							'color' : '#000'
						});
					}, 6000);
					var reload = data['reload'];
					if(reload == 1){
						location.reload();
					}
				}
			},
			error : function(data){
				var array = JSON.parse(data);
				var html = array['message'];
				$('.container').html(html);
			}
		});
		e.preventDefault();
		if($('input[name=userIcon]').attr('data-delete') == 'true'){
			$('input[name=userIcon]').attr('data-delete','false');
		}
		if($('input[name=userBg]').attr('data-delete') == 'true'){
			$('input[name=userBg]').attr('data-delete','false');
		}
	});
	
});