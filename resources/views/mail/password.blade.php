<x-mail::message>
# {{ __('otp.otp_subject') }}

{{ __('otp.otp_message') }}

<x-mail::panel>
<h2 style="text-align: center; font-size: 32px; font-weight: bold; color: #2d3748; margin: 0; letter-spacing: 8px; font-family: 'Courier New', monospace;">
{{ $otp }}
</h2>
</x-mail::panel>

<div style="margin-top: 20px;">
{{ __('otp.otp_validity') }}
</div>

<div style="margin-top: 15px; color: #718096; font-size: 14px;">
{{ __('otp.otp_ignore') }}
</div>


{{ __('otp.thanks') }}<br>
**{{ config('app.name') }}**
</x-mail::message>
