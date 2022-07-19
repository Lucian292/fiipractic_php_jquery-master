<?php
session_start();
$_SESSION["user_is_logged_in"] = false;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row pt-5">
        <div class="col"></div>
        <div class="col">
            <h1>Login</h1>
            <form method="post" action="check_login.php">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input required type="text" name="username" class="form-control" id="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input required type="password" name="password" class="form-control" id="password">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div class="col"></div>
    </div>

</div>
</body>
<script>
    $(document).ready(function () {
        var errorMessage = $.cookie('error_message');
        if (errorMessage) {
            alert(errorMessage)
            $.removeCookie("error_message");
        }
    })

</script>
</html>
