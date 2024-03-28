@component('mail::message')

Olá, {{ $cashout->user->name }}!

É com prazer que informamos que seu saque foi processado com sucesso e os fundos estão a caminho! Agradecemos por escolher a {{ config('app.name') }} para suas atividades de apostas.

Os fundos solicitados foram transferidos da sua conta na plataforma para a sua conta bancária informada através da chave pix.

Detalhes da Solicitação |
:------ |
Valor Solicitado: R$ {{number_format(($cashout->amount / 100), 2, ",", ".")}} |
Data de Transferência: {{$cashout->updated_at->format("d/m/Y H:i")}} |
Chave Pix: {{$cashout->pix_key}}


@component('mail::button', ['url' => env('FRONT_URL')])
    Jogar
@endcomponent

Abraços,<br>
A equipe da {{ config('app.name') }}

@endcomponent

