<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\InvoiceService;
use App\Services\SalesTaxService;
use App\Services\PaymentGatewayService;
use App\Services\EmailService;
use PHPUnit\Framework\TestCase;

/**
 * 1. test_it_processes_invoice
 * 2. test_it_sends_email_when_invoice_is_processed
 */

class InvoiceServiceTest extends TestCase
{
    public function test_it_processes_invoice(): void
    {
        $salesTaxServiceMock = $this->createMock(SalesTaxService::class);
        $gatewayServiceMock = $this->createMock(PaymentGatewayService::class);
        $emailServiceMock = $this->createMock(EmailService::class);

        $gatewayServiceMock->method('charge')->willReturn(true);

        // given InvoiceService 
        $invoiceService = new InvoiceService(
            $salesTaxServiceMock,
            $gatewayServiceMock,
            $emailServiceMock,
        );

        // when process-method was called
        $result = $invoiceService->process(['Piotr', 'chill guy'], 178);

        // then assert process-method was executed (returned true)
        $this->assertTrue($result);
    }

    public function test_it_call_email_send_method_when_invoice_is_processed(): void
    {
        $salesTaxServiceMock = $this->createMock(SalesTaxService::class);
        $gatewayServiceMock = $this->createMock(PaymentGatewayService::class);
        $emailServiceMock = $this->createMock(EmailService::class);

        $gatewayServiceMock->method('charge')->willReturn(true);
        $emailServiceMock
            ->expects($this->once())
            ->method('send')
            ->with(['name' => 'Piotr'], 'receipt');

        // given InvoiceService 
        $invoiceService = new InvoiceService(
            $salesTaxServiceMock,
            $gatewayServiceMock,
            $emailServiceMock,
        );

        // when process-method was called
        $result = $invoiceService->process(['name' => 'Piotr'], 178);

        // then assert process-method was executed (returned true)
        $this->assertTrue($result);
    }
}