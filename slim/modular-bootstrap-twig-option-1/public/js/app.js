$( document ).ready(function() {

    /*
    var template = twig({data:
        '<p> {{ message }} ... </p>'
    });

    var html = template.render({
        message: "hello world!", author: "...", published_at: "..."
    });

    var template = twig({
        id: "posts",
        href: "templates/posts.twig",
        // for this example we'll block until the template is loaded
        async: false

        // The default is to load asynchronously, and call the load function
        //   when the template is loaded.

        // load: function(template) { }
    });

    // data from somewhere like an AJAX callback
    posts = {"posts": [{"title":"a","body":"aa"},{"title":"b","body":"bb"},{"title":"c","body":"cc"}]};
    //post = {"title":"a","body":"aa"};

    // render the template
    var postsHTML = twig({ ref: "posts" }).render(posts);

    // Display the rendered template
    document.getElementById("posts").innerHTML = postsHTML;

    console.log(postsHTML);
    */

    var template = {};

    $(".rest-get").click(function(){

        var data = {"name":"John", "age": 34}

        $.ajax({
            type: 'GET',
            //contentType: "application/x-www-form-urlencoded; charset=UTF-8", // this is the default value, so it's optional
            contentType: "application/json; charset=utf-8",
            data: data,
            url: '../js/src/posts.php', // should use the route (base_url + articles/<article-url>) in here.
            dataType: "json", // data type of response
            success: function(data){

                if (typeof template.id === 'undefined') {
                    template = twig({
                        id: "posts",
                        href: "../theme/default/content.twig", // should pass the theme url (base_url + the theme directory) in here.
                        // for this example we'll block until the template is loaded
                        async: false

                        // The default is to load asynchronously, and call the load function
                        //   when the template is loaded.

                        // load: function(template) { }
                    });
                }

                // data from somewhere like an AJAX callback.
                //posts = {"posts": data};
                //posts = {"posts": [{"title":"a","body":"aa"},{"title":"b","body":"bb"},{"title":"c","body":"cc"}]};
                post = {"id":"123","title":"Hello World!","content":"<p>bla bla bla</p>"};

                // render the template
                var postsHTML = twig({ ref: "posts" }).render(post);
                //console.log(postsHTML);

                // Display the rendered template
                document.getElementById("posts").innerHTML = postsHTML;
            }
        });
         return false;
    });

    $(".rest-post").click(function(){
         $.ajax({
            type: 'POST',
            contentType: "multipart/form-data",
            data: { name: "John", location: "Boston" },
            url: 'src/post.php',
            dataType: "json", // data type of response
            success: function(data){

                if (typeof template.id === 'undefined') {
                    template = twig({
                        id: "posts",
                        href: "templates/posts.twig",
                        // for this example we'll block until the template is loaded
                        async: false
                    });
                }

                // data from somewhere like an AJAX callback.
                posts = {"posts": data};

                // render the template
                var postsHTML = twig({ ref: "posts" }).render(posts);

                // Display the rendered template
                document.getElementById("posts").innerHTML = postsHTML;
            }
        });
         return false;
    });

    $(".rest-put").click(function(){
         $.ajax({
            type: 'PUT',
            contentType: "multipart/form-data",
            data: { name: "John", location: "Boston" },
            url: 'src/posts.php',
            dataType: "json", // data type of response
            success: function(){
                //
            }
        });
         return false;
    });

    $(".rest-delete").click(function(){
         $.ajax({
            type: 'DELETE',
            //contentType: "multipart/form-data",
            contentType: "text/html; charset=utf-8",
            data: { id: "123" },
            url: 'src/posts.php',
            dataType: "json", // data type of response
            success: function(){
                //
            }
        });
         return false;
    });

});
