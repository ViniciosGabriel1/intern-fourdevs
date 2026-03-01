@extends('errors::minimal')

@section('title', __('Acesso Negado'))
@section('code', '403')

@section('message')
    <div class="flex flex-col items-center">
        {{-- Mensagem de Erro --}}
        <div class="mb-4">
            {{ __($exception->getMessage() ?: 'Você não tem permissão para acessar esta página.') }}
        </div>

        {{-- Botão de Voltar --}}
        <a href="{{ url()->previous() == url()->current() ? url('/admin') : url()->previous() }}" 
           style="margin-top: 20px; margin:10%; text-decoration: none; padding: 10px 20px; background-color: #fbbf24; color: #000; border-radius: 8px; font-weight: bold; font-family: ui-sans-serif, system-ui, sans-serif;">
            ← Voltar
        </a>
    </div>
@endsection