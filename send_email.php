<?php

define('EMAILING_TEMPLATE', 'assets/email/your-email-template.html');
define('EMAILING_RECIPIENT', 'test@domain.topdomain');
define('EMAILING_SENDER', 'noreply@domain.topcomain');
define('EMAILING_SUBJECT', 'Quick e-mailing');
define('EMAILING_SUCCESS_URL', 'email_success.php');
define('EMAILING_FAILURE_URL', 'email_failure.php');
    
require_once 'classes/class.EmailTemplate.php';
require_once 'classes/class.Dispatcher.php';

$template = new EmailTemplate(EMAILING_TEMPLATE);
foreach ($_POST as $key => $value) {
    $template->add($key, $value);
}

try {
    $mail = new Dispatcher(EMAILING_RECIPIENT, EMAILING_SENDER, EMAILING_SUBJECT, $template);
    $mail->send();

    header('Location: '.EMAILING_SUCCESS_URL.'?e-mailsuccess=true');

} catch (Exception $e) {
    // the error is stored in a domain-wide cookie with the name email-error.
    setcookie('email-error', $e->getMessage(), time() + 60*60*20, '/');
    header('Location: '.EMAILING_FAILURE_URL.'?e-mailsuccess=false');
}
