<?php

declare(strict_types=1);

namespace BrainGames\Cli;

use function BrainGames\Engine\askUserName;
use function BrainGames\Engine\showWelcome;

function run(): void
{
    showWelcome();

    askUserName();
}
