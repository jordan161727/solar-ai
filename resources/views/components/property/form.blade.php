@props(['action', 'property'])

<form
    method="POST"
    action="{{ $action }}"
    enctype="multipart/form-data"
    class="space-y-8">

    @csrf

    <x-property.owner-section />

    <x-property.property-section />

    <x-property.location-section />

    <x-property.form-actions />

</form>
