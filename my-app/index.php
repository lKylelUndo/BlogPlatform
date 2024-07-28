<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

    <form id="blogForm" class="container bg-light shadow-lg p-5 rounded">
        <h1 class="text-center fs-2 mt-3">Hi Blog Welcome To My Guys!</h1>
        <input id="title" name="title" class="form-control w-50 fs-5 fw-semibold" type="text" placeholder="Titolo...">
        <input id="content" name="content" class="form-control w-50 fw-semibold mt-3" type="text" placeholder="Kaibigan anong nasa isip mo?">
        <button class="mt-3 btn btn-primary">Submit</button>
    </form>

    <div id="blog-section" class="container">
        
    </div>

    <script>
        $(document).ready(function() {
            
            $("#blogForm").submit(function(e) {
                e.preventDefault();

                let formData = $(this).serialize();

                $.ajax({
                    url: "includes/formhandler.php",
                    type: "POST",
                    data: formData,
                    dataType: "json",  // Expect JSON response
                    success: function(data) {
                        if (data.status === "success") {
                            alert(data.message);
                        } else {
                            alert(data.message);
                        }
                        loadBlogs();
                    },
                    error: function(xhr, status, error) {
                        alert("An error occurred: " + status + error);
                    }
                });

                $("#title").val("");
                $("#content").val("");
            });

            $(document).on("submit","#commentForm", function(e) {
                e.preventDefault();

                let postId = $(this).find("input[name='post_id']").val();
                let commentData = $(this).find("input[name='comment']").val();

                $.ajax({
                    url: "includes/comment_handler.php",
                    type: "POST",
                    data: {comment: commentData, post_id: postId},
                    success: function(response) {
                        loadBlogs();
                    }
                })

                $("#comment").val("");
            })

            function loadBlogs() {
                $.ajax({
                    url: "includes/loadBlogs.php",
                    type: "GET",
                    success: function(data) {
                        $("#blog-section").html(data);
                    }
                })
            };

            $(document).on("click", "#delete-btn", function() {
                let titleId = $(this).data("title-id");

                $.ajax({
                    url: "includes/delete_blog.php",
                    type: "GET",
                    data: {titleId},
                    success: function(data) {
                            loadBlogs();
                    },
                    error: function(xhr, status, error) {
                        alert("Error updating: " + error);
                    }
                })
            })

            $(document).on("click", "#edit-btn", function() {
                let titleId = $(this).data("title-id");
                let blogElement = $(this).closest(".shadow.p-4");

                let blogTitle = $("#title-section").text().trim();
                let blogContent = $("#content-section").text().trim();

                blogElement.html(`
                    <input type="text" class="edit-title-input form-control fs-5 fs-semibold" value="${blogTitle}">
                    <input type="text" class="edit-content-input form-control mt-3" value="${blogContent}">
                    <button class="save-btn btn btn-primary container mt-3">Save</button>
                `);

                $(".edit-title-input").focus();
                $(".edit-content-input").focus();

                blogElement.on("click", ".save-btn", function() {
                    let editedTitle = blogElement.find(".edit-title-input").val().trim();
                    let editedContent = blogElement.find(".edit-content-input").val().trim();

                        $.ajax({
                        url: "includes/edit_title_content.php",
                        type: "POST",
                        data: {titleId, editedTitle, editedContent},
                        success: function(data) {
                            loadBlogs();
                        },
                        error: function(xhr, status, error) {
                            alert("Error updating: " + error);
                        }

                    })
                })

            });
            loadBlogs();
            
        });
    </script>
</body>
</html>