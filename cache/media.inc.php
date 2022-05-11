<?php
//
// arguments passed by sprintf() to this config:
//
// 1 = original file
// 2 = new file
// 3 = thumbnail default quality
// 4 = new width
// 5 = new height
// 6 = vhost
//

// hab ich neu geschrieben ... und das noch neuer

// GROSSE BILDER (BREITE oder HOEHE > 500)
$imagemagic_big_arguments =		'"%1$s" -strip -quality %3$d -background none -thumbnail "%4$sx%5$s" -gravity center -extent "%4$sx%5$s" -unsharp 1x1+0.5  "%2$s"';

// BILDER MIT BREITE und HOEHE GESETZT --> CROPPING
$imagemagic_crop_arguments =	'"%1$s" -strip -quality %3$d -background none -thumbnail "%4$sx%5$s^" -gravity center -extent "%4$sx%5$s" -unsharp 1x1+0.5 "%2$s"';

// default einstellungen
$imagemagic_arguments =			'"%1$s" -strip -quality %3$d -background none -thumbnail "%4$sx%5$s >" -unsharp 1x1+0.5 "%2$s"';
?>