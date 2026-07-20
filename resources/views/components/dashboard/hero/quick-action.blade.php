@props([
'icon',
'title',
'url'=>'#',
'color'=>'blue'
])

<a
href="{{ $url }}"
class="group rounded-2xl border border-slate-700 bg-slate-900/80 p-6 text-center transition duration-300 hover:-translate-y-2 hover:border-{{ $color }}-500 hover:shadow-xl hover:shadow-{{ $color }}-500/20">

<div class="text-5xl">

{{ $icon }}

</div>

<h3 class="mt-4 font-bold text-white">

{{ $title }}

</h3>

<p class="mt-2 text-sm text-slate-400">

Quick Access

</p>

</a>