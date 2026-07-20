<div class="rounded-3xl border border-slate-800 bg-slate-900 shadow-xl">

    <!-- Header -->
    <div class="border-b border-slate-800 p-6">

        <h2 class="text-2xl font-bold text-white">
            👤 Owner Information
        </h2>

        <p class="mt-2 text-slate-400">
            Enter the property owner's contact information.
        </p>

    </div>

    <!-- Form -->
    <div class="grid grid-cols-1 gap-6 p-6 lg:grid-cols-2">

        <!-- Owner Name -->
        <div>

            <label class="mb-2 block text-sm font-medium text-slate-300">
                Owner Name
            </label>

            <input
                type="text"
                name="owner_name"
                x-model="ownerName"
                value="{{ old('owner_name') }}"
                placeholder="Juan Dela Cruz"
                class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-5 py-4 text-white placeholder:text-slate-500 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">

            @error('owner_name')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror

        </div>


        <!-- Email -->
        <div>

            <label class="mb-2 block text-sm font-medium text-slate-300">
                Email Address
            </label>

            <input
                type="email"
                name="email"
                x-model="ownerEmail"
                value="{{ old('email') }}"
                placeholder="juan@email.com"
                class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-5 py-4 text-white placeholder:text-slate-500 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">

        </div>

        <!-- Phone -->
        <div>

            <label class="mb-2 block text-sm font-medium text-slate-300">
                Mobile Number
            </label>

            <input
                type="text"
                name="phone"
                x-model="ownerPhone"
                value="{{ old('phone') }}"
                placeholder="+63 912 345 6789"
                class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-5 py-4 text-white placeholder:text-slate-500 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">

            @error('phone')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror

        </div>

    
    </div>

</div>