<?php

namespace Max\Aluraplay\Traits;

trait ErrorMessageTrait
{
    private function setErrorMessage(string $message): void
    {
        $_SESSION['error-message'] = $message;
    }
}
