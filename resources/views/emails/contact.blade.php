@component('mail::message')

    Hello,

   **Name** {{ $name }}
   
   **Email** {{ $email }}

    {{ $message }}

    Thanks,
    {{ config('app.name') }}
@endcomponent
