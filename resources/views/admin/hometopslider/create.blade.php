@extends('admin.layout')

@section('content')

<h3>Create Home Top Sliders</h3>

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.hometopslider.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div id="slider-wrapper">

        <div class="slider-item mb-4 border p-3 rounded">
            <label>Title:</label>
            <input type="text" name="titles[]" class="form-control">

            <label>Subtitle:</label>
            <input type="text" name="subtitles[]" class="form-control">

            <label>Button Text:</label>
            <input type="text" name="button_texts[]" class="form-control">

            <label>Button Link:</label>
            <input type="text" name="button_links[]" class="form-control">

            <label>Image:</label>
            <input type="file" class="form-control image-input" name="images[]">
            <img src="" class="preview mt-2" style="max-width:200px; display:none;">

            <button type="button" class="btn btn-danger mt-2 remove-slide">Remove</button>
        </div>

    </div>

    <button type="button" class="btn btn-primary" id="add-slide">+ Add Slide</button>

    <button type="submit" class="btn btn-success ">Save All</button>
</form>

<script>
document.getElementById('add-slide').addEventListener('click', function () {
    let html = document.querySelector('.slider-item').outerHTML;
    document.getElementById('slider-wrapper').insertAdjacentHTML('beforeend', html);
});

document.addEventListener('change', function (e) {
    if (e.target.classList.contains('image-input')) {
        let preview = e.target.nextElementSibling;
        preview.src = URL.createObjectURL(e.target.files[0]);
        preview.style.display = 'block';
    }
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-slide')) {
        e.target.parentElement.remove();
    }
});
</script>

@endsection
