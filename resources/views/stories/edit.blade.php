@extends('layout.layout')

@php
    $title='Edit Post';
    $subTitle = 'Edit Post';
    $script= '<script src="' . asset('assets/js/homeOneChart.js') . '"></script>';
@endphp

@section('content')

<div class="ridgeben-container">
    <div class="ridgeben-large-column">
        <div class="box-shapes">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('stories.update', $story->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="story_title" class="form-label">Story Title</label>
                    <input type="text" name="story_title" id="story_title" class="form-control" value="{{ old('story_title', $story->story_title) }}" required>
                </div>

                <div class="mb-3">
                    <label for="story_writer" class="form-label">Story Writer</label>
                    <input type="text" name="story_writer" id="story_writer" class="form-control" value="{{ old('story_writer', $story->story_writer) }}" required>
                </div>
        </div>

        <div class="box-shapes" style="margin-top: 5%;">
            <div class="mb-3">
                <label for="story_date" class="form-label">Story Date</label>
                <input type="date" name="story_date" id="story_date" class="form-control" value="{{ old('story_date', $story->story_date) }}" required>
            </div>

            <div class="mb-3">
<label for="story_category" class="form-label">Story Prime Category</label>
<select name="story_category" id="story_category" class="form-control" required>
    <option value="">Select Category</option>
    <option value="ইতিহাস" {{ old('story_category') == 'ইতিহাস' ? 'selected' : '' }}>ইতিহাস</option>
    <option value="দর্শন" {{ old('story_category') == 'দর্শন' ? 'selected' : '' }}>দর্শন</option>
    <option value="ধর্ম" {{ old('story_category') == 'ধর্ম' ? 'selected' : '' }}>ধর্ম</option>
    <option value="ভ্রমণ" {{ old('story_category') == 'ভ্রমণ' ? 'selected' : '' }}>ভ্রমণ</option>
    <option value="খেলাধুলা" {{ old('story_category') == 'খেলাধুলা' ? 'selected' : '' }}>খেলাধুলা</option>
    <option value="সাহিত্য" {{ old('story_category') == 'সাহিত্য' ? 'selected' : '' }}>সাহিত্য</option>
    <option value="মুক্তিযুদ্ধ" {{ old('story_category') == 'মুক্তিযুদ্ধ' ? 'selected' : '' }}>মুক্তিযুদ্ধ</option>
    <option value="অর্থনীতি" {{ old('story_category') == 'অর্থনীতি' ? 'selected' : '' }}>অর্থনীতি</option>
    <option value="রাজনীতি" {{ old('story_category') == 'রাজনীতি' ? 'selected' : '' }}>রাজনীতি</option>
    <option value="বিজ্ঞান" {{ old('story_category') == 'বিজ্ঞান' ? 'selected' : '' }}>বিজ্ঞান</option>
    <option value="বিশ্ব" {{ old('story_category') == 'বিশ্ব' ? 'selected' : '' }}>বিশ্ব</option>
</select>

        </div>

        <!-- Story Category 1 (Add this field to match controller validation) -->
        <div class="mb-3">
        <label for="story_category1" class="form-label">Story Sub Category</label>
<select name="story_category1" id="story_category1" class="form-control" required>
    <option value="">Select Category</option>
    <option value="ইতিহাস" {{ old('story_category1') == 'ইতিহাস' ? 'selected' : '' }}>ইতিহাস</option>
    <option value="দর্শন" {{ old('story_category1') == 'দর্শন' ? 'selected' : '' }}>দর্শন</option>
    <option value="ধর্ম" {{ old('story_category1') == 'ধর্ম' ? 'selected' : '' }}>ধর্ম</option>
    <option value="ভ্রমণ" {{ old('story_category1') == 'ভ্রমণ' ? 'selected' : '' }}>ভ্রমণ</option>
    <option value="খেলাধুলা" {{ old('story_category1') == 'খেলাধুলা' ? 'selected' : '' }}>খেলাধুলা</option>
    <option value="সাহিত্য" {{ old('story_category1') == 'সাহিত্য' ? 'selected' : '' }}>সাহিত্য</option>
    <option value="মুক্তিযুদ্ধ" {{ old('story_category1') == 'মুক্তিযুদ্ধ' ? 'selected' : '' }}>মুক্তিযুদ্ধ</option>
    <option value="অর্থনীতি" {{ old('story_category1') == 'অর্থনীতি' ? 'selected' : '' }}>অর্থনীতি</option>
    <option value="রাজনীতি" {{ old('story_category1') == 'রাজনীতি' ? 'selected' : '' }}>রাজনীতি</option>
    <option value="বিজ্ঞান" {{ old('story_category1') == 'বিজ্ঞান' ? 'selected' : '' }}>বিজ্ঞান</option>
    <option value="বিশ্ব" {{ old('story_category1') == 'বিশ্ব' ? 'selected' : '' }}>বিশ্ব</option>
</select>

        </div>
        </div>

        <div class="box-shapes" style="margin-top: 5%;">
            <div class="mb-3">
                <label for="banner" class="form-label">Banner</label>
                <input type="file" name="banner" id="banner" class="form-control">
                @if ($story->banner)
                    <p>Current Banner:</p>
                    <img src="{{ asset('storage/' . $story->banner) }}" alt="Banner" class="img-fluid" style="max-height: 100px;">
                @endif
            </div>
        </div>
    </div>

    <div class="ridgeben-small-column">
        <div class="box-shapes">
            <div class="mb-3">
                <label for="story_description" class="form-label">Story Description</label>
                <textarea name="story_description" id="story_description" class="form-control" required>{{ old('story_description', $story->story_description) }}</textarea>
            </div>

            <label for="story_details" class="form-label">Story Details</label>
            <textarea name="story_details" id="story_details" class="ckeditor" required>{{ old('story_details', $story->story_details) }}</textarea>
        </div>

        <div class="box-shapes" style="margin-top: 2%;">
            <label for="story_rating" class="form-label">Story Rating</label>
            <div class="star-rating">
                @for ($i = 5; $i >= 1; $i--)
                    <input type="radio" id="star{{ $i }}" name="story_rating" value="{{ $i }}" class="star-input" {{ old('story_rating', $story->story_rating) == $i ? 'checked' : '' }}>
                    <label for="star{{ $i }}" class="star">&#9733;</label>
                @endfor
            </div>
        </div>

        <button type="submit" class="ridgeben-glow-button" style="margin-top: 3%;">Update Story</button>
    </div>
</div>
<script src="/ckeditor/ckeditor.js"></script>
    @endsection