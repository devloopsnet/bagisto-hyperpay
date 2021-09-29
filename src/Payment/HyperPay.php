<?php

namespace Devloops\HyperPay\Payment;

use JetBrains\PhpStorm\ArrayShape;
use Webkul\Payment\Payment\Payment;
use Illuminate\Support\Facades\Http;

/**
 * Class HyperPay
 *
 * @package Devloops\HyperPay\Payment
 * @date 7/16/21
 * @author Abdullah Al-Faqeir <abdullah@devloops.net>
 */
class HyperPay extends Payment
{

    /**
     * Payment method code
     *
     * @var string
     */
    protected $code = 'hyperpay';

    public function getRedirectUrl(): string
    {
        /**
         * @var $cart \Webkul\Checkout\Models\Cart
         */
        $cart           = $this->getCart();
        $billingAddress = $cart->billing_address;
        $name           = $billingAddress->first_name.' '.$billingAddress->last_name;
        $TransactionId  = "TRXORDER{$cart->id}";
        $CheckoutData   = $this->prepareCheckout($cart->id, $cart->grand_total, $billingAddress->email, $name, $TransactionId);
        if ($CheckoutData['result']['code'] === '000.200.100') {
            $CheckoutId = $CheckoutData['id'];
            return route('hyperpay.redirect', [
                'cart'          => $cart->id,
                'checkoutId'    => $CheckoutId,
                'transactionId' => $TransactionId,
            ]);
        }

        throw new \Exception('HyperPay Gateway Purchase Error : '.$CheckoutData['result']['description'] ?? $CheckoutData['result']['code'] ?? 'Unknown');
    }

    public function prepareCheckout(int $cartId, float $amount, string $email, string $name, string $transactionId): array
    {
        $billingAddress = $this->getCart()->billing_address;

        $params = [
            'entityId'              => $this->getConfigData('entity_id'),
            'amount'                => $amount,
            'currency'              => 'JOD',
            'paymentType'           => 'DB',
            'customer.surname'      => $billingAddress->last_name,
            'customer.email'        => $email,
            'customer.givenName'    => $billingAddress->first_name,
            'billing.street1'       => $billingAddress->address1,
            'billing.city'          => $billingAddress->city,
            'billing.country'       => $billingAddress->country,
            'billing.postcode'      => $billingAddress->postcode,
            'merchantTransactionId' => $transactionId,
        ];
        if ($this->isSandbox()) {
            $params['testMode'] = 'EXTERNAL';
        }
        return Http::withHeaders($this->getHeaders())
                   ->withBody(http_build_query($params), 'application/x-www-form-urlencoded')
                   ->post($this->getUrl().'/v1/checkouts')
                   ->json();
    }

    #[ArrayShape(['Authorization' => "string"])] private function getHeaders(): array
    {
        return [
            'Authorization' => 'Bearer '.$this->getConfigData('access_token'),
        ];
    }

    private function getUrl(): string
    {
        if ($this->isSandbox()) {
            return 'https://test.oppwa.com';
        }
        return 'https://oppwa.com';
    }

    public function getConfigData($field)
    {
        return core()->getConfigData('sales.paymentmethods.'.$this->getCode().'.'.$field);
    }

    private function isSandbox(): bool
    {
        return (int) $this->getConfigData('sandbox') === 1;
    }

    public function paymentData($resourcePath): array
    {
        $data = [
            'entityId' => $this->getConfigData('entity_id'),
        ];
        return Http::withHeaders($this->getHeaders())
                   ->get($this->getUrl().$resourcePath.'?'.http_build_query($data))
                   ->json();
    }

}