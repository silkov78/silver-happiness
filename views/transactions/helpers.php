<?php
function formatDate(
    string $date,
    string $inputFormat = 'Y-m-d',
    string $outputFormat = 'M j, Y'
): string
{
    $date = \DateTime::createFromFormat($inputFormat, $date);
    return $date->format($outputFormat);
}

function formatAmount(string|float $amount): string
{
    if ((float) $amount >= 0) {
        return '<span style="color:green;">' . '$' . $amount . '</span>';
    }

    return '<span style="color:red;">' . str_replace('-', '-$', $amount) . '</span>';
}

function calculateTotals(array $transactions, string $field = 'amount'): array
{
    $results = [
        'income' => 0,
        'expense' => 0,
        'netTotal' => 0
    ];

    foreach ($transactions as $value) {
        (float) $value[$field] >= 0
            ? $results['income'] += $value[$field]
            : $results['expense'] += $value[$field];
    }

    $results['netTotal'] = $results['income'] + $results['expense'];

    return $results;
}

$totals = calculateTotals($transactionsList);
