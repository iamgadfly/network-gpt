<?php
declare(strict_types=1);

namespace App\Enums\V1;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class YoukassaEnum extends Enum
{

    const PENDING = 'pending';

    const WAITING_FOR_CAPTURE = 'waiting_for_capture';

    const CANCELED = 'canceled';

    const SUCCEESED = 'succeeded';

}
