@extends('layouts.admin') 

@section('content')
<section class="max-w-4xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
    
    {{-- Botón volver --}}
    <a href="{{ route('admin.dashboard') }}"
        class="inline-flex items-center gap-2 mb-8 px-4 py-2 rounded-xl border border-slate-200 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">
            <i class="fa-solid fa-arrow-left"></i> Volver al Panel
    </a>

    <h2 class="text-2xl font-bold text-slate-900 mb-6">Información del perfil</h2>

    <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700">Nombre</label>
            <input type="text" name="name" id="name" 
                value="{{ old('name', Auth::user()->name) }}" 
                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-[#1a233a] focus:ring-[#1a233a]">
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Correo electrónico</label>
            <input type="email" name="email" id="email" 
                value="{{ old('email', Auth::user()->email) }}" 
                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-[#1a233a] focus:ring-[#1a233a]">
        </div>

        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-[#1a233a] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#303a58]">
            <i class="fa-solid fa-floppy-disk"></i> GUARDAR
        </button>
    </form>
</section>
@endsection
