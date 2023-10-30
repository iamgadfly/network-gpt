<?php

declare(strict_types=1);

namespace App\Enums\V1;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StatusWorkEnum extends Enum
{

    const WORKED = 'worked';

    const NOT_WORKED = 'not_worked';

    const BROKEN = 'broken';

}
