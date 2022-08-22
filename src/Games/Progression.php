<?php

declare(strict_types=1);

namespace BrainGames\Games\Progression;

use function BrainGames\Engine\askUserName;
use function BrainGames\Engine\showWelcome;
use function BrainGames\Engine\startGame;
use function cli\line;

use const BrainGames\Engine\NUMBER_OF_ROUNDS;

const MAX_FIRST_ITEM = 99;
const MAX_STEP_SIZE = 99;
const MIN_PROGRESSION_LENGTH = 5;
const MAX_PROGRESSION_LENGTH = 10;

function run(): void
{
    showWelcome();

    $userName = askUserName();

    line('What number is missing in the progression?');

    $questions = getQuestions(NUMBER_OF_ROUNDS);

    startGame($userName, $questions);
}

function getQuestions(int $questionCount): array
{
    $questions = [];

    foreach (getArithmeticProgressions($questionCount) as $arithmeticProgression) {
        $hiddenItemIndex = rand(0, count($arithmeticProgression) - 1);

        $questions[] = buildQuestion($arithmeticProgression, $hiddenItemIndex);
    }

    return $questions;
}

function getArithmeticProgressions(int $progressionCount): array
{
    $arithmeticProgressions = [];

    for ($i = 0; $i < $progressionCount; $i++) {
        $arithmeticProgressions[] = createArithmeticProgressions(
            getRandomProgressionLength(),
            getRandomFirstItem(),
            getRandomStepSize()
        );
    }

    return $arithmeticProgressions;
}

function createArithmeticProgressions(int $progressionLength, int $firstItem, int $stepSize): array
{
    $lastItem = ($stepSize * $progressionLength) + $firstItem;

    return range($firstItem, $lastItem, $stepSize);
}

function getRandomFirstItem(): int
{
    return rand(1, MAX_FIRST_ITEM);
}

function getRandomStepSize(): int
{
    return rand(1, MAX_STEP_SIZE);
}

function getRandomProgressionLength(): int
{
    return rand(MIN_PROGRESSION_LENGTH, MAX_PROGRESSION_LENGTH);
}

function buildQuestion(array $arithmeticProgression, int $hiddenItemIndex): array
{
    $hiddenItem = $arithmeticProgression[$hiddenItemIndex];
    $arithmeticProgression[$hiddenItemIndex] = '..';

    return [
        'questionText'   => implode(' ', $arithmeticProgression),
        'expectedAnswer' => $hiddenItem,
    ];
}
