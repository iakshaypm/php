$(document).ready(function () {
    let search_collection = {};
    
    $(".search").on("keyup", function (e) {
        e.preventDefault();


        let table_attr = this.id
        // to get the initail page 
        const urlParams = new URLSearchParams(window.location.search);
        let pageNo = urlParams.get('pages');

        if (pageNo == null) {
            pageNo = 1
        }

        let search_term = $("#" + table_attr).val()
        search_collection[table_attr] = "%"+search_term+"%"

        // stroing in session for pagining purpose
        // sessionStorage.setItem('search', search_collection)
        // sessionStorage.setItem('search_term', search_term)
        console.log(search_collection)
        // $("#" + table_attr).on("keyup", function () {

        // })

        if (!$.isEmptyObject(search_collection)) {

            console.log("arr")
                // sending an ajax request to the search.php
                // to get the search result back
                $.ajax({

                    url: "search.php",
                    method: "POST",
                    data: {
                        table_attr: this.id,
                        search_term: search_collection,
                        default: 'false',
                        page: pageNo
                    },
                    success: function (data) {
                        $("tbody").html(data)
                        // console.log(data)
                    },
                    error: function (err) {
                        console.log(err)
                    },
                });

                // sending a request to navigator.php to get the correct pagination buttom navigation
                $.ajax({

                    url: "search.php",
                    method: "POST",
                    data: {
                        table_attr: this.id,
                        search_term: search_collection,
                        pagenation: "true",
                        default: 'false',
                        page: pageNo
                    },
                    success: function (data) {
                        $("nav").replaceWith(data);
                    },
                    error: function (err) {
                        console.log(err)
                    },
                });

            } else {

                // if search term is removed from the section
                // then to show the orginal table a request is send to
                // default.php
                $.ajax({

                    url: "search.php",
                    method: "POST",
                    data: {
                        default: 'true',
                        page: pageNo
                    },
                    success: function (data) {
                        $("tbody").html(data)
                    },
                    error: function (err) {
                        console.log(err)
                    },
                });

                // sending a request to navigator.php to get the correct pagination buttom navigation
                // for corresponding default page
                $.ajax({

                    url: "search.php",
                    method: "POST",
                    data: {
                        pagenation: "true",
                        default: 'false',
                        page: pageNo
                    },
                    success: function (data) {
                        $("nav").replaceWith(data);
                    },
                    error: function (err) {
                        console.log(err)
                    },
                });
            }
            var uri = window.location.href.toString();
            if (uri.indexOf("?") > 0) {
                var clean_uri = uri.substring(0, uri.indexOf("?"));
                window.history.replaceState({}, document.title, clean_uri);
            }
    });


    $(document).on('click', ".navigate", function (e) {
        e.preventDefault()
        // getting the page number from the curresponding buttons
        // like next, prevoius buttons
        pageNo = $(this).attr("data-page")

        if (pageNo == null) {
            pageNo = 1
        }

        // getting the values from the session that was stored before
        let table_attr = sessionStorage.getItem('table_attr')
        let search_term = sessionStorage.getItem('search_term')
        // console.log(search_term)

        if (search_term != "") {

            // to getting the next page corresponding to the page with
            // offset and limit
            $.ajax({

                url: "search.php",
                method: "POST",
                data: {
                    table_attr: table_attr,
                    search_term: search_term,
                    default: 'false',
                    page: pageNo
                },
                success: function (data) {
                    $("tbody").html(data)
                },
                error: function (err) {
                    console.log(err)
                },
            });

            // sending a request to navigator.php to get the correct pagination buttom navigation
            // for corresponding default page
            $.ajax({

                url: "search.php",
                method: "POST",
                data: {
                    table_attr: table_attr,
                    search_term: search_term,
                    pagenation: "true",
                    default: 'false',
                    page: pageNo
                },
                success: function (data) {
                    $("nav").replaceWith(data);
                },
                error: function (err) {
                    console.log(err)
                },
            });
        }
    });
});