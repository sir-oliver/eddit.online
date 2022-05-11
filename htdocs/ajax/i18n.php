<?php
require_once('c+e/header.php');
require_once('c+e/ce.php');
CE::init();

header('Content-Type: text/javascript; charset=utf8');

CE::$smarty->configLoad('i18n.conf',CE::$languageID);
$i18n = CE::$smarty->getConfigVars();
echo "ce.i18n =\n{\n";
foreach( $i18n AS $k => $v )
{
	printf("'%s' : '%s',\n", $k, $v);
}
echo "'_' : '_'\n};\n\n";

$languages = CE::$cache->get('languages');
echo "ce.langs =\n{\n";
$langs = array();
foreach( $languages AS $lang )
{
	$langs[] = sprintf("\t'%s' : '%s'", $lang['code'], $lang['name']);
}
echo implode($langs,",\n");
echo "\n};\n\n";

require_once('c+e/footer.php');
?>
