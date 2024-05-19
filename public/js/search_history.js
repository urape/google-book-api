// 検索履歴取得
$(document).ready(function () {
    // 初期表示時に検索履歴を非表示にする
    $("#searchHistoryList").hide();

    // 検索履歴を表示する
    $("#keyword").on("click", function () {
        suggestSearchHistory();
    });

    // 検索履歴非表示にする
    $("#keyword").on("blur", function () {
        $("#searchHistoryList").slideUp();
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
                        historyList += `<li>${history.searched_at}: ${history.keyword}</li>`;
                    });
                    $("#searchHistoryList").html(historyList).slideDown();
                } else {
                    $("#searchHistoryList").slideUp();
                }
            },
        });
    }
});
