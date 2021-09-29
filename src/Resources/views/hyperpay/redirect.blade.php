<html>
<head>
</head>
<body>
<form action="{{ $action }}" method="post" class="paymentWidgets" data-brands="VISA MASTER"></form>

<script type="text/javascript">
    let wpwlOptions = {
        style: "card"
    }
</script>
<script src="https://{{ (int)core()->getConfigData('sales.paymentmethods.hyperpay.sandbox')===1 ? 'test.' : '' }}oppwa.com/v1/paymentWidgets.js?checkoutId={{ $checkoutId }}"></script>

<style>
    #paymentBox {
        margin-top: 80px;
        margin-bottom: 280px;
    }
</style>
</body>
</html>