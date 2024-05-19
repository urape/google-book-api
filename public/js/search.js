// Google Book Api 取得
$(document).ready(function () {
    $("#searchForm").on("submit", function (e) {
        e.preventDefault();
        const keyword = $("#keyword").val();
        $.ajax({
            url: "/search",
            method: "POST",
            data: { keyword: keyword },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                let results = "";
                data.books.forEach((book) => {
                    results += `<div class="card mb-3">
                                    <div class="row p-2">
                                        <div class="col-md-4">
                                            <img src="${book.small_thumbnail}" class="card-img" alt="Thumbnail">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title">${book.title}</h5>
                                                <h6 class="card-subtitle mb-2 text-muted">${book.authors}</h6>
                                                <p class="card-text">${book.description}</p>
                                                <a href="${book.info_link}" class="card-link">リンク</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                });
                $("#results").html(results);
            },
        });
    });
});
