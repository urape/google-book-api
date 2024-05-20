// 検索履歴取得
$(document).ready(function () {
    // 初期表示時に検索履歴を非表示にする
    $("#searchHistory").hide();

    // 検索履歴を表示する
    $("#keyword").on("click", function () {
        suggestSearchHistory();
    });

    // 検索履歴非表示にする
    $("#keyword").on("blur", function () {
        $("#searchHistory").slideUp();
    });

    // 検索履歴を表示する
    function suggestSearchHistory() {
        $.ajax({
            url: "/search-history",
            method: "GET",
            success: function (data) {
                let historyList = "";
                if (data.length > 0) {
                    data.forEach(function (history) {
                        // 検索日時 + キーワード表示
                        historyList += `<li class="dropdown-item" data-history-id="${history.id}" data-history-keyword="${history.keyword}">
                                            ${history.searched_at}: ${history.keyword}
                                        </li>`;
                    });
                    $("#searchHistory").html(historyList).slideDown();
                } else {
                    $("#searchHistory").slideUp();
                }
            },
        });
    }

    // 検索履歴クリック時
    $(document).on("click", ".dropdown-item", function () {
        const historyId = $(this).data("history-id");
        const keyword = $(this).data("history-keyword");
        // 入力エリアにキーワードを設定
        $("#keyword").val(keyword);

        $("#searchResult").hide();
        $("#storeResult").show();

        // 検索結果を表示する
        displayHistoryData(historyId);
    });

    // 選択された検索履歴のデータ表示する
    function displayHistoryData(historyId) {
        $.ajax({
            url: `/search-history/${historyId}`,
            method: "GET",
            success: function (data) {
                let booksList = "";
                if (data.search_results.length > 0) {
                    data.search_results.forEach(function (result) {
                        booksList += `<div class="card mb-3">
                                        <div class="row p-2">
                                            <div class="col-md-4">
                                                <img src="${result.small_thumbnail}" class="card-img" alt="Thumbnail">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h5 class="card-title">${result.title}</h5>
                                                    <h6 class="card-subtitle mb-2 text-muted">${result.authors}</h6>
                                                    <p class="card-text">${result.description}</p>
                                                    <a href="${result.info_link}" class="card-link">リンク</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                    });
                    $("#results").html(booksList);
                } else {
                    $("#results").html("<p>検索結果がありませんでした。</p>");
                }
            },
        });
    }
});
