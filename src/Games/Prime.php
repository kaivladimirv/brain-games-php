<?php

declare(strict_types=1);

namespace BrainGames\Games\Prime;

use function BrainGames\Engine\askUserName;
use function BrainGames\Engine\showWelcome;
use function BrainGames\Engine\startGame;
use function cli\line;

use const BrainGames\Engine\NUMBER_OF_ROUNDS;

function run(): void
{
    showWelcome();

    $userName = askUserName();

    line('Answer "yes" if given number is prime. Otherwise answer "no".');

    $questions = getQuestions(NUMBER_OF_ROUNDS);
    startGame($userName, $questions);
}

function getQuestions(int $questionCount): array
{
    $questions = [];

    foreach (getRandomNumbers($questionCount) as $number) {
        $questions[] = buildQuestion($number, isPrimeNumber($number));
    }

    return $questions;
}

function getRandomNumbers(int $count): array
{
    $numbers = [];

    $sequenceInIncrOfTwo = range(1, 999, 2);
    $sequenceInIncrOfThree = range(1, 999, 3);

    for ($i = 0; $i < $count; $i++) {
        $sequenceNumber = rand(1, 3);

        if ($sequenceNumber === 1) {
            $numbers[] = rand(1, 999);
        } else {
            $index = ($sequenceNumber === 2 ? array_rand($sequenceInIncrOfTwo) : array_rand($sequenceInIncrOfThree));
            $numbers[] = ($sequenceNumber === 2 ? $sequenceInIncrOfTwo[$index] : $sequenceInIncrOfThree[$index]);
        }
    }

    return $numbers;
}

function buildQuestion(int $number, bool $isPrimeNumber): array
{
    return [
        'questionText'   => "$number",
        'expectedAnswer' => $isPrimeNumber ? 'yes' : 'no',
    ];
}

function isPrimeNumber(int $number): bool
{
    if ($number === 2) {
        return true;
    } elseif (($number === 1) or ($number % 2 === 0)) {
        return false;
    }

    for ($divider = 2; $divider < $number; $divider++) {
        if ($number % $divider === 0) {
            return false;
        }
    }

    return true;
}
