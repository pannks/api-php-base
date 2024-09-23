<?php

namespace App\Services\V1;

use App\Config\MailConfig;
use App\Utils\TemplateEngine;
use PHPMailer\PHPMailer\PHPMailer;

class GoogleMailService extends MailService
{
  private MailConfig $config;
  private $templateEngine;

  public function __construct(MailConfig $config)
  {
    $templateDir = __DIR__ . '/../../templates/emails/';
    $this->templateEngine = new TemplateEngine($templateDir, 'html');
    $this->config = $config;
  }

  public function preview($data): string
  {
    $templateName = $data['templateName'];
    if (!isset($data['_validate']) || !$data['_validate'] === false) {
      $this->templateEngine->validate($templateName, (object)$data);
    }
    $template = $this->templateEngine->render($templateName, $data);
    return $template;
  }


  public function send($data): bool
  {
    $headers = [
      'Content-Type: application/x-www-form-urlencoded',
    ];

    $mail = new PHPMailer(true);
    $templateName = $data['templateName'];
    $this->templateEngine->validate($templateName, (object)$data);

    try {
      $mail->isSMTP();
      $mail->Host = $this->config->getSmtpHost();
      $mail->SMTPAuth = true;
      $mail->Username = $this->config->getSmtpUsername();
      $mail->Password = $this->config->getSmtpPassword();
      $mail->SMTPSecure = $this->config->getSmtpEncryption();
      $mail->Port = $this->config->getSmtpPort();

      // Recipients
      $mail->setFrom($data['from'], $data['fromName'] ?? '');
      $mail->addAddress($data['to'], $data['toName'] ?? '');
      $mail->addBCC($data['bcc'] ?? '', $data['bccName'] ?? '');

      $data['buttonUrl'] ??= '';
      $data['buttonText'] ??= 'View Order';

      // Content
      $mail->isHTML(true);
      $mail->Subject = $data['subject'];
      $mail->Body = $this->templateEngine->render($templateName, $data);
      $mail->AltBody = $this->templateEngine->render($templateName, $data);

      $mail->send();
      return true;
    } catch (\Exception $e) {
      error_log('Mail could not be sent. Mailer Error: ' . $mail->ErrorInfo);
      return false;
    }
  }
}
