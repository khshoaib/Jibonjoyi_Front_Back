<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Ads</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Upload Ads</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('ads.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="vertical_ad1" class="form-label">Vertical Ad 1:</label>
                <input type="file" name="vertical_ad1" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="vertical_ad2" class="form-label">Vertical Ad 2:</label>
                <input type="file" name="vertical_ad2" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="horizontal_ad" class="form-label">Horizontal Ad:</label>
                <input type="file" name="horizontal_ad" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Upload Ads</button>
        </form>
    </div>
</body>
</html>
