@props(['disabled' => false])

<input
    @disabled($disabled)
    {{ $attributes->merge([
        'class' =>
            'w-full rounded-lg bg-white text-slate-800 border border-slate-300 px-3 py-2 shadow-sm
             focus:border-blue-600 focus:ring-2 focus:ring-blue-500'
    ]) }}
>
