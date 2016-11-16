function cmSignupGate(url, showThankYou) {
	if (url == '#' && showThankYou) {
		jQuery('#cm-signup-gate').attr('data-url', '#thanks');
	} else {
		jQuery('#cm-signup-gate').attr('data-url', url);
	}
	jQuery('#cm-signup-gate').show();
	return false;
}

function cmSignupGateHidePageField(id, postTitle) {
	jQuery('#' +id).prop('type', 'hidden');
	jQuery('#' +id).val(postTitle);
	jQuery('#' +id).parent().css('height', '0px');
}

jQuery(document).ready(function($) {
	
	$('a.cm-signup-gate-close').click(function() {
		$(this).parents('.cm-signup-gate-modal').hide();
		return false;
	});
	
	$('.cm-signup-gate-modal form').submit(function(e) {
		var f = this;
		
		function showErr(err) {
			$(f).prev().text(err);
			$(f).prev().show();
			return false;
		}
		
		$(f).prev().hide();
		
		if ($.trim($(f).find('input[name="cm-name"]').val()) == '') {
			return showErr('Please enter your name');
		}
		
		var emailRe = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
		if (!emailRe.test($(f).find('input[type="email"]').val())) {
			return showErr('Please enter a valid email address');
		}
		
		e.preventDefault();
		$.getJSON(this.action + "?callback=?", $(this).serialize(),
            function(data) {
                if (data.Status === 400) {
					return showErr(data.Message);
                } else { // 200
					$(this).parents('.cm-signup-gate-modal').hide();
					if ($('#cm-signup-gate').attr('data-url') == '#thanks') {
						$('#cm-signup-gate-thanks').show();
					} else {
						window.location = $('#cm-signup-gate').attr('data-url');
					}
                }
            }
		);
	});
	
});