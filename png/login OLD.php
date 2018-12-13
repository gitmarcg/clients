

<head>
<meta charset="utf-8">
<title>Log-In</title>
<link href="css/style.css" rel="stylesheet" />
</head>

<body>
<form action="validation.php" method="post">

  <label>Pseudoo: <input type="text" name="pseudo"/></label><br/>
  <label>Mot de passe: <input type="password" name="passe"/></label><br/>
  <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
  <label>Confirmation du mot de passe: <input type="password" name="passe2"/></label><br/>
  <label>Adresse e-mail: <input type="text" name="email"/></label><br/>
    <div id="remember" class="checkbox">
    <label>
      <input type="checkbox" value="remember-me"> Remember me
    </label>
  </div>
  <input class="btn btn-lg btn-primary btn-block btn-signin" type="submit" value="Connexion"/>

</form>
  
</body>
</html>

