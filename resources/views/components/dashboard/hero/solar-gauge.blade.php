@props(['score'=>95])

<div
class="rounded-3xl border border-slate-700 bg-slate-900 p-6">

<h3 class="text-white font-bold">

☀ Solar Score

</h3>

<div class="mt-6 flex justify-center">

<div
class="flex h-44 w-44 items-center justify-center rounded-full border-[14px] border-cyan-500">

<div class="text-center">

<p class="text-5xl font-black text-white">

{{ $score }}%

</p>

<p class="text-cyan-300">

Excellent

</p>

</div>

</div>

</div>

</div>