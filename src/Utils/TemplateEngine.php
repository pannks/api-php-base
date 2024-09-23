<?php

namespace App\Utils;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Utils\Validators\TemplateValidator;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class TemplateEngine
{
  private $twig;
  private $cssInliner;
  private $templateType; // 'html', 'json', or 'txt'
  private $validator;

  public function __construct($templateDir, $templateType = 'html')
  {
    $loader = new FilesystemLoader($templateDir);

    $this->templateType = $templateType;

    // Set autoescape based on template type
    if ($templateType === 'html') {
      $autoescape = 'html';
    } elseif ($templateType === 'json') {
      $autoescape = false;
    } elseif ($templateType === 'txt') {
      $autoescape = false;
    } else {
      throw new \InvalidArgumentException('Unsupported template type: ' . $templateType);
    }

    $this->twig = new Environment($loader, [
      'cache' => __DIR__ . '/../../cache/twig',
      'auto_reload' => true,
      'autoescape' => $autoescape,
      'debug' => true,
    ]);

    // Initialize the CSS inliner if needed
    if ($templateType === 'html') {
      $this->cssInliner = new CssToInlineStyles();
    }

    $this->validator = new TemplateValidator($templateDir);
  }
  public function validate($templateName, $data)
  {
    return $this->validator->validate($templateName, $data);
  }
  public function render($templateName, $data = [])
  {
    // Determine the correct template extension based on template type
    if ($this->templateType === 'html') {
      if (substr($templateName, -10) !== '.html.twig') {
        $templateName .= '.html.twig';
      }

      // Render the template with Twig
      $htmlContent = $this->twig->render($templateName, $data);

      // Extract CSS from the template if any
      preg_match('/<style>(.*?)<\/style>/s', $htmlContent, $matches);
      $css = isset($matches[1]) ? $matches[1] : '';

      // Convert CSS styles to inline styles
      $inlinedHtml = $this->cssInliner->convert($htmlContent, $css);

      return $inlinedHtml;
    } elseif ($this->templateType === 'json') {
      if (substr($templateName, -10) !== '.json.twig') {
        $templateName .= '.json.twig';
      }

      // Render the template with Twig
      $jsonContent = $this->twig->render($templateName, $data);

      // Validate the JSON to ensure it's correctly formatted
      json_decode($jsonContent);
      if (json_last_error() !== JSON_ERROR_NONE) {
        throw new \Exception('Invalid JSON in template: ' . json_last_error_msg());
      }

      return $jsonContent;
    } elseif ($this->templateType === 'txt') {
      if (substr($templateName, -9) !== '.txt.twig') {
        $templateName .= '.txt.twig';
      }

      // Render the template with Twig
      $textContent = $this->twig->render($templateName, $data);

      return $textContent;
    } else {
      throw new \Exception('Unsupported template type: ' . $this->templateType);
    }
  }
}
