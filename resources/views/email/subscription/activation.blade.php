@component('mail::message')
# Introduction

Подравляем!Вы подписались на рассылку новостей об акциях и скидках.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
