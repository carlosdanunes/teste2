@component('mail::message')

Olá, {{ $user->name }}!

Estamos muito contentes de saber que se juntou a {{ config('app.name') }} 😍

É um prazer ter você como nosso cliente, e aqui sua experiência é o mais importante.😍


Temos uma grande seleção de jogos, onde podes ganhar grandes prémios! Até R$ 50.000.000 numa unica jogada! 🤑

Sabia que só aqui na {{ config('app.name') }} você consegue concorrar a MILHÕES DE REAIS EM PRÊMIOS? E o melhor, você concorre só de apostar nos melhores jogos de cassino e nas melhores ODDs do mercado.


@component('mail::button', ['url' => env('FRONT_URL')])
Participar da promoção
@endcomponent

@component('mail::subcopy')
Por favor, jogue com responsabilidade. A {{ config('app.name') }} aceita apenas maiores de 18 anos;
@endcomponent

@endcomponent

