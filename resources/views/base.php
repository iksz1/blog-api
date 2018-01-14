<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->
        <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet"> -->
        <!-- <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css"> -->
        <link rel="stylesheet" href="/css/cp.css">
        <title>Admin Panel</title>
    </head>
    <body>

        <div id="app" class="main-wrap">
            <header>Admin Panel (demo)</header>
            <div id="content">
                <div id="sidebar">
                    <ul class="nav-side">
                        <li><a href="/">Dashboard</a></li>
                        <li><a href="/posts">Posts</a></li>
                        <li><a href="/comments">Comments</a></li>
                        <li><a href="/users">Users</a></li>
                        <li><a href="/categories">Categories</a></li>
                        <li><a href="/posts/15">single post</a></li>
                    </ul>
                </div>
                <div id="main-content">
                </div>
            </div><!--content-->
            <footer><small>Vclub &copy; 2018</small></footer>
        </div><!--main-wrap-->

        <script src="/js/bundle.js"></script>

    </body>
</html>