var isMobile = (typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf('IEMobile') !== -1);


$(function()
{
	// $('.tooltipper').tooltip({trigger:'hover'})
	// $('header').scrollToFixed();
	$('form.easyform').on('submit',submitEasyForm)
	$('form.ajaxform').on('submit',submitAjaxForm)
});
function submitEasyForm()
{
	var url = $(this).attr('action');
	var data = '';
	$(this)
		.find(':input')
		.each(function (i,input){
			var _name = $(input).attr('name');
			var _value = $(input).val();
			if (typeof _name != 'undefined' && _value != '')
			{
				data += _name+'--'+_value+'/'
			}
		});
	if (data != '')
	{
		window.location.href = url+data;
	}
	else
	{
		console.log('empty form will not be submitted',this);
	}
	return false;
}
function resetAjaxForm(element)
{
	var form = $(element).parents('form');
	form.find('.form').show();
	form.find('.response').hide().html('');
	form.find('#captcha').show();
	form.find('#submitButton').hide();
	grecaptcha.reset();
}
function submitAjaxForm(event)
{
	event.preventDefault();
	event.stopPropagation();

	var form = $(this);
	form.addClass('was-validated');

	if (this.checkValidity() === false)	// formular hat fehler
	{
		console.log('form has errors, not sending');
	}
	else	// formular ist in ordnung
	{
		$.ajax(
			{
				type: "POST",
				url: '/ajax/form_send.php',
				data: form.serialize(),
				success: function(response)
				{
					form.find('.form').hide();
					form.find('.response').show().html(response);
				}
			}
		);
	}
}
function captchaSolved(response)
{
	$('#captcha').hide();
	$('#submitButton').show().attr('name', 'action');
}
function scrollIntoViewport(object)
{
	// console.log('scrollIntoViewport',object);
	if (object instanceof jQuery)
	{
		target = object[0];
	}
	else if (typeof object == 'string')
	{
		target = document.querySelector(object);
	}
	else if (typeof object == 'object')
	{
		target = object;
	}
	else
	{
		console.log('scrollIntoViewport failed',typeof object, object);
		return false;
	}
	target.scrollIntoView();
}
function zoomImage(element)
{
	// if (isMobile) return false;
	var elem = $(element);
	var type = elem.prop("tagName").toLowerCase();
	if (type == 'img')
	{
		var data = {
			"src": elem.attr('src'),
			'thumb': elem.attr('src'),
			'subHtml': elem.attr('alt')
		}
	}
	else
	{
		var data = {
			"src": elem.data('src'),
			'thumb': elem.data('src'),
			'subHtml': elem.data('subhtml')
		}
	}
	elem
		.lightGallery({
			dynamic: true,
			dynamicEl: [ data ],
			download: false,
			thumbnail: false,
			zoom: false,
			hash: false,
			share: false,
			counter: false
		});
}
