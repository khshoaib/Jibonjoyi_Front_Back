@extends('layout.layout')

@php
$title='Ajker Bani';
$subTitle = 'Search Post';
$script= '<script src="' . asset('assets/js/homeOneChart.js') . '"></script>';
@endphp

@section('content')

<div class="ridgeben-container">
    <div class="ridgeben-large-column">


        <div class="box-shapes">
        
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


         
            <form action="{{ route('stories.bani.store') }}" method="POST" class="mb-6">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Bani Writer</label>
                    <input type="text" name="bani_writer" class="form-control" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Bani</label>
                    <input type="text" name="bani" class="form-control" required>
                </div>

                <div class="checkboxes__item" style="margin-top: 5%;">
                    <label class="checkbox style-e">
                        <input type="checkbox" />
                        <div class="checkbox__checkmark"></div>
                        <input type="checkbox" name="status" value="1" class="form-checkbox">
                        <div class="checkbox__body">Set as active Bani</div>
                    </label>
                </div>

                <button type="submit" class="ridgeben-glow-button" style="margin-top: 5%;">Add Bani</button>
            </form>
        </div>
    </div>



    <div class="ridgeben-small-column">
        <div class="box-shapes">
    
            <span><b>বানী সমগ্র</b></span>
           
            @foreach($banis as $bani)
            <div class="p-4 mb-3 rounded shadow-sm" style="background-color:rgb(250, 250, 250); margin:20px">
            <p class="form-label">Bani by <span style="color:#005acd"> {{ $bani->bani_writer }}</span></p>
                <p class="form-label" style="background-color:rgb(250, 250, 250);">Bani: {{ $bani->bani }}</p>
                <div class="flex justify-between items-center mt-2">

                <div style="display: flex; align-items: right; gap:10px;">
                 
                    <span class="text-sm {{ $bani->status == 1 ? 'bluish' : 'reddish' }}">
                        {{ $bani->status == 1 ? 'active' : 'inactive' }}
                    </span>

                    <form action="{{ route('bani.toggleStatus', $bani->id) }}" method="POST" class="mr-3">
                        @csrf
                        <button type="submit" 
                                class="{{ $bani->status == 1 ? '' : '' }} enablebtn">
                            {{ $bani->status == 1 ? 'Disable' : 'Enable' }}
                        </button>
                    </form>

                </div>

               
                    <div style="display: flex; align-items: right; gap:10px; margin-top:10px">
                        <a href="{{ route('stories.bani.edit', $bani->id) }}" class="editbtn">Edit</a>

                        <form action="{{ route('stories.bani.destroy', $bani->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="deletebtn ">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
         
            <div class="pagination">
                {{ $banis->links() }}
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