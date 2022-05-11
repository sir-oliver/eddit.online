<?php
define('MINIFY_MIN_DIR', dirname(__FILE__));

require 'Minify/config.php';
require "$min_libPath/Minify/Loader.php";
Minify_Loader::register();

Minify::$uploaderHoursBehind = $min_uploaderHoursBehind;
Minify::setCache(
    isset($min_cachePath) ? $min_cachePath : ''
    ,$min_cacheFileLocking
);

if ($min_documentRoot)
{
    $_SERVER['DOCUMENT_ROOT'] = $min_documentRoot;
    Minify::$isDocRootSet = true;
}
$min_serveOptions['minifierOptions']['text/css']['symlinks'] = $min_symlinks;
foreach ($min_symlinks as $uri => $target) 
{
    $min_serveOptions['minApp']['allowDirs'][] = $target;
}
if ($min_allowDebugFlag)
{
    $min_serveOptions['debug'] = Minify_DebugDetector::shouldDebugRequest($_COOKIE, $_GET, $_SERVER['REQUEST_URI']);
}
if (isset($_GET['g']))
{
    $min_serveOptions['minApp']['groups'] = (require MINIFY_MIN_DIR . '/groups.php');
    if (! isset($min_serveController))
    {
        $min_serveController = new Minify_Controller_MinApp();
    }
    Minify::serve($min_serveController, $min_serveOptions);
} 
else
{
    header("Location: /");
    exit();
}