@component('mail::message')

Olá, {{ $bet->user->name }}!

Esperamos que esteja aproveitando a emoção das apostas conosco na {{ config('app.name') }}.

Nada se compara à adrenalina de fazer uma aposta e torcer por um resultado favorável.
Queremos celebrar essa jogada com você e desejar-lhe muita sorte! Seja qual for o resultado, estamos felizes por você fazer parte da nossa comunidade de apostadores.

Continue explorando nossos jogos emocionantes, desfrutando das probabilidades competitivas e vivendo a empolgação das apostas esportivas na  {{ config('app.name') }}.

@component('mail::button', ['url' => env('FRONT_URL')])
    Jogar
@endcomponent

Abraços,<br>
A equipe da {{ config('app.name') }}

@endcomponent

