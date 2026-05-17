@component('mail::message')
# Ombi Lako la Ushiriki Limepokelewa

Habari {{ $application->applicant_name }},

Asante kwa kuwasilisha ombi lako la kushiriki katika tuzo za **{{ config('app.name') }}** kwenye kategoria ya **"{{ $application->category->name }}"**.

@php
    $isFreeApplication = (bool) ($application->category->is_free ?? false)
        || (float) ($application->category->nomination_fee ?? 0) <= 0
        || $application->status === \App\Models\NomineeApplication::STATUS_PENDING_REVIEW;
@endphp

@if($isFreeApplication)
Ombi lako ni la kategoria ya bure, hivyo halihitaji malipo.

Timu yetu italipitia ombi lako na utapata mrejesho kupitia akaunti yako.
@else
Ujumbe wa kufanya malipo umetuumwa kwenye namba yako ya simu. Tafadhali kamilisha malipo ili ombi lako liweze kupitiwa.
@endif

Unaweza kufuatilia hali ya ombi lako kupitia akaunti yako.

@component('mail::button', ['url' => route('user.applications.show', $application->id)])
Fuatilia Ombi Lako
@endcomponent

Asante kwa kushiriki!
@endcomponent
