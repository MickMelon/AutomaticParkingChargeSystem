<?php
namespace App;

class Config
{
    /**
     * Database connection details.
     */
    const DB_SERVER = 'lochnagar.abertay.ac.uk';
    const DB_NAME = 'sql1800833';
    const DB_USER = 'sql1800833';
    const DB_PASS = 'rgcGZejkmcci';

    const DISPLAY_ERRORS = true;

    const SITE_TITLE = 'APCS-Web';

    const PERMIT_PRICE_POUNDS = 30;

    const STRIPE_SECRET_KEY = 'sk_test_jPnPepQS0C4z8yWmjMgjT8P0';
    const STRIPE_PUBLIC_KEY = 'pk_test_MQXGNKwdA9Rak9gcEkDkucTM';
    // Stripe test cards: https://stripe.com/docs/testing
    // Visa: 4242424242424242
}
