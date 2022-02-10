<?php

use App\Kernel;

require_once sprintf('%s/vendor/autoload_runtime.php', __DIR__.'/../');

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
