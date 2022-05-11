<?php
function ce_plugin_form($params,$smarty)
{
	$formID = CE::arrayKey('id',$params,0);
	$templateBasis = CE::arrayKey('type',$params,'kontakt');
	$recipientEmail = CE::arrayKey('email',$params,'office@networx.at');
	$recipientName = CE::arrayKey('recipient',$params,'networx');
	$subject = CE::arrayKey('subject',$params,'networx');
	$preText = CE::arrayKey('preText',$params,'');
	$postText = CE::arrayKey('postText',$params,'');
	$allowedUploads = '/pdf$/i';
	$data = $smarty->createData($smarty);
	$data->assign('formID',$formID);
	$data->assign('subject',$subject);
	$data->assign('preText',$preText);
	$data->assign('postText',$postText);

	if ($formData = CE::requestVar('i'))	// send it
	{
		/*
			checke das captcha
		*/

		if ($captcha=CE::requestVar('g-recaptcha-response'))
		{
			$publickey = "6LdMm7wSAAAAAB0zJ58OVBzDIrNshkhh2tcS-T8M";
			$privatekey = "6LdMm7wSAAAAANgXBIOrwyqnyT6u69wJqtIsgOBR";
			$response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$privatekey."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
			if($response['success'] === true)
			{
				if  (IS_NETWORX_IP)
				{
					echo 'Captcha solved correctly!<pre>'.print_r($formData,1).'</pre>';
					// return;
				}
			}
			else
			{
				return ('Captcha incorrect! <a href="'.CE::url(array()).'">Please try again.</a>');
			}
		}
		else
		{
			return ('No Captcha sent! <a href="'.CE::url(array()).'">Please try again.</a>');
		}

		/*
			checke die absender email adresse
		*/
		$senderEmail = CE::arrayKey('eMail',$formData);
		if ( !preg_match('/^[\w.+-]{2,}\@[\w.-]{2,}\.[a-zA-Z]{2,10}$/',$senderEmail) )
		{
			return ('Invalid e-mail address. Please try again.');
		}


		/*
			sende email
		*/
		require_once 'PHPMailer/PHPMailerAutoload.php';
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->Host = "mailserver";
		$mail->Port = 25;
		$mail->SMTPAuth = false;
		$mail->CharSet = 'UTF-8';
		$mail->XMailer = 'networx.at HTML mailer @ '.$_SERVER['SERVER_NAME'].''.$_SERVER['REQUEST_URI'];
		$mail->Subject = $subject;
		$mail->setFrom('do-not-reply@networx.at');
		$mail->addAddress($recipientEmail, $recipientName);
		$mail->addReplyTo($senderEmail);
		// $mail->addCC($senderEmail);
		$mail->addBCC('backup@networx.at');

		/*
			checke ob dateien mitgeschickt wurden, wenn ja, fuege sie als attachment ein ...
		*/
		$_attachments = [];
		foreach ($_FILES AS $uploaded)
		{
			if (!empty($uploaded["name"]) && preg_match($allowedUploads,$uploaded["name"]))
			{
				if ( $mail->addAttachment($uploaded["tmp_name"],$uploaded["name"]) )
				{
					$_attachments[] = $uploaded["name"];
					// syslog(LOG_INFO,'Upload added '.print_r($uploaded,1));
				}
				else
				{
					$_attachments[] = '<b style="color:red">Error attaching</b> <b>'. $uploaded["name"].'</b>';
					syslog(LOG_INFO,'Upload not added '.print_r($uploaded,1));
				}
			}
			elseif(!empty($uploaded["name"]))
			{
				$_attachments[] = '<b style="color:red">Error uploading</b> <b>'. $uploaded["name"].'</b> -- file format not allowed.';
				syslog(LOG_INFO,'Upload ignored '.print_r($uploaded,1).' --> '.$allowedUploads);
			}
		}
		$data->assign('attachments',$_attachments);
		$data->assign('i',$formData);

		$mailText = $smarty->fetch('file:'.$templateBasis.'_mail.tpl',$data);
		$mail->msgHTML($mailText);
		$mail->AltBody = $mail->html2text($mailText,true);

		if ((!$mail->send()))
		{
			$errorMsg = $mail->ErrorInfo;
			syslog(LOG_ERR, __FILE__.' --> '.var_export($errorMsg,1));
		}
		else
		{
			$errorMsg = '';
		}
		$data->assign('mailError',$errorMsg);
		$data->assign('mailText',$mailText);
		return $smarty->fetch('file:'.$templateBasis.'_sent.tpl',$data);
	}
	else // show form
	{
		if ( !$smarty->templateExists('file:'.$templateBasis.'_form.tpl') ) return 'Form-Template &quot;'.$templateBasis.'&quot; not found.';
		else return $smarty->fetch('file:'.$templateBasis.'_form.tpl',$data);
	}
}
?>