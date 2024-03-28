@component('mail::message')

Olá, {{ $name }}!

Estamos felizes por você ter se juntado à {{ config('app.name') }}! Agora é o momento perfeito para dar o primeiro passo emocionante em nossa plataforma.

Para começar sua aventura conosco, queremos lembrá-lo de que você pode aproveitar ao máximo fazendo o seu primeiro depósito.
Este é um passo importante para entrar no mundo das apostas e experimentar todos os jogos incríveis que temos a oferecer.

Estamos ansiosos para acompanhá-lo em sua jornada conosco. Seja bem-vindo à {{ config('app.name') }}! A diversão está apenas começando.

@component('mail::button', ['url' => env('FRONT_URL')])
    Depositar
@endcomponent

Abraços,<br>
A equipe da {{ config('app.name') }}

@endcomponent

