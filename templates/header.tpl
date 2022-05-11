<!doctype html>
<html lang="{EDDIT::$languageID}">{config_load file="i18n.conf" section=EDDIT::$languageID scope="global"}
<head>
{EDDIT::printHeaders()}
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script> var ce = { nodeID: {EDDIT::$nodeID}, languageID: '{EDDIT::$languageID}', url: '{url}' } </script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
{if 1 && IS_SMESH_IP}
	<link rel="stylesheet" href="/min.css?time={$smarty.now}">
{else}
	<link rel="stylesheet" href="/min.css?time={$smarty.now}">
{/if}
</head>
<body>

