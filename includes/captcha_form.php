<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Captcha</title>
</head>

<body>

<form method="post" action="captcha_valida.php">
    <img src="captcha_criar.php" alt="c�digo captcha" height="36" width="128"/>
    <br />
    <label for="captcha">Digite o c�digo</label>
    <input type="text" name="captcha" id="captcha" />

    <br />

    <input type="submit" value="Enviar" />


</form>

</body>

</html>
