@component('mail::message')

Olá, {{ $cashout->user->name }}!

Queremos informar que recebemos sua solicitação de saque em nossa plataforma.

Estamos trabalhando ativamente para processar a sua transação e garantir que tudo seja executado com eficiência. Nossa equipe de finanças está revisando todos os detalhes para garantir que seu saque seja processado com precisão. Uma vez concluído, você receberá uma notificação de confirmação

Agradecemos pela sua paciência enquanto trabalhamos para concluir essa transação. Continuamos empenhados em oferecer a você a melhor experiência possível em nossa plataforma de apostas.

Detalhes da Solicitação |
:------ |
Valor Solicitado: R$ {{number_format(($cashout->amount / 100), 2, ",", ".")}} |
Data da Solicitação: {{$cashout->created_at->format("d/m/Y H:i")}} |
Chave Pix: {{$cashout->pix_key}}


@component('mail::button', ['url' => env('FRONT_URL')])
    Jogar
@endcomponent

Abraços,<br>
A equipe da {{ config('app.name') }}

@endcomponent

