@extends('common.layout')

@section('title')
Google Book Api
@endsection

@section('content')
<h1>Google Book Api</h1>
<form method="post" id="searchForm">
    <div class="form-group">
        <input type="text" id="keyword" class="w-75" autocomplete="off" placeholder="書籍名">
        <button type="submit" class="btn btn-primary">検索</button>
    </div>
</form>

<div class="w-100">
    <ul id="searchHistory" class="dropdown-menu w-75"></ul>
</div>
<h2 id="searchResult">検索結果</h2>
<h2 id="storeResult" style="display: none;">保存結果</h2>
<div id="results"></div>
<div id="error" class="alert alert-danger" style="display: none;"></div>
@endsection

@section('js')
<script src="{{ asset('bootstrap/js/bootstrap.bundle.js') }}"></script>
<script src="{{ asset('js/search.js') }}"></script>
<script src="{{ asset('js/search_history.js') }}"></script>
@endsection