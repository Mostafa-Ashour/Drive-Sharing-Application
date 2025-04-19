@extends('layouts.app')

@section('content')
    <h1 class="text-center">Hello from edit</h1>
    <div class="container col-6 mt-5">
        <div class="card card-body">
            <form action="{{ route('drives.update', $drive) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control"
                        @error('title') is-invalid @enderror value="{{ $drive->title }}">
                    @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" @error('description') is-invalid @enderror>{{ $drive->description }}</textarea>
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="file" class="form-label">File</label> <a
                        href="{{ asset('drives/' . $drive->file_name) }}" target='blank'>View File</a>
                    <input type="file" name="file" id="file" class="form-control"
                        @error('file') is-invalid @enderror>
                    @error('file')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="text-center">
                    <button class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
