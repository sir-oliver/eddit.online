{if $preText != ''}
<div class="my-5">
	{$preText}
</div>
{/if}
<form class="needs-validation ajaxform" novalidate method="POST" action="{url}#kontakt" enctype="multipart/form-data">
	<input type="hidden" name="formID" value="{$formID}">
	<div class="response text-center h3 m-0"></div>
	<div class="form">
		<div class="form-row mb-3">
			<div class="col-md-6">
				<label for="form_anrede">{#form_anrede#}*</label>
				<select type="text" name="i[Anrede]" class="form-control" required id="form_anrede">
					<option value="">{#form_anrede#}</option>
					<option value="Frau">{#form_anrede_frau#}</option>
					<option value="Herr">{#form_anrede_herr#}</option>
				</select>
				<div class="invalid-feedback">
					{#form_anrede_error#}
				</div>
			</div>
		</div>
		<div class="form-row mb-3">
			<div class="col-md-6">
				<label for="form_vorname">{#form_vorname#}*</label>
				<input type="text" name="i[Vorname]" class="form-control" id="{#form_vorname#}" required placeholder="{#form_vorname#}" id="form_vorname">
				<div class="invalid-feedback">
					{#form_vorname_error#}
				</div>
			</div>
			<div class="col-md-6">
				<label for="form_nachname">{#form_nachname#}*</label>
				<input type="text" name="i[Nachname]" class="form-control" id="{#form_nachname#}" required placeholder="{#form_nachname#}" id="form_nachname">
				<div class="invalid-feedback">
					{#form_nachname_error#}
				</div>
			</div>
		</div>
		<div class="mb-3">
			<label for="form_adresse">{#form_adresse#}</label>
			<input type="text" name="i[Adresse]" class="form-control" id="{#form_adresse#}" placeholder="{#form_adresse#}"  id="form_adresse">
			<div class="invalid-feedback">
				{#form_adresse_error#}
			</div>
		</div>
		<div class="form-row mb-3">
				<div class="col">
					<label for="form_plz">{#form_plz#}</label>
					<input type="text" name="i[PLZ]" maxlength="6" class="form-control" id="form_plz" placeholder="{#form_plz#}">
					<div class="invalid-feedback">
						{#form_plz_error#}
					</div>
				</div>
				<div class="col">
					<label for="form_ort">{#form_ort#}</label>
					<input type="text" name="i[Ort]" class="form-control" id="form_ort" placeholder="{#form_ort#}">
					<div class="invalid-feedback">
						{#form_ort_error#}
					</div>
				</div>
{*
				<div class="col">
					<label for="form_land">{#form_land#}</label>
					<select type="text" name="i[Land]" class="form-control" id="form_land">
						<option value="">{#form_land#}</option>
						<option value="AT">{#land_AT#}</option>
						<option value="DE">{#land_DE#}</option>
						<option value="CH">{#land_CH#}</option>
						<option value="IT">{#land_IT#}</option>
						<option value="FR">{#land_FR#}</option>
						<option value="BE">{#land_BE#}</option>
						<option value="NL">{#land_NL#}</option>
						<option value="GB">{#land_GB#}</option>
						<option value="ES">{#land_ES#}</option>
						<option value="US">{#land_US#}</option>
						<option value="CZ">{#land_CZ#}</option>
					</select>
					<div class="invalid-feedback">
						{#form_land_error#}
					</div>
				</div>
*}
		</div>
		<div class="form-row mb-3">
			<div class="col-md-6">
				<label for="form_email">{#form_email#}*</label>
				<input type="text" name="i[eMail]" class="form-control" id="form_email" placeholder="example@example.com" required>
				<div class="invalid-feedback">
					{#form_email_error#}
				</div>
			</div>
			<div class="col-md-6">
				<label for="form_telefon">{#form_telefon#}</label>
				<input type="text" name="i[Tel]" class="form-control" id="form_telefon" placeholder="+00 000 00000000" pattern="{literal}^(?:\+\d{1,3}|0\d{1,3}|00\d{1,2})?(?:\s?\(\d+\))?(?:[-\/\s.]|\d)+${/literal}">
				<div class="invalid-feedback">
					{#form_telefon_error#}
				</div>
			</div>
		</div>
		<div class="mb-3">
			<label for="form_nachricht">{#form_nachricht#}</label>
			<textarea type="text" name="i[Nachricht]" class="form-control" id="form_nachricht" placeholder="{#form_nachricht#}" style="width: 100%; resize: vertical; height: 150px"></textarea>
			<div class="invalid-feedback">
				{#form_nachricht_error#}
			</div>
		</div>
		<div class="form-check mb-5">
			<input class="form-check-input" type="checkbox" id="form_datenschutz" name="i[DataPrivacy]" value="Accept" required>
			<label class="form-check-label" for="form_datenschutz">
			{url|string_format:$smarty.config.form_datenschutz pg=4}
			</label>
			<div class="invalid-feedback">
				{#form_datenschutz_error#}
			</div>
		</div>
		<div class="recaptcha" style="margin: 0 0">
			<script src='https://www.google.com/recaptcha/api.js?hl={$node->languageID}' async defer></script>
			<div id="captcha" style="width: 304px"><div class="g-recaptcha" data-sitekey="6LdMm7wSAAAAAB0zJ58OVBzDIrNshkhh2tcS-T8M" data-callback="captchaSolved"></div></div>
		</div>
		<button id="submitButton" style="display:none" class="submit btn btn-lg btn-block btn-outline-light" type="submit">{#form_send#}</button>
	</div>
</form>
