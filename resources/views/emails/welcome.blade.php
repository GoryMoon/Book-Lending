<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Välkommen, {{ $user->username }}</h2>

        <div>
            Du har blivit tillagd i Smålandsgymnasiets Bokutlånings system<br>
            @if($passType == '0' || $passType == '1')
            Du har fått ett lösenord tilldelat dig, använd detta för att logga in på {!! Html::link('/', 'Bokutlåning') !!}. <br><br>
            Lösenord: <strong>{{ $password }}</strong>
            @else
            Du måste gå till följande länk för att skriva in ditt lösenord {!! Html::link('password/set/'. $token, 'Sätt lösenord') !!} <br><br>

            Om du inte kan klicka på länken, kopiera nedanstående länk och klistra in den i din webbläsare:<br/>
            {!! URL::to('password/set', array($token)) !!}
            @endif
            <!--Du kan byta dit lösenord på sidan under ditt användar namn-->
        </div>
    </body>
</html>
