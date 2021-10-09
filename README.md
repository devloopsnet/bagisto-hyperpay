[![Codacy Badge](https://api.codacy.com/project/badge/Grade/b400f216f90647aa87abd85fdf915926)](https://app.codacy.com/gh/devloopsnet/bagisto-hyperpay?utm_source=github.com&utm_medium=referral&utm_content=devloopsnet/bagisto-hyperpay&utm_campaign=Badge_Grade_Settings)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/devloopsnet/bagisto-hyperpay.svg?style=for-the-badge)](https://packagist.org/packages/devloopsnet/bagisto-hyperpay) ![Postcardware](https://img.shields.io/badge/Postcardware-%F0%9F%92%8C-197593?style=for-the-badge) 

[![PHP from Packagist](https://img.shields.io/packagist/php-v/devloopsnet/bagisto-hyperpay?style=flat-square)](https://packagist.org/packages/devloopsnet/bagisto-hyperpay) [![Total Downloads](https://img.shields.io/packagist/dt/devloopsnet/bagisto-hyperpay.svg?style=flat-square)](https://packagist.org/packages/devloopsnet/bagisto-hyperpay) [![StyleCI](https://github.styleci.io/repos/411804356/shield?branch=main)](https://github.styleci.io/repos/411804356?branch=main)

# Bagisto HyperPay Payment Gateway

### 1. Introduction:

This package provides hyperpay (Network) as a payment gateway for bagisto, it supports sandbox env.

### 2. Requirements:

* **Bagisto**: v1.3.1.

### 3. Installation:
* Install the Bagisto HyperPay Payment Gateway extension
```
composer require devloopsnet/bagisto-hyperpay
```

* Run these commands below to complete the setup

```
php artisan config:cache
```

```
php artisan migrate
```

```
php artisan route:cache
```

```
php artisan vendor:publish

-> Press 0 and then press enter to publish all assets and configurations.
```

### 4. Setup

Navigate to ```admin/configuration/sales/paymentmethods``` by going to Configure -> Sales -> Payment Methods

Then you can fill in the needed credentials provided by your account manager, which are Access Token and Entity Id

- Make sure to enable Sandbox when testing.
- Using live credentials with sandbox enabled will cause the payment gateway to stop working properyl.
