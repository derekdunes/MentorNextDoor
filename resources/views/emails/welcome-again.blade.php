@component('mail::message')
# Introduction

Thanks so much for registering!

@component('mail::button', ['url' => 'https://laracasts.com'])
Start Browsing
@endcomponent

@component('mail::panel', ['url' => 'https://laracasts.com'])
Some inspirational quote to go here. :)
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
