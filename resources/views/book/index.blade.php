@extends('common.layout')

@section('title')
Google Book Api
@endsection

@section('content')
<h1>Google Book Api</h1>
<form method="post" id="searchForm">
    <div class="form-group">
        <input type="text" id="keyword" class="w-75" placeholder="書籍名">
        <button type="submit" class="btn btn-primary">検索</button>
    </div>
</form>

<h2>検索結果</h2>
<div id="results"></div>
<div id="error" class="alert alert-danger" style="display: none;"></div>
@endsection

@section('js')
<script src="{{ asset('js/search.js') }}"></script>
@endsection