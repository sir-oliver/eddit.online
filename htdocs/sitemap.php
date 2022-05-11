<?php
isset($_GET['view']) || die('Invalid Request');
$view = strip_tags($_GET['view']);
$_GET['lg'] = $view;

define('FQDN', 'http://eddit.probeseite.at');

header('Content-Type: text/xml; charset=UTF-8');
require_once('c+e/header.php');
require_once('c+e/ce.php');
CE::init();

// https://support.google.com/webmasters/answer/189077 ... hreflang implementation

if ($view == 'index')
{
    echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
    echo '<?xml-stylesheet type="text/xsl" href="/sitemap.xsl"?>'.PHP_EOL;
    echo '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;
    foreach (CE::$cache->get('languages') AS $lang)
    {
    	printf("\t".'<sitemap><loc>%s/sitemap_%s.xml</loc></sitemap>'.PHP_EOL, FQDN,$lang['code']);
    }
    echo '</sitemapindex>'.PHP_EOL;
}
else
{
    echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
    echo '<?xml-stylesheet type="text/xsl" href="/sitemap.xsl"?>'.PHP_EOL;
    echo '<urlset ';
    // echo 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ';
    // echo 'xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" ';
    // echo 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" ';
    echo 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;
    $tree = CE::nodesHierarchy(CE::$config["rootPG"]);
    sitemap_worker($tree);
    echo '</urlset>';
}
require_once('c+e/footer.php');


function sitemap_worker($tree)
{
    $tree = (array)$tree;

    foreach($tree AS $id => $node)
    {
        $tableID = '';
        $children = array();
        extract($node, EXTR_IF_EXISTS);

        if($tableID != 'objects') continue;    // wir geben nur knoten vom type "objects" aus!

        $_node = CE::nodes($id);

        if($_node->attr('online') == 0) continue;    // unsichtbare nodes und deren kinder brauchen wir nicht ausgeben

        $_title = $_node->attr('title');

        $_pageType = $_node->attr('type');
        if (isset($_pageType['type']) && $_pageType['type'] == 'forward')
        {
            $_href = FQDN.CE::url(array('pg'=>$_pageType['forward']));
        }
        elseif (isset($_pageType['type']) && $_pageType['type'] == 'external')
        {
            $_href = $_pageType['external'];
        }
        else
        {
            $_href = FQDN.CE::url(array('pg'=>$id));
        }

		printf("\t".'<url><loc>%s</loc></url>'.PHP_EOL, $_href);

        if (isset($node['children']))
        {
            sitemap_worker($children);
        }
    }
}

?>