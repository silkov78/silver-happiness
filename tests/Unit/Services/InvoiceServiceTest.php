<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\InvoiceService;
use PHPUnit\Framework\TestCase;

/**
 * 1. test_it_processes_invoice
 * 2. test_it_sends_email_when_invoice_is_processed
 */

class InvoiceServiceTest extends TestCase
{
    public function test_it_processes_invoice(): void
    {
        // given InvoiceService 
        $invoiceService = new InvoiceService();

        // when process-method was called
        $result = $invoiceService->process(['Piotr', 'chill guy'], 178);

        // then assert process-method was executed (returned true)
        $this->assertTrue($result);
    }
}