<div class="rounded-3xl border border-slate-800 bg-slate-900 p-8">

    <h2 class="text-2xl font-bold text-white mb-6">

        ⚡ Energy Information

    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div>

            <label class="text-slate-400">

                Monthly Bill

            </label>

            <input
                type="number"
                name="monthly_bill"
                class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-800 p-3 text-white">

        </div>

        <div>

            <label class="text-slate-400">

                Monthly Consumption (kWh)

            </label>

            <input
                type="number"
                name="monthly_consumption"
                class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-800 p-3 text-white">

        </div>

        <div>

            <label class="text-slate-400">

                Utility Company

            </label>

            <select
                name="utility_company"
                class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-800 p-3 text-white">

                <option>MERALCO</option>
                <option>VECO</option>
                <option>DLPC</option>
                <option>OTHER</option>

            </select>

        </div>

    </div>

</div>