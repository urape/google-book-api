<?php

namespace App\Http\Controllers;

use App\Models\SearchHistory;
use App\Models\SearchResult;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(): View
    {
        return view('book/index');
    }

    /**
     * 検索
     * Google Books Api を使用し書籍データを取得する
     */
    public function search(Request $request): JsonResponse
    {
        $keyword = $request->input('keyword');

        // キーワードがない場合はエラー
        if (empty($keyword)) {
            return response()->json([
                'error' => '検索キーワードを入力してください。'
            ], 400);
        }

        // Google Books Api にリクエスト送信
        $response = Http::get('https://www.googleapis.com/books/v1/volumes', [
            'q' => 'intitle:' . $keyword,
            'maxResults' => 30,
        ]);
        if ($response->failed()) {
            return response()->json([
                'error' => 'Google Books APIリクエストに失敗しました。'
            ], 500);
        }

        // Apiレスポンスから書籍データを取得
        $books_data = $response->json()['items'];

        try {
            DB::beginTransaction();

            // 検索キーワードを保存
            $search_history = SearchHistory::create([
                'keyword' => $keyword,
                'searched_at' => Carbon::now(),
            ]);

            $books = [];
            $result_index = 0;
            foreach ($books_data as $book_data) {
                $volume_info = $book_data['volumeInfo'];
                $book = [
                    'search_history_id' => $search_history->id,
                    'title' => $volume_info['title'] ?? '',
                    'authors' => isset($volume_info['authors']) ? implode(', ', $volume_info['authors']) : '',
                    'description' => $volume_info['description'] ?? '',
                    'info_link' => $volume_info['infoLink'] ?? '',
                    'small_thumbnail' => $volume_info['imageLinks']['smallThumbnail'] ?? '',
                ];

                // 検索結果10件を登録する
                if ($result_index < 10) {
                    SearchResult::create($book);
                    $result_index++;
                }

                // 画面表示用に書籍データを追加する
                $books[] = $book;
            }

            DB::commit();

            // 書籍データをjson形式で返す
            return response()->json([
                'books' => $books,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'DB登録処理でエラーとなりました。',
            ], 500);
        }
    }

    /**
     * 検索履歴取得
     */
    public function search_history(): JsonResponse
    {
        // 件数が多いと見づらいので5件とする
        $search_history = SearchHistory::latest()->limit(5)->get();
        return response()->json($search_history);
    }

    /**
     * 検索結果表示
     * 検索履歴に紐づく検索結果を表示する
     */
    public function show_search_result($id): JsonResponse
    {
        $search_history = SearchHistory::with('search_results')->find($id);
        return response()->json($search_history);
    }
}
