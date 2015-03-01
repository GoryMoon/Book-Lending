<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Lösenords Återställning</h2>

		<div>
			För att återställa ditt lösenord, följ denna länken: {!! Html::link('password/reset/'. $token, "Återställ lösenord") !!}.<br/>
			Denna länk kommer att upphöra om {{ Config::get('auth.reminder.expire', 60) }} minuter. <br/><br/>

			Om du inte kan klicka på länken, kopiera nedanstående länk och klistra in den i din webbläsare:<br/>
			{!! URL::to('password/reset', array($token)) !!}
		</div>
	</body>
</html>
