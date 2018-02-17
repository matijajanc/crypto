# Crypto Dashboard

This project is about crypto currencies, which tokens do you own and how much profit did you gain.
Into DB you insert tokens that you have in your wallets, you insert token name, number of tokens and invested money (need for calculation). If you have some tokens on some exchanges I added APIs for two exchanges Binance and Poloniex.
In calculation part it sums tokens from wallets (DB) and both exchanges and calculate it with the latest values obtained from Cryptocompare API.

## Screenshot
[![](public/img/crypto.jpg)](public/img/crypto-thumbnail.jpg)

## Exchanges Implemented:
-	Binance
-	Poloniex

## Requirements:
-	PHP 7+
-	sqlite
## Specifications:
-	Symfony 4 framework

## Run
```
composer install
php bin\console doctrine:migrations:migrate
php bin\console fos:user:create
npm install
node_modules\.bin\encore dev
```
