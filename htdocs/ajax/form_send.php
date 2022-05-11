<?php
require_once('c+e/header.php');
require_once('c+e/ce.php');
CE::init();
header('Content-Type: text/html; charset=utf8');

if ($formID = CE::requestVar('formID'))	// speichere daten und sende email
{
	/*
		checke das captcha
	*/
	if ($captcha=CE::requestVar('g-recaptcha-response'))
	{
		$publickey = "---";
		$privatekey = "---";
		$response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$privatekey."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);

		if($response['success'] !== true)
		{
			echo '<p class="mt-4">CAPTCHA nicht korrekt oder abgelaufen</p>';
			echo '<p class="mt-4"><a class="btn btn-outline-dark" onclick="resetAjaxForm(this)">Nochmal versuchen</a></p>';
			exit();
		}
	}
	else
	{
		echo '<p class="mt-4">Kein CAPTCHA gesendet</p>';
		echo '<p class="mt-4"><a class="btn btn-outline-dark" onclick="resetAjaxForm(this)">Nochmal versuchen</a></p>';
		exit();
	}
	/*
		checke ob eine korrekte formular ID gesendet wurde
	*/
	$object = new ce_object($formID);
	if ($object == false || $object->templateID != 'form')
	{
		echo '<p class="mt-4">Kein gültiges Formular</p>';
		echo '<p class="mt-4"><a class="btn btn-outline-dark" onclick="resetAjaxForm(this)">Nochmal versuchen</a></p>';
		exit();
	}
	/*
		checke ob formulardaten gesendet wurden
	*/
	if (!$formData = CE::requestVar('i'))
	{
		echo '<p class="mt-4">Keine Daten gesendet</p>';
		echo '<p class="mt-4"><a class="btn btn-outline-dark" onclick="resetAjaxForm(this)">Nochmal versuchen</a></p>';
		exit();
	}
	/*
		checke die absender email adresse
	*/
	$senderEmail = CE::arrayKey('eMail',$formData);
	if ( !preg_match('/^[\w.+-]{2,}\@[\w.-]{2,}\.[a-zA-Z]{2,10}$/',$senderEmail) )
	{
		echo '<p class="mt-4">Ungültige Absende-Email angegeben</p>';
		echo '<p class="mt-4"><a class="btn btn-outline-dark" onclick="resetAjaxForm(this)">Nochmal versuchen</a></p>';
		exit();
	}
	$senderName = CE::arrayKey('Vorname',$formData).' '.CE::arrayKey('Nachname',$formData);
	/*
		checke auf boesen inhalt
	*/
	if ( isset($formData["Nachricht"]) && (preg_match('/http/i',$formData["Nachricht"]) || preg_match('/www\./i',$formData["Nachricht"])))
	{
		syslog(LOG_ERR,__FILE__.' FROM IP '.$_SERVER['REMOTE_ADDR'].' --> BLOCKED (URLs)! --> '.print_r($formData,1));
		echo '<p class="mt-4">KEINE URLs IM TEXT ERLAUBT! / NO URLs IN THE MESSAGE ALLOWED!</p>';
		echo '<p class="mt-4"><a class="btn btn-outline-dark" onclick="resetAjaxForm(this)">Nochmal versuchen</a></p>';
		exit();
	}
	/*
		sende email
	*/
	CE::$smarty->configLoad('i18n.conf',CE::$languageID);
	CE::$smarty->assign('i',$formData);
	include('c+e/mailer.php');
	$mailData = [
		'reply' => $senderEmail,
		'fromName' => CE::arrayKey('Vorname',$formData).' '.CE::arrayKey('Nachname',$formData),
		'to' => $object->attr('email'),
		'toName' => $object->attr('recipient'),
		'subject' => $object->attr('subject'),
		'html' => CE::$smarty->fetch($object->attr('type').'_mail.tpl')
	];
	$done = sendMail($mailData);
	/*
		zeige DANKE seite
	*/
	CE::$smarty->assign('mailError',$done);
	CE::$smarty->assign('postText',$object->attr('postText'));
	CE::$smarty->display($object->attr('type').'_sent.tpl');
	echo '<p class="mt-4"><a class="btn btn-outline-dark" onclick="resetAjaxForm(this)">Ein weiteres Formular senden</a></p>';
}


require_once('c+e/footer.php');
?>