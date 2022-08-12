<?php

declare(strict_types=1);

namespace BrainGames\Games\Even;

use function cli\line;
use function cli\prompt;

function run(): void
{
    line("\nWelcome to the Brain Games!");

    $userName = prompt('May I have your name?', '', ' ');
    line("Hello, $userName!");

    line('Answer "yes" if the number is even, otherwise answer "no".');

    foreach (getNumbers() as $number) {
        line("Question: $number");

        $expectedAnswer = ($number % 2 === 0 ? 'yes' : 'no');
        $receivedAnswer = prompt('Your answer');

        if ($expectedAnswer === $receivedAnswer) {
            line('Correct!');
        } else {
            line("'$receivedAnswer' is wrong answer ;(. Correct answer was '$expectedAnswer'.");
            line("Let's try again, $userName!");
            exit;
        }
    }

    line("Congratulations, $userName!");
}

function getNumbers(): array
{
    return [
        15,
        6,
        7,
    ];
}
