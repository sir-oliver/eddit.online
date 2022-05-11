function searchbar_toggle()
{
	var width = $('ul.navbar-nav.justify-content-center.level1').outerWidth();

	$('#topSearchBar')
		.css({
			width: width + 'px',
		})
		.show()
		.toggleClass('fadeOutUp')
		.toggleClass('fadeInDown');

}
