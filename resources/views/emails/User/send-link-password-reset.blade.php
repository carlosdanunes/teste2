@component('mail::message')
# Redefinição de senha

Olá, este email está sendo enviado pois alguém, possivelmente você, clicou no link "esqueci a minha senha".

Para redefinir sua senha, clique no link abaixo:

@component('mail::button', ['url' => env('FRONT_URL') . '/recovery-password/' . $token])
    Redefinir Senha
@endcomponent

Caso não consiga acessar o link acima, copie e cole no seu navegador:
{{ env('FRONT_URL') . '/recovery-password/' . $token }}

Se você não fez essa solicitação, desconsidere este e-mail.

Abraços,<br>
A equipe da {{ config('app.name') }}
@endcomponent
