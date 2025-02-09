@extends('layout.layout')

@php
$title='Edit Footer Text';
$subTitle = 'Search Post';
$script= '<script src="' . asset('assets/js/homeOneChart.js') . '"></script>';
@endphp

@section('content')
<div class="ridgeben-container">
    <div class="ridgeben-large-column">
    <div class="form-container">
    <div class="box-shapes">
        <form action="{{ route('stories.footer.update', $footer->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="text" class="form-label">Footer Text:</label>
                <input type="text" id="text" name="text" value="{{ $footer->text }}" class="form-control" required>
            </div>
            <button type="submit" class="ridgeben-glow-button" style="margin-top: 2%;">Update Footer Text</button>
        </form>
    </div>
    </div>
    </div>
</div>
    @endsection
