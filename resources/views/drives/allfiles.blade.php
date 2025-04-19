@extends('layouts.app')

@section('content')
    <h1 class="text-center">
        Hello from All Files</h1>
    <div class="container col-10 mt-5">
        @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="card card-body table-responsive">
            <h1 class="text-center">All Files</h1>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>File Type</th>
                        <th>Status</th>
                        <th colspan="2" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($drives as $idx => $drive)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>{{ $drive->title }}</td>
                            <td>{{ $drive->description }}</td>
                            <td>{{ $drive->file_type }}</td>
                            <td>
                                <a href="{{ route('drives.status', $drive->id) }}"
                                    class="btn @if ($drive->status === 'public') btn-success @else btn-warning @endif">
                                    @if ($drive->status === 'public')
                                        Public
                                    @else
                                        Private
                                    @endif
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('drives.edit', $drive->id) }}" class="btn btn-warning">Edit</a>
                                <a href="{{ route('drives.destroy', $drive->id) }}" class="btn btn-danger">Delete</a>
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
