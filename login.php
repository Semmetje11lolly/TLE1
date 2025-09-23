<?php  ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log in</title>
</head>
<body>
<h1> Log IN</h1>

<div class="login-container">
    <form method="post" action="login.php">
        <div class="field">

            <div class="control">
                <input class="input" type="text" id="email" name="email" required>
            </div>
        </div>
        <div class="field">
            <label class="label" for="password">Wachtwoord</label>
            <div class="control">
                <input class="input" type="password" id="password" name="password" required>
            </div>
        </div>
        <div class="buttons">
            <button class="button" type="submit">Log in</button>
            <a class="button  href="register.php">Register</a>
        </div>
    </form>
</body>
</html>
