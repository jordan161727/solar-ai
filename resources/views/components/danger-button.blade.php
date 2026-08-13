<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-md border-transparent bg-danger text-white hover:opacity-90']) }}>
    {{ $slot }}
</button>
