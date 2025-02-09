@extends('layout.layout')

@php
$title='Ajker Bani Edit';
$subTitle = 'Search Post';
$script= '<script src="' . asset('assets/js/homeOneChart.js') . '"></script>';
@endphp

@section('content')

<div class="ridgeben-container">
    <div class="ridgeben-large-column">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
       
      
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

      
        <form action="{{ route('stories.bani.update', $bani->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="form-label">Bani Writer</label>
                <input type="text" name="bani_writer" value="{{ $bani->bani_writer }}" class="form-control" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Bani</label>
                <input type="text" name="bani" value="{{ $bani->bani }}" class="form-control" required>
            </div>

            <div class="checkboxes__item">
                    <label class="checkbox style-e">
                        <input type="checkbox" />
                        <div class="checkbox__checkmark"></div>
                        <input type="checkbox" name="status" value="1" class="form-checkbox">
                        <div class="checkbox__body">Set as active Bani</div>
                    </label>
                </div>

            <button type="submit" class="ridgeben-glow-button" style="margin-top: 2%; margin-bottom:1%">Update Bani</button>
            <!-- <a href="{{ route('stories.bani.index') }}" class="ml-4 text-gray-600">Cancel</a> -->
        </form>
    </div>
    </div>
</div>

    @endsection
