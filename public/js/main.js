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

    $('#loginModal').on('shown.bs.modal', function () {
        $('#loginEmail').focus()
    })

    $('#dropAdmin').click(function(e) {
       e.preventDefault();
    });

    function search(input) {
        if (input != "") {
            var googleAPI = "http://libris.kb.se/xsearch?query=" + input + " MAT%3a(böcker)&format_level=full&n=20&format=json";
            $.ajax({
                type: 'GET',
                url: googleAPI,
                contentType: "jsonp",
                dataType: "jsonp",
                success: function (response) {
                    console.log(response);
                    for (var i = 0; i < response.xsearch.list.length; i++) {
                        var item = response.xsearch.list[i];

                        if (item.type != "book") {
                            continue;
                        }

                        var isbn = item.isbn;
                        if ((item.isbn != undefined) && (typeof item.isbn != 'string')) {
                            isbn = item.isbn[0];
                        }

                        if (isbn != undefined) {
                            isbn = isbn.replace(/[^0-9A-Z]/g, "");
                        }

                        var title = item.title;
                        var authors = "Författare hittades ej";
                        if (typeof item.creator !== 'string' && item.creator != undefined) {
                            authors = "";
                            for (var j = 0; j < item.creator.length; j++) {
                                authors += item.creator[j].substring(0, item.creator[j].lastIndexOf(",")) + (j == item.creator.length - 1 ? "": "; ");
                            }
                        } else if (item.creator != undefined){
                            authors = item.creator.substring(0, item.creator.lastIndexOf(","));
                        }
                        if (authors == "Författare hittades ej")
                            authors = "";
                        var imageLink = "http://xinfo.libris.kb.se/xinfo/getxinfo?identifier=/PICTURE/bokrondellen/isbn/" + isbn + "/" + isbn + ".jpg/orginal";
                        
                        $('.modal-body').append(
                            "<div class=\"book-model\">" +
                                    "<h2>" + title + "</h2>" + 
                                    "<div class='isbn' hidden value=\"" + isbn + "\"></div>" +
                                    "<i class=\"authors\">" + authors + 
                                    "</i>" +
                                    ((typeof isbn != "undefined") ? "<img class=\"coverImage\" src=\"" + imageLink + "\" alt=\"" + title + "\">": "<img src=\"../../images/no_book_cover.jpg\" alt=\"" + title + "\">") +
                                "</div>");

                        $(".coverImage").error(function() {
                            $( this ).attr("src", "../../images/no_book_cover.jpg");
                        });

                        $('#bookSearch .book-model').click(function() {
                            var isbn = $(this).find(".isbn").attr("value");
                            var title = $(this).find("h2").text();
                            var authors = $(this).find("i").text();
                            var imgSrc = $(this).find("img").attr("src");
                            var input = $('.btn-file :file').parents('.input-group').find(':text');

                            $("#isbn").val(isbn != "undefined" ? isbn: "");
                            $("#title").val(title);
                            $("#author").val(authors);
                            $("#imageUrl").val(imgSrc);
                            input.val(imgSrc);
                            $('#bookSearch').modal("hide");
                        });
                    }
                }
            });
        }
    }

    $("#search-isbn").click(function() {
        var value = $("#isbn").val();
        if (/(^[0-9A-Z]*$)/.test(value) && value.length >= 10) {
            search("NUMM%3a" + $("#isbn").val());
            $("#bookSearch").modal("show");
        }
    });

    $("#search-title").click(function() {
        if (/\S/.test($("#title").val())) {
            search("TIT%3a\"" + encodeURI($("#title").val().replace(" ", "+")) + "\"");
            $("#bookSearch").modal("show");
        }
    });

    $("#bookSearch").on('hidden.bs.modal', function(e) {
        $("#bookSearch .modal-body").empty();
    });

    $(".info, #genre-btn").popover();
    $(".info").click(function(e) {
        e.preventDefault();
    });

    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    function errorLogin() {
        $('#login-error').addClass('alert alert-danger').html('Ogiltlig e-post/lösenord!');
        $('#loginModal').effect('shake', {times:3, distance:15}, 550);
    }
});