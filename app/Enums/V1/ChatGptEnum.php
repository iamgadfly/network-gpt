<?php

declare(strict_types=1);

namespace App\Enums\V1;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ChatGptEnum extends Enum
{

    const TEXT_URL = 'https://api.openai.com/v1/chat/completions';


    const CHAT_V_3_ID = 1;

    const CHAT_V_3_URL = 'https://api.openai.com/v1/chat/completions';

    const ERROR_401 = 'У нас ведутся технические работы, попробуйте позже'; // Неверная аутентификация / Запрашиваемый ключ API неверен / Ваш аккаунт не является частью организации

    const ERROR_429 = 'Вы слишком быстро отправляете запросы / Вы достигли максимального ежемесячного расхода';

    const ERROR_500 = 'Проблема со стороеы ChatGpt';

    const ERROR_503 = 'Серверы ChatGpt испытывают большой трафик';


}
