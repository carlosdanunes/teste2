@component('mail::message')

Olá, {{ $deposit->user->name }}!

Temos o prazer de informar que o seu depósito foi recebido com sucesso e está pronto para ação!

Na {{ config('app.name') }}, estamos empolgados por tê-lo(a) como parte da nossa comunidade de apostadores.

Agora você está pronto para explorar as diversas opções de jogos e aproveitar a adrenalina das nossas emocionantes oportunidades de apostas e muito mais

Agradecemos por escolher a {{ config('app.name') }} como seu destino de entretenimento de apostas.
Boa sorte em suas apostas e que venham grandes vitórias!

Detalhes da Transação |
:------ |
Valor Depositado: R$ {{number_format(($deposit->amount / 100), 2, ",", ".")}} |
Data do Depósito: {{$deposit->created_at->format("d/m/Y H:i")}}


@component('mail::button', ['url' => env('FRONT_URL')])
    Jogar
@endcomponent

Abraços,<br>
A equipe da {{ config('app.name') }}

@endcomponent

