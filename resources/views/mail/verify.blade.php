<x-mail::message>
# {{ __('otp.otp_subject') }}

{{ __('otp.otp_message') }}

<x-mail::panel>
    <h2 style="text-align: center; font-size: 24px;">{{ $otp }}</h2>
</x-mail::panel>

{{ __('otp.otp_validity') }}
{{ __('otp.otp_ignore') }}

{{ __('otp.thanks') }}
{{ config('app.name') }}
</x-mail::message>
