<!DOCTYPE html>
<title></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<link rel="stylesheet" type="text/css" href="style.css">
<body>
  <?php
  require_once("vendor/autoload.php");
  $obj_auth=new \phplibrary\Auth();
  $obj_auth->fn_login();
  ?>
  <?php
  function post_captcha($user_response) {
      $fields_string = '';
      $fields = array(
          'secret' => '6LcmZuIUAAAAABqMmfeYR6X8ga1LDB81yQysvi8i',
          'response' => $user_response
      );
      foreach($fields as $key=>$value)
      $fields_string .= $key . '=' . $value . '&';
      $fields_string = rtrim($fields_string, '&');

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
      curl_setopt($ch, CURLOPT_POST, count($fields));
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

      $result = curl_exec($ch);
      curl_close($ch);

      return json_decode($result, true);
  }//END function post_captcha

echo <<<CLIENT
<div class="grid-container">

  <div class="grid-item">
      <form id="myform" method="post">
      <label>Username:</label>
      <input name="login-name" placeholder="Username..." autocomplete="username" required>
      <label>Password:</label>
      <input name="login-pass" placeholder="Password..." autocomplete="password" type="password" required>
      <button type="submit" >Login</button>
      <div class="catpcha-container" style="height:100px">
CLIENT;
    if($obj_auth->server_address!=$obj_auth->local_address){
echo <<<CLIENT
      <div class="g-recaptcha" data-sitekey="6LcmZuIUAAAAAPDkQEV9vCJ0_zYC3XevztFU9JYI"></div>
CLIENT;
    }
echo <<<CLIENT
      </div>
    </form>
  </div>
</div>
</body>
CLIENT;
?>
