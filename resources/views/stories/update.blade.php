@extends('layout.layout')

@php
    $title='Admin Panel';
    $subTitle = 'Update Post';
    $script= '<script src="' . asset('assets/js/homeOneChart.js') . '"></script>';
@endphp

@section('content')

    <div class="container mt-5">
        <h1>Edit Story</h1>
        
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('stories.update', $story->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')  <!-- Ensure the form uses PUT method -->

            <div class="mb-3">
                <label for="story_title" class="form-label">Story Title</label>
                <input type="text" name="story_title" id="story_title" class="form-control" value="{{ old('story_title', $story->story_title) }}" required>
            </div>

            <div class="mb-3">
                <label for="story_writer" class="form-label">Story Writer</label>
                <input type="text" name="story_writer" id="story_writer" class="form-control" value="{{ old('story_writer', $story->story_writer) }}" required>
            </div>

            <div class="mb-3">
                <label for="story_date" class="form-label">Story Date</label>
                <input type="date" name="story_date" id="story_date" class="form-control" value="{{ old('story_date', $story->story_date) }}" required>
            </div>

            <div class="mb-3">
                <label for="story_description" class="form-label">Story Description</label>
                <textarea name="story_description" id="story_description" class="form-control" required>{{ old('story_description', $story->story_description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="banner" class="form-label">Banner Image</label>
                <input type="file" name="banner" id="banner" class="form-control">
                @if ($story->banner)
                    <p>Current Banner: <a href="{{ asset('storage/' . $story->banner) }}" target="_blank">View Image</a></p>
                @endif
            </div>

            <div class="mb-3">
                <label for="img" class="form-label">Image</label>
                <input type="file" name="img" id="img" class="form-control">
                @if ($story->img)
                    <p>Current Image: <a href="{{ asset('storage/' . $story->img) }}" target="_blank">View Image</a></p>
                @endif
            </div>

            <div class="mb-3">
                <label for="img1" class="form-label">Image 1</label>
                <input type="file" name="img1" id="img1" class="form-control">
                @if ($story->img1)
                    <p>Current Image 1: <a href="{{ asset('storage/' . $story->img1) }}" target="_blank">View Image</a></p>
                @endif
            </div>

            <div class="mb-3">
                <label for="img2" class="form-label">Image 2</label>
                <input type="file" name="img2" id="img2" class="form-control">
                @if ($story->img2)
                    <p>Current Image 2: <a href="{{ asset('storage/' . $story->img2) }}" target="_blank">View Image</a></p>
                @endif
            </div>

            <div class="mb-3">
                <label for="img3" class="form-label">Image 3</label>
                <input type="file" name="img3" id="img3" class="form-control">
                @if ($story->img3)
                    <p>Current Image 3: <a href="{{ asset('storage/' . $story->img3) }}" target="_blank">View Image</a></p>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update Story</button>
        </form>
    </div>
    @endsection
