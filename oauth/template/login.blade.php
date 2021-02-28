<!-- The top of file index.html -->
<html lang="ja">
  <head>
    <meta name="google-signin-scope" content="profile email https://www.googleapis.com/auth/business.manage">
    <meta name="google-signin-client_id" content="{{$clientID}}">
    <meta charset="utf-8">
    <script
      src="https://code.jquery.com/jquery-3.5.1.min.js"
      integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
      crossorigin="anonymous">
    </script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
  </head>
  <body>
    <!---redirect button--->
    @if($isLogin)
    <a href="http://localhost:8080/oauth/logOut.php">ログアウト</a>
    @else
    <div class="g-signin2" 
      data-onsuccess="onSignIn" 
      data-scope="https://www.googleapis.com/auth/plus.login"
      data-theme="dark">
    </div>
    @endif
    <script src="http://localhost:8080/oauth/public/login.js"></script>
  </body>
</html>
