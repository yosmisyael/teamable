@extends('master')

@section('style')
    @yield('style')
@endsection

<section class="flex h-screen overflow-hidden">
    <x-admin-sidebar/>

    <main class="flex-1 flex flex-col overflow-hidden">
        @yield('main')
    </main>
</section>

