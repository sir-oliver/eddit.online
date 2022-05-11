{include file='file:header.tpl'}
<header>
	<div class="container">
		<nav class="navbar navbar-expand-md">
			<a class="navbar-brand" href="{url}">LOGO</a>
			<ul class="navbar-nav nav-top w-50">
				<li class="nav-item">
					<a class="nav-link" href="{url}" title="Suche"><img src="https://s3.eu-central-1.amazonaws.com/oekofen-com/layout/header/search.png" alt="Suche"></a>
				</li>
				<li class="dropdown nav-item">
					<a class="nav-link" href="/" title="Sprache"><i class="flag-icon flag-icon-squared flag-icon-{$node->languageID}"></i></a>
				</li>
			</ul>
			<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icons fa"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<form id="topSearchBar" class="text-center easyform animated fadeOutUp" action="{url}" style="">
					<input type="text" name="searchString" id="searchString" required placeholder="{#search_placeholder#}" style="" data-error="{#form_error_empty#}">
				</form>
				{plugin name='nav_bootstrap4' class='navbar-nav justify-content-center w-100' root=2 maxDepth=3}
				<ul class="navbar-nav nav-right">
					<li class="nav-item">
						<a class="nav-link tooltipper" href="{url}" onclick="searchbar_toggle(); return false;" data-toggle="tooltip" data-placement="bottom" data-offset="" title="Suche">SUCHE</a>
					</li>
					<li class="dropdown nav-item">
						<a class="nav-link tooltipper" href="{url}" data-toggle="tooltip" data-placement="bottom" title="Sprache wählen">SPRACHE</a>
					</li>
				</ul>
			</div>
		</nav>
	</div>
</header>
<div class="content">
{EDDIT::renderObjects()}
</div>


<footer>
	<div class="container center-block">
		<div class="row align-items-end">
			<div class="col-md-9">
				<b>SNAKE OIL Ltd.</b><br>
				Fraudster Street 1<br>
				Scammer Town | Wild Wild West<br>
				<a href="mailto:rattle@snakeoil.at">rattle@snakeoil.at</a>
			</div>
			<div class="col-md-3 text-right">
				BOTTOM RIGHT
			</div>
		</div>
	</div>
</footer>

{if 1 && IS_SMESH_IP}
<script src="/min.js?time={$smarty.now}"></script>
{else}
<script src="/min.js?time={$smarty.now}"></script>
{/if}
{if EDDIT::urlParam('clickedit')}
<link rel="stylesheet" href="/c+e/css/iframe-inject.css">
<script src="/c+e/js/iframe-inject.js"></script>
{/if}
{* <script src="/ajax/i18n.php?lg={EDDIT::$languageID}"></script> *}{* lade die i18n der lokalen website *}
</body>
</html>
