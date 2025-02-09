@extends('layout.layout')

@php
    $title='Search for Stories';
    $subTitle = 'Search Post';
    $script= '<script src="' . asset('assets/js/homeOneChart.js') . '"></script>';
@endphp

@section('content')

    <div class="container mt-5">

        <!-- Search Form -->
        <form action="{{ route('stories.searchForm') }}" method="GET">
            @csrf
            <div class="mb-3">
                <label for="story_title" class="form-label">Story Title</label>
                <div style="display: flex; align-items: center; gap: 10px;">
    <input type="text" name="story_title" id="story_title" class="form-control" value="{{ old('story_title') }}" placeholder="Enter story title" style="width: 35%; border-radius:30px">
    <button type="submit" class="ridgeben-glow-button" style="padding: 10px 25px;">Search</button>
</div>

            </div>

           
        </form>

        <!-- Display any validation errors -->
        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>



    <div class="container mt-5">
    <label for="story_title" class="form-label">Showing Result...</label>

        @if ($stories->isEmpty())
    <p>No stories found matching your search criteria.</p>
@else
<div class="table1-container">
<table class="table1 table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Writer</th>
                        <th>Date</th>
                        <th>Banner</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stories as $story)
                        <tr>
                            <td>{{ $story->id }}</td>
                            <td>{{ $story->story_title }}</td>
                            <td>{{ $story->story_writer }}</td>
                            <td>{{ $story->story_date }}</td>
                            
                            <!-- Display Banner Image -->
                            <td>
                               
                                @if($story->banner)
                                    <img src="{{ asset('storage/' . $story->banner) }}" alt="Banner" class="img-fluid">
                                @else
                                    <span>No banner available</span>
                                @endif
                                
                            </td>

                            <!-- Edit Button -->
                            <td>
    <div style="display: flex; align-items: right; gap:10px;">
        <a href="{{ route('stories.edit', $story->id) }}" class="editbtn">Edit</a>
        
        <form action="{{ route('stories.destroy', $story->id) }}" method="POST" class="delete-form">
    @csrf
    @method('DELETE')
    <button type="submit" class="deletebtn">Delete</button>
</form>
    </div>
</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-4" style="margin-bottom: 30px;">
        {{ $stories->links() }}
    </div>
</div>
@endif
    </div>



    <!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Delete Confirmation',
                text: 'Do you really want to delete this story?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4CAF50',
                cancelButtonColor: '#f44336',
                confirmButtonText: '<i class="fa fa-check"></i> Yes, Delete!',
                cancelButtonText: '<i class="fa fa-times"></i> No, Cancel',
                backdrop: `rgba(0,0,123,0.4)`,
                reverseButtons: true,
                customClass: {
                    popup: 'animated fadeInDown'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'The story has been successfully deleted.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    setTimeout(() => form.submit(), 1500);
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        title: 'Cancelled',
                        text: 'Your story is safe!',
                        icon: 'info',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        });
    });
</script>

    @endsection
