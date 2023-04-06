<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
<<<<<<< HEAD
};
=======
};
>>>>>>> ee1953f939a5d23ac852813936bc53cdd3126ca8
