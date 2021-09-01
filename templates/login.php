<?php
session_start();
if(isset($_SESSION['logged']) && $_SESSION['logged'] = true){
    header("Location: dashboard.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manager Faktur - Zaloguj</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="../css/signin.css" rel="stylesheet">
</head>
<body class="text-center">
<nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="#">ManagerFaktur v1.0.0</a>
</nav>
<div class="alert alert-danger" role="alert">
    <?php if(isset($_SESSION['login_status'])) { echo $_SESSION['login_status']; } ?>
</div>
<form class="form-signin" action="../server/login.php" method="post">
    <h1 class="h3 mb-3 font-weight-normal">
        Zaloguj się
    </h1>
    <label for="loginCode" class="sr-only">
        Kod logowania
    </label>
    <input name="loginCode" type="text" id="loginCode" value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>" class="form-control" placeholder="Kod logowania" required autofocus>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Zaloguj</button>
    <p class="mt-5 mb-3 text-muted">&copy; ManagerFaktur 2019</p>
</form>
</body>
</html>
