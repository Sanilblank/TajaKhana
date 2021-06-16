Hello, {{$mailData['name']}}
<br><br>
Welcome To TajaKhana,
<br><br>
Please Click the following link to activate your email account.
<br><br>
<a href="http://127.0.0.1:8000/verify?code={{$mailData['verification_code']}}">Click Here!</a>
<br><br>
Regards,<br>
TajaKhana.

