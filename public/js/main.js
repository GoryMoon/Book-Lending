$(document).ready(function($) {
    if (typeof showLoginDefault !== 'undefined' && showLoginDefault) {
        $('#loginModal').modal('show');
    }
    $('.form-signin').on('submit', function(e) {
        var btn = $('#login-btn');
        btn.button('loading');

        $.post(
            $(this).prop('action'),
            $(this).serialize(),
            function (data) {
                console.log(data);
                if (data.status == 'error') {
                    errorLogin();
                } else if (data.status == 'success') {
                    location.reload(true);
                }
            },
            'json'
        ).always(function() {
            btn.button('reset');
        }).fail(function() {
            errorLogin();
        });
        return false;
    });

   $('#dropAdmin').click(function(e) {
       e.preventDefault();
   });

    function search(input) {
        if (input != "") {
            var googleAPI = "http://libris.kb.se/xsearch?query=" + input + "&format=json";
            $.ajax({
                type: 'GET',
                url: googleAPI,
                contentType: "jsonp",
                dataType: "jsonp",
                success: function (response) {
                    console.log(response);
                    for (var i = 0; i < response.xsearch.list.length; i++) {
                        var item = response.xsearch.list[i];

                        var isbn = item.isbn;
                        var title = item.title;
                        var authors = item.creator;
                        var imageLink = "http://xinfo.libris.kb.se/xinfo/getxinfo?identifier=/PICTURE/bokrondellen/isbn/" + isbn + "/" + isbn + ".jpg/orginal";
                        
                        $('.modal-body').append(
                            "<div class=\"book-model\">" +
                                    "<h2>" + title + "</h2>" + 
                                    "<i class=\"authors\">" + authors + 
                                    "</i>" +
                                    ((typeof isbn != "undefined") ? "<img class=\"coverImage\" src=\"" + imageLink + "\" alt=\"" + title + "\">": "<img src=\"images/no_book_cover.jpg\" alt=\"" + title + "\">") +
                                "</div>");

                        $(".coverImage").error(function() {
                            $( this ).attr("src", "images/no_book_cover.jpg");
                        });

                        $('#bookSearch .book-model').click(function() {
                            var title = $(this).find("h2").text();
                            var authors = $(this).find("i").text();
                            var imgSrc = $(this).find("img").attr("src");

                            $("#title-in").val(title);
                            $("#author-in").val(authors);
                            $("#imageUrl").val(imgSrc);
                            $('#bookSearch').modal("hide");
                        });
                    }
                }
            });
        }
    }

    $("#search-isbn").click(function() {
        search($("#isbn-in").val());
        $("#bookSearch").modal("show");
    });

    $("#search-title").click(function() {
        search(encodeURI($("#title-in").val().replace(" ", "+")));
        $("#bookSearch").modal("show");
    });

    $("#bookSearch").on('hidden.bs.modal', function(e) {
        $("#bookSearch .modal-body").empty();
    });

    $("#add-genre-btn").click(function(e) {
        e.preventDefault();
        if ($("#new-genre-text").val().length > 0) {
            $("#addGenre").modal('hide');
            var id = $("#add-genre :last-child").val();
            $("#add-genre").append("<option value=" + (id + 1) + ">" + $("#new-genre-text").val() + "</option>");

            $("#add-genre-form").slideUp();
            $("#new-genre-text").val("");
            $('#genre-btn').removeClass("btn-danger").removeClass("fa-times").addClass("btn-success").addClass("fa-plus");
        }
    });

    $(".info, #genre-btn").popover();
    $(".info").click(function(e) {
        e.preventDefault();
    });

    function errorLogin() {
        $('#login-error').addClass('alert alert-danger').html('Ogiltlig e-post/lösenord!');
        $('#loginModal').effect('shake', {times:3, distance:15}, 550);
    }
});