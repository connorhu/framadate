<?php

namespace Connor\DoReMi;

class Configurator
{
    public static function createConfiguration(): void
    {
        $distConfig = Application::ROOT_DIR . '/config/config.dist.php';
        $configFilePath = Application::ROOT_DIR . '/config/config.php';
        $configContent = file_get_contents($distConfig);

        $replace = [
            'app-name' => '',
            'app-mail' => '',
            'response-mail' => '',
            'db-connection' => '',
            'db-user' => '',
            'db-password' => '',
            'db-table-prefix' => '',
            'db-migration-table' => '',
            'l18n-default-locale' => '',
        ];

        foreach ($replace as $placeholderName => $value) {
            $configContent = str_replace(sprintf('##%s##', $placeholderName), $value, $configContent);
        }

        file_put_contents($configFilePath, $configContent);
    }
}
