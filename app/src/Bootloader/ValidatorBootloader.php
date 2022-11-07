<?php

declare(strict_types=1);

namespace App\Bootloader;

use App\Security\ValidationRules;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Validator\Bootloader\ValidatorBootloader as BaseValidatorBootloader;

final class ValidatorBootloader extends Bootloader
{
    public function boot(BaseValidatorBootloader $bootloader)
    {
        $bootloader->addChecker('custom', ValidationRules::class);
    }
}
