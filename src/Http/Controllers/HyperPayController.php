<?php

namespace Devloops\HyperPay\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;
use Webkul\Checkout\Facades\Cart;
use Webkul\Sales\Repositories\OrderRepository;

/**
 * Class HyperPayController.
 *
 * @date 29/09/2021
 *
 * @author Abdullah Al-Faqeir <abdullah@devloops.net>
 */
class HyperPayController extends Controller
{
    /**
     * OrderRepository object.
     *
     * @var \Webkul\Sales\Repositories\OrderRepository
     */
    protected OrderRepository $orderRepository;

    /**
     * Create a new controller instance.
     *
     * @param \Webkul\Sales\Repositories\OrderRepository $orderRepository
     */
    public function __construct(
        OrderRepository $orderRepository,
    ) {
        $this->orderRepository = $orderRepository;
    }

    public function success($cartId): RedirectResponse
    {
        $order = $this->orderRepository->create(Cart::prepareDataForOrder());

        Cart::deActivateCart();

        session()->flash('order', $order);

        return redirect()->route('shop.checkout.success');
    }

    public function cancel(): RedirectResponse
    {
        session()->flash('error', 'Hyperpay payment has been canceled.');

        return redirect()->route('shop.checkout.cart.index');
    }

    public function process($cartId, string $checkoutId, string $transactionId): RedirectResponse
    {
        $CheckoutId = request()->get('id');
        $resourcePath = request()->get('resourcePath');
        $payment = app(Config::get('paymentmethods.'.Cart::getCart()->payment->method.'.class'));
        $paymentData = $payment->paymentData($resourcePath);

        $resultCode = $paymentData['result']['code'] ?? '';
        if (isset($paymentData['amount']) && preg_match('/^(000\.000\.|000\.100\.1|000\.[36])/', $resultCode)) {
            return $this->success($cartId);
        }

        return $this->cancel();
    }

    public function redirect($cartId, string $checkoutId, string $transactionId): Factory|View|Application|RedirectResponse
    {
        $action = route('hyperpay.process', [
            'cart'          => $cartId,
            'checkoutId'    => $checkoutId,
            'transactionId' => $transactionId,
        ]);

        return view('hyperpay::redirect', compact('transactionId', 'checkoutId', 'action'));
    }
}
