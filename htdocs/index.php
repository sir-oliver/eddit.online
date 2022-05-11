<?php
// define('CE_FORCE_DEBUG',true);     // force debug output
// define('CE_SHOW_DEBUGGER',true);      // show request parameters, session and DB queries
define('FQDN', 'http://eddit.probeseite.at');

require_once('eddit/header.php');
require_once('eddit/eddit.php');

EDDIT::init();

EDDIT::login('clickedit');

$node = EDDIT::nodes(EDDIT::$nodeID);
if (is_a($node, 'eddit_node'))
{
	EDDIT::addHeader('title', 'title', $node->attr('windowtitle'));
	EDDIT::addHeader('meta', 'description', $node->attr('metadescription'));

	if (strpos($_SERVER['REQUEST_URI'],'eddit--live') !== false)
		EDDIT::addHeader('meta', 'robots', 'noindex, nofollow');
	else
		EDDIT::addHeader('meta', 'robots', $node->attr('metarobots', 'index, follow'));

	EDDIT::addHeader('meta', 'author', '');

	// EDDIT::addHeader('metaproperty','og:url',FQDN.'/');
	// EDDIT::addHeader('metaproperty','og:image','');
	// EDDIT::addHeader('metaproperty','og:site_name','');
	EDDIT::addHeader('metaproperty','og:type','website');
	EDDIT::addHeader('metaproperty','og:title',$node->attr('windowtitle'));
	EDDIT::addHeader('metaproperty','og:description',$node->attr('metadescription'));
	EDDIT::addHeader('metaproperty','og:locale',EDDIT::$languageID);

	if ($node->attr('metacanonical'))
	{
		EDDIT::addHeader('link', 'canonical', FQDN.$node->attr('metacanonical'));
		EDDIT::addHeader('metaproperty','og:url',FQDN.$node->attr('metacanonical'));
	}
	elseif ($node->id == EDDIT::config('defaultPG'))
	{
		EDDIT::addHeader('link', 'canonical', FQDN);
		EDDIT::addHeader('metaproperty','og:url',FQDN.'/');
	}
	else
	{
		EDDIT::addHeader('link', 'canonical', FQDN.EDDIT::url([]));
		EDDIT::addHeader('metaproperty','og:url',FQDN.EDDIT::url([]));
	}
	EDDIT::renderHeaders();
}

EDDIT::renderNode();
// echo '<pre>';
// var_dump(EDDIT::config('defaultLG'));
// echo "\n";
// var_dump(EDDIT::config('eddit'));
// echo '</pre>';
// EDDIT::notice('log notice');
// EDDIT::warning('log warning');
// EDDIT::error('log error');
// $_i18n = EDDIT::i18n('success','xxxeddit');
// var_dump($_i18n);
require_once('eddit/footer.php');
?>
