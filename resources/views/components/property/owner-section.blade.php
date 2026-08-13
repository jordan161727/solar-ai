<x-property.section
    title="Owner"
    description="Who the property belongs to."
>

    <div class="grid gap-4 sm:grid-cols-2">

        <x-property.field
            name="owner_name"
            label="Owner name"
            model="ownerName"
            placeholder="Juan Dela Cruz"
            required
            class="sm:col-span-2"
        />

        <x-property.field
            name="email"
            label="Email address"
            type="email"
            model="ownerEmail"
            placeholder="juan@email.com"
        />

        <x-property.field
            name="phone"
            label="Mobile number"
            model="ownerPhone"
            placeholder="0912 345 6789"
        />

    </div>

</x-property.section>
