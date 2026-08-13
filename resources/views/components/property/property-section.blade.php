<x-property.section
    title="Property"
    description="Basic details about the site."
>

    <div class="grid gap-4 sm:grid-cols-2">

        <x-property.field
            name="property_name"
            label="Property name"
            model="propertyName"
            placeholder="Green Valley Residence"
            required
        />

        <div>
            <label for="status" class="block text-sm font-medium text-content">Status</label>

            <select id="status" name="status" x-model="status" class="input mt-1.5">
                @foreach(['Pending', 'Analyzing', 'Completed'] as $option)
                    <option value="{{ $option }}" @selected(old('status', 'Pending') === $option)>
                        {{ $option }}
                    </option>
                @endforeach
            </select>

            @error('status')
                <p class="mt-1.5 text-sm text-danger">{{ $message }}</p>
            @else
                <p class="mt-1.5 text-xs text-content-subtle">New properties normally start as Pending.</p>
            @enderror
        </div>

    </div>

</x-property.section>
