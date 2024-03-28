@component('mail::message')

Olá, {{ $name }}!

Esperamos que você esteja bem e aproveitando todas as emoções que oferecemos em nossa plataforma de apostas.
Nós notamos que faz um tempo desde o seu último depósito conosco, e queremos incentivá-lo a voltar para mais diversão e chances de vitória.

Sabemos o quanto você adora a adrenalina das apostas, então queremos lembrá-lo de que temos uma variedade de jogos emocionantes e odds competitivas que podem levar a grandes vitórias.

**Não deixe essa oportunidade passar!**

Lembre-se de que cada aposta que você faz aumenta suas chances de ganhar e aproveitar a empolgação do mundo das apostas esportivas.
Estamos ansiosos para vê-lo de volta e compartilhar os momentos emocionantes que nossos jogos têm a oferecer.

## Faça um novo depósito hoje e mergulhe de cabeça na diversão!

@component('mail::button', ['url' => env('FRONT_URL')])
    Depositar
@endcomponent

Abraços,<br>
A equipe da {{ config('app.name') }}

@endcomponent

