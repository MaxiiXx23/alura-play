<?php

namespace Max\Aluraplay\Controllers;

abstract class RenderHTMLController
{
    private const TEMPLATE_PATH = __DIR__ . '/../views/';

    protected function renderTemplate(string $templateName, array $context = []): string
    {
        // extraindo dos as variáveis de context
        // É como se fosse um destruction com rest operator do JS/TS
        extract($context);
        // Inicializando um Buff de sair (Output Buffer)
        ob_start();
        require_once self::TEMPLATE_PATH . $templateName . '.php';
        $content = ob_get_clean();
        return $content;
    }
}
