@extends('layouts.app')

@section('content')
    <h1 class="text-center">Hello from index</h1>
    <div class="container col-12 mt-5">
        @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @elseif (Session::has('fail'))
            <div class="alert alert-danger">{{ Session::get('fail') }}</div>
        @endif
        <div class="card card-body table-responsive">
            <h1 class="text-center">Private Files</h1>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Author</th>
                        <th>File Type</th>
                        <th colspan="2" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($drives as $idx => $drive)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>{{ $drive->title }}</td>
                            <td>{{ $drive->description }}</td>
                            <td>{{ $drive->user->name }}</td>
                            <td>{{ $drive->file_type }}</td>
                            <td class="text-center">
                                <a href="{{ route('drives.download', $drive) }}" class="btn btn-success">Download</a>
                                @if ($drive->user_id == auth()->id())
                                    <a href="{{ route('drives.edit', $drive) }}" class="btn btn-warning">Edit</a>
                                    <a href="{{ route('drives.destroy', $drive) }}" class="btn btn-danger">Delete</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="alert alert-info">There is no Data</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
