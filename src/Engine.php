<?php

declare(strict_types=1);

namespace BrainGames\Engine;

use function cli\line;
use function cli\prompt;

const NUMBER_OF_ROUNDS = 3;

function showWelcome(): void
{
    line("\nWelcome to the Brain Games!");
}

function askUserName(): string
{
    $userName = prompt('May I have your name?', '', ' ');
    line("Hello, $userName!");

    return $userName;
}

function startGame(string $userName, array $questions): void
{
    foreach ($questions as $question) {
        $receivedAnswer = getAnswerToQuestion($question['questionText']);

        if (!compareAnswers((string) $question['expectedAnswer'], $receivedAnswer)) {
            line("Let's try again, $userName!");
            exit;
        }
    }

    line("Congratulations, $userName!");
}

function getAnswerToQuestion(string $question): string
{
    line("Question: $question");

    return prompt('Your answer');
}

function compareAnswers(mixed $expectedAnswer, mixed $receivedAnswer): bool
{
    if ($expectedAnswer === $receivedAnswer) {
        line('Correct!');

        return true;
    } else {
        line("'$receivedAnswer' is wrong answer ;(. Correct answer was '$expectedAnswer'.");

        return false;
    }
}
