@extends('layout.app')

@section('content')

@if (session('auth_token'))
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Short Urls</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('url.shortURL') }}">
                @csrf
                <div class="form-group">
                    <label for="urlori">Urls</label>
                    <input type="text" id="urlori" name="urlori" class="form-control" required>
                </div>
               
                <button type="submit" class="btn btn-primary btn-lg btn-block">Short URL</button>
            </form>
        </div>
    </div>
</div>

@if (isset($shortUrl))
    <div class="card mt-2">
        <div class="card-header text-white bg-success">
            <h3>Short URL:</h3>
        </div>
        <div class="card-body">
            <a href="{{$originalUrl}}" target="_blank">{{ url($shortUrl) }}</a>
        </div>
        <div class="card-footer">
            <button id="copyButton" class="btn btn-success btn-lg btn-block" onclick="copyToClipboard('{{ url($shortUrl) }}')">Copy</button>
        </div>
    </div>
@endif
</div>

<script>
    function copyToClipboard(url) {
        navigator.clipboard.writeText(url).then(function() {
            alert('Copy Success: ' + url);
        }, function(err) {
            alert('Error Copy: ', err);
        });
    }
</script>
@else
<script>
    window.location.href = '/login';
</script>
@endif




@endsection