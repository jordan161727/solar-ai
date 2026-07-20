<aside class="w-72 bg-slate-900 text-white">

    <div class="p-8">

        <h2 class="text-3xl font-bold">

            SolarAI

        </h2>

    </div>

    <nav>

      @foreach(config('navigation') as $item)

        <a
        href="{{ route($item['url']) }}"
        class="block px-8 py-4 hover:bg-slate-800">

        {{ $item['title'] }}

        </a>

    @endforeach

    </nav>

</aside>