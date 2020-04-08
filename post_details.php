<?php
include('functions.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Comment and reply system in PHP</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
        <link rel="stylesheet" href="main.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>
    <body>
        <div class="container">
            <br />

            <h3 align="center">Post detail</h3><br />
            <br />

            <div class="table-responsive">
                <p align="right">Hi - <?php echo $_SESSION['username']; ?> - <a href="logout.php">Logout</a></p>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 post">
                    <h2><?php echo $post['title'] ?></h2>
                    <p><?php echo $post['body']; ?></p>
                </div>
                <div class="col-md-6 col-md-offset-3 comments-section">
                    <form class="clearfix" action="post_details.php" method="post" id="comment_form">
                        <textarea name="comment_text" id="comment_text" class="form-control" cols="30" rows="3"></textarea>
                        <button class="btn btn-primary btn-sm pull-right" id="submit_comment">Submit comment</button>
                    </form>

                    <!-- Display total number of comments on this post  -->
                    <h2><span id="comments_count"><?php echo count($comments) ?></span> Comment(s)</h2>
                    <hr>
                    <!-- comments wrapper -->
                    <div id="comments-wrapper">
                        <?php if (isset($comments)): ?>
                            <!-- Display comments -->
                            <?php foreach ($comments as $comment): ?>
                                <!-- comment -->
                                <div class="comment clearfix">
                                    <img src="profile.png" alt="" class="profile_pic">
                                    <div class="comment-details">
                                        <span class="comment-name"><?php echo $_SESSION['username'] ?></span>
                                        <span class="comment-date"><?php echo date("F j, Y ", strtotime($comment["created_at"])); ?></span>
                                        <p><?php echo $comment['body']; ?></p>
                                    </div>
                                </div>
                                <!-- // comment -->
                            <?php endforeach ?>
                        <?php else: ?>
                            <h2>Be the first to comment on this post</h2>
                        <?php endif ?>
                    </div><!-- comments wrapper -->
                </div><!-- // all comments -->
            </div>
        </div>
        <!-- Javascripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Bootstrap Javascript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script>
            $(document).ready(function(){
            // When user clicks on submit comment to add comment under post
            $(document).on('click', '#submit_comment', function(e) {
            e.preventDefault();
                    var comment_text = $('#comment_text').val();
                    var url = $('#comment_form').attr('action');
                    // Stop executing if not value is entered
                    if (comment_text === "") return;
                    $.ajax({
                    url: url,
                            type: "POST",
                            data: {
                            comment_text: comment_text,
                                    comment_posted: 1
                            },
                            success: function(data){
                            var response = JSON.parse(data);
                                    if (data === "error") {
                            alert('There was an error adding comment. Please try again');
                            } else {
                            $('#comments-wrapper').prepend(response.comment)
                                    $('#comments_count').text(response.comments_count);
                                    $('#comment_text').val('');
                            }
                            }
                    });
            });
        </script>
    </body>
</html>