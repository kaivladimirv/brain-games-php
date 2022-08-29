<?php

declare(strict_types=1);

namespace BrainGames\Games\Calc;

use function BrainGames\Engine\showWelcome;
use function BrainGames\Engine\askUserName;
use function BrainGames\Engine\startGame;
use function cli\line;

use const BrainGames\Engine\NUMBER_OF_ROUNDS;

function run(): void
{
    showWelcome();

    $userName = askUserName();

    line('What is the result of the expression?');

    $questions = getQuestions(NUMBER_OF_ROUNDS);

    startGame($userName, $questions);
}

function getQuestions(int $questionCount): array
{
    $questions = [];

    foreach (getRandomPairsOfNumbers($questionCount) as $numberPair) {
        $questions[] = buildQuestion(getRandomOperation(), $numberPair);
    }

    return $questions;
}

function buildQuestion(string $operation, array $numberPair): array
{
    return [
        'questionText'   => "$numberPair[0] $operation $numberPair[1]",
        'expectedAnswer' => calcExpectedAnswer($operation, $numberPair),
    ];
}

function getRandomPairsOfNumbers(int $count): array
{
    $numbers = [];

    for ($i = 0; $i < $count; $i++) {
        $numbers[] = [
            rand(1, 999),
            rand(1, 999),
        ];
    }

    return $numbers;
}

function getRandomOperation(): string
{
    $operations = [
        '+',
        '-',
        '*',
    ];

    $index = array_rand($operations);

    return $operations[$index];
}

function calcExpectedAnswer(string $operation, array $numberPair): ?int
{
    return match ($operation) {
        '+' => $numberPair[0] + $numberPair[1],
        '-' => $numberPair[0] - $numberPair[1],
        '*' => $numberPair[0] * $numberPair[1],
        default => null,
    };
}
