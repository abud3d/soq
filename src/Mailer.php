<?php
declare(strict_types=1); namespace Nshir;
final class Mailer{public static function send(string $to,string $subject,string $body):bool{$from=(string)(getenv('MAIL_FROM')?:'no-reply@nshir.com');return mail($to,$subject,$body,["From: نشر <$from>","Content-Type: text/plain; charset=UTF-8"]);}}
