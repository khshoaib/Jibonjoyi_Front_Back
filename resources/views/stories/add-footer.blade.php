@extends('layout.layout')

@php
$title='Add Footer Text';
$subTitle = 'Search Post';
$script= '<script src="' . asset('assets/js/homeOneChart.js') . '"></script>';
@endphp

@section('content')

<div class="ridgeben-container">
    <div class="ridgeben-large-column">

    <div class="form-container">

    <div class="box-shapes">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif
        
        <form action="{{ route('stories.footer.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="text" class="form-label">Footer Text</label>
                <input type="text" id="text" name="text" class="form-control" placeholder="Enter footer text..." required>
            </div>
            <button type="submit" class="ridgeben-glow-button" style="margin-top: 3%;">Add Footer Text</button>
        </form>
    </div>
    </div>
    </div>


    <div class="ridgeben-small-column">
    <div class="footer-list">
    <div class="box-shapes">
        <p class="form-label">Existing Footer Texts</p>
        @if($footer_texts->isEmpty())
            <p style="text-align: center;">No footer texts added yet.</p>
        @else
            @foreach($footer_texts as $footer)
                <div class="footer-item" style="background-color:rgb(237, 243, 255); border-radius:10px; margin-bottom:2%; padding:2%">
                    <span>{{ $footer->text }}
                        <strong>({{ $footer->status ? 'Visible' : 'Hidden' }})</strong>
                    </span>
                    <div>
                        <a href="{{ route('stories.footer.edit', $footer->id) }}" class="editbtn">Edit</a>

                        <form action="{{ route('stories.footer.toggleStatus', $footer->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="ridgeben-glow-button"
                                style=" padding: 6px 12px; color: white; border: none; cursor: pointer;">
                                {{ $footer->status ? 'Hide' : 'Show' }}
                            </button>
                        </form>

                        <form action="{{ route('stories.footer.destroy', $footer->id) }}" method="POST" style="display:inline;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="deletebtn" >Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif

        <div class="pagination">
                {{ $footer_texts->links() }}
            </div>
    </div>
    </div>
</div>
</div>




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