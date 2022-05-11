<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/**
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 *
 * See http://code.google.com/p/minify/wiki/CustomSource for other ideas
 **/

return array(
	'js' => array(
		'/www/common/javascript/jquery-3.6.0.min.js',
		'/www/common/javascript/bootstrap-4.6.0/js/bootstrap.bundle.min.js',
		'/www/common/javascript/slick-1.9.0/slick.min.js',
		'/www/common/javascript/lightGallery-1.6.12/dist/js/lightgallery-all.min.js',
		'/www/common/javascript/jquery-scrolltofixed.js',
		'//js/searchbar.js',
		'//js/functions.js',
	),
	'css' => array(
		'/www/common/javascript/bootstrap-4.6.0/css/bootstrap.min.css',
		'/www/common/javascript/slick-1.9.0/slick.css',
		'/www/common/javascript/slick-1.9.0/slick-theme.css',
		'/www/common/javascript/lightGallery-1.6.12/dist/css/lightgallery.css',
		'/www/common/public/animate.css-3.7.0/animate.css',
		'//css/general.css',
		'//css/header.css',
		'//css/footer.css',
		'//css/search.css',
	),
);
?>