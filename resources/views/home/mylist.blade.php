@extends('layout.app')

@section('content')
<div class="container">
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h2>My List URL</h2>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Original URL</th>
                <th>Short URL</th>
                <th>User ID</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($Myurls as $url)
                <tr>
                    <td><form action="{{ route('urls.update', $url['id']) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input type="text" class="form-control" id="urlori" name="urlori" value="{{ $url['original_url'] }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form></td>
                    <td> <a href="{{$url['original_url']}}" target="_blank">{{ url($url['short_url']) }}</a></td>
                    <td>{{ $url['user_id'] }}</td>
                    <td>{{ $url['created_at'] }}</td>
                    <td>
                        <form action="{{ route('urls.destroy', $url['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this URL?');">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $pagination[1]['url'] ?? '#' }}" tabindex="-1" aria-disabled="true">Previous</a>
            </li>

            @for ($i = 1; $i <= $lastPage; $i++)
                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                    <a class="page-link" href="{{ $pagination[$i]['url'] ?? '#' }}">{{ $i }}</a>
                </li>
            @endfor

            <li class="page-item {{ $currentPage == $lastPage ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $pagination[3]['url'] ?? '#' }}">Next</a>
            </li>
        </ul>
    </nav>
</div>
@endsection
