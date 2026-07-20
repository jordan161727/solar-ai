@props([
'title',
'value',
'trend'=>'+12%',
'icon'=>'🚀',
'color'=>'cyan'
])

<div
class="rounded-2xl border border-slate-700 bg-slate-900/80 p-6 backdrop-blur transition duration-300 hover:-translate-y-2 hover:border-{{ $color }}-500">

<div class="flex justify-between">

<div>

<p class="text-slate-400">

{{ $title }}

</p>

<h2 class="mt-2 text-4xl font-black text-white">

{{ $value }}

</h2>

<p class="mt-2 text-green-400">

{{ $trend }}

</p>

</div>

<div class="text-5xl">

{{ $icon }}

</div>

</div>

<div class="mt-6 flex items-end gap-1 h-12">

@foreach([20,40,25,60,80,55,100] as $height)

<div
class="w-2 rounded bg-{{ $color }}-500"
style="height:{{$height}}%"></div>

@endforeach

</div>

</div>