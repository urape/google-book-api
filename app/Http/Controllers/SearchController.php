<?php

namespace App\Http\Controllers;

use App\Models\SearchHistory;
use App\Models\SearchResult;
use Carbon\Carbon;
use Http;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    public function index()
    {
        return view('book/index');
    }

    public function search(Request $request): JsonResponse
    {
        $keyword = $request->input('keyword');
        // Google Books Api にリクエスト送信
        $response = Http::get('https://www.googleapis.com/books/v1/volumes', [
            'q' => $keyword,
            'maxResults' => 30
        ]);

        // Apiレスポンスから書籍データを取得
        $books_data = $response->json()['items'];

        $books = [];
        foreach ($books_data as $book_data) {
            $volume_info = $book_data['volumeInfo'];
            // データが存在しない場合は''とする
            $books[] = [
                'title' => $volume_info['title'] ?? '',
                'authors' => isset($volume_info['authors']) ? implode(', ', $volume_info['authors']) : '',
                'description' => $volume_info['description'] ?? '',
                'info_link' => $volume_info['infoLink'] ?? '',
                'small_thumbnail' => $volume_info['imageLinks']['smallThumbnail'] ?? ''
            ];
        }

        // 書籍データをjson形式で返す
        return response()->json([
            'books' => $books
        ]);
    }
}
