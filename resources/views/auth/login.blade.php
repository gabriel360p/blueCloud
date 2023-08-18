<!DOCTYPE html>
<!---Coding By CoderGirl | www.codinglabweb.com--->
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login & Registration Form | CoderGirl</title>
  <!---Custom CSS File--->
  <link rel="stylesheet" href="{{asset('/auth/style.css')}}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>
<body>
  <div class="container">
    <div class="login form">
      <header>Logar</header>
      <form action="/login" method="POST">
        @csrf
        <input type="text" name="email" placeholder="Enter your email">
        <input type="password" name="password"  placeholder="Enter your password">
        {{-- <a href="#">Forgot password?</a>  --}}
        <button class="btn btn-primary">Login</button>
      </form>
      <div class="signup">
        <span class="signup">Não tem conta?
         <a href="/register">Registrar</a>
        </span>
      </div>
    </div>
  </div>
</body>
</html>
