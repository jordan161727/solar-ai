<x-property.section
    title="Review"
    description="Check the details before creating the property."
>

    <dl class="divide-y divide-line">

        @php
            // [label, Alpine expression] — values mirror the wizard state live.
            $rows = [
                ['Owner', "ownerName || 'Not provided'"],
                ['Email', "ownerEmail || 'Not provided'"],
                ['Phone', "ownerPhone || 'Not provided'"],
                ['Property name', "propertyName || 'Not provided'"],
                ['Status', "status || 'Pending'"],
                ['Address', "address || 'Not provided'"],
                ['City / Province', "[city, province].filter(Boolean).join(', ') || 'Not provided'"],
                ['Postal code', "postal_code || 'Not provided'"],
                ['Country', "country || 'Philippines'"],
                // Plain concatenation, not a template literal — PHP would
                // interpolate ${...} inside a double-quoted string.
                ['Coordinates', "(latitude && longitude) ? latitude + ', ' + longitude : 'Not set'"],
            ];
        @endphp

        @foreach($rows as [$label, $expression])
            <div class="flex items-baseline justify-between gap-4 py-2.5 first:pt-0 last:pb-0">
                <dt class="shrink-0 text-sm text-content-muted">{{ $label }}</dt>
                <dd class="min-w-0 break-words text-right text-sm font-medium text-content"
                    x-text="{{ $expression }}"></dd>
            </div>
        @endforeach

    </dl>

</x-property.section>
