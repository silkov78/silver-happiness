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
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Transactions</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                text-align: center;
            }

            table tr th, table tr td {
                padding: 5px;
                border: 1px #eee solid;
            }

            tfoot tr th, tfoot tr td {
                font-size: 20px;
            }

            tfoot tr th {
                text-align: right;
            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Check #</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php if (! empty($transactionsList)): ?>
                    <?php foreach ($transactionsList as $transaction): ?>
                        <tr>
                            <td><?= formatDate($transaction['date'])?></td>
                            <td><?= $transaction['check_number']?></td>
                            <td><?= $transaction['description']?></td>
                            <td><?= formatAmount($transaction['amount'])?></td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td><?= formatAmount($totals['income']) ?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><?= formatAmount($totals['expense']) ?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><?= formatAmount($totals['netTotal']) ?></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
