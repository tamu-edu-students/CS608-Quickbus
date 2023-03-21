<!DOCTYPE html>
<html lang="en">

<head>
  <title>QuickBus</title>


  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <style>
    body {
      background-image: url(img/backg.png);
    }
  </style>

</head>

<body>
  <div class="container">
    <div class="header">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="signin.php">Sign in</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="#">Sign up</a>
            </li>
          </ul>

        </div>
      </nav>

      <h3 class="text-muted">Travel booking system</h3>
    </div>

    <div class="jumbotron">
      <h1>Sign up</h1>
      <form class="form-signin" action="/register.php" method="post">
        <label for="inputName" class="sr-only">Name</label>
        <input type="name" name="inputName" id="inputName" class="form-control" placeholder="Name" required autofocus>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>

        <button id="btnSignUp" class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
      </form>
    </div>

  </div>
</body>

</html>