<html>
    <head>
        <title>laravel/lumen HTML</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="chrome-extension://mooikfkahbdckldjjndioackbalphokd/assets/prompt.js"></script>
    </head>
    <body>
        <div style="margin:100px;">
            <div class="jumbotron" style="padding:40px;">
                <h1>Hello!</h1>
                <?php
                    if (!isset($name)) {
                        echo "<p>This is a sample PHP laravel/lumen OIDC application. Try loggin in.</p>";
                        echo "<p><a class=\"btn btn-primary btn-lg\" href=\"/login\" role=\"button\">Login</a></p>";
                    } else {
                        echo "<p>Welcome $name, login successful!</p>";
                        echo "<p><a class=\"btn btn-primary btn-lg\" href=\"/\" role=\"button\">Logout</a></p>";
                    }
                ?>
            </div>
        </div>
    </body>
</html>
