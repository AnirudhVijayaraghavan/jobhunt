@extends('layouts.app')

@section('title', 'Job Scraper Home')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-center mb-6">Search Jobs Across the Web</h1>

        {{-- Embed the Livewire JobSearch component --}}
        @livewire('job-search')
    </div>
@endsection
