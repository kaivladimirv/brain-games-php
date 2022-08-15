<?php

declare(strict_types=1);

namespace BrainGames\Games\Gcd;

use function BrainGames\Engine\askUserName;
use function BrainGames\Engine\showWelcome;
use function BrainGames\Engine\startGame;
use function cli\line;

use const BrainGames\Engine\NUMBER_OF_ROUNDS;

function run(): void
{
    showWelcome();

    $userName = askUserName();

    line('Find the greatest common divisor of given numbers.');

    $questions = getQuestions(NUMBER_OF_ROUNDS);
    startGame($userName, $questions);
}

function getQuestions(int $questionCount): array
{
    $questions = [];

    foreach (getRandomPairsOfNumbers($questionCount) as $numberPair) {
        $questions[] = buildQuestion($numberPair);
    }

    return $questions;
}

function getRandomPairsOfNumbers(int $pairCount): array
{
    $pairs = [];

    for ($i = 0; $i < $pairCount; $i++) {
        $pairs[] = [
            rand(1, 99),
            rand(1, 99),
        ];
    }

    return $pairs;
}

function buildQuestion(array $numberPair): array
{
    return [
        'questionText'   => "$numberPair[0] $numberPair[1]",
        'expectedAnswer' => findGcd($numberPair),
    ];
}

function findGcd(array $numbers): int
{
    $gcd = array_pop($numbers);

    while ($numbers) {
        $number = array_pop($numbers);

        $gcd = findGcdForPair($gcd, $number);
    }

    return $gcd;
}

function findGcdForPair(int $number1, int $number2): int
{
    $dividend = max($number1, $number2);
    $divider = min($number1, $number2);

    do {
        $remainder = $dividend % $divider;
        $prevDivider = $divider;

        $dividend = $divider;
        $divider = $remainder;
    } while ($remainder !== 0);

    return $prevDivider;
}
