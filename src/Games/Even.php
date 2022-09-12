<?php

declare(strict_types=1);

namespace BrainGames\Games\Even;

use function BrainGames\Engine\askUserName;
use function BrainGames\Engine\isEven;
use function BrainGames\Engine\showWelcome;
use function BrainGames\Engine\startGame;
use function cli\line;

use const BrainGames\Engine\NUMBER_OF_ROUNDS;

function run(): void
{
    showWelcome();

    $userName = askUserName();

    line('Answer "yes" if the number is even, otherwise answer "no".');

    $questions = getQuestions(NUMBER_OF_ROUNDS);

    startGame($userName, $questions);
}

function getQuestions(int $questionCount): array
{
    $questions = [];

    foreach (getRandomNumbers($questionCount) as $number) {
        $questions[] = buildQuestion($number, isEven($number));
    }

    return $questions;
}

function buildQuestion(int $number, bool $isEven): array
{
    return [
        'questionText'   => "$number",
        'expectedAnswer' => ($isEven ? 'yes' : 'no'),
    ];
}

function getRandomNumbers(int $count): array
{
    $numbers = [];

    for ($i = 0; $i < $count; $i++) {
        $numbers[] = rand(1, 999);
    }

    return $numbers;
}
