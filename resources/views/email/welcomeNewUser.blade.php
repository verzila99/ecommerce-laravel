@component('mail::message',['name'=>$name])
# Introduction

Welcome, {{ $name }}!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
