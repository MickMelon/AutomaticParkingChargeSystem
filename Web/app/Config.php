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

    /**
     * Whether to display errors.
     */
    const DISPLAY_ERRORS = true;

    /**
     * The title of the site.
     */
    const SITE_TITLE = 'APCS-Web';

    /**
     * The price of the season permit in pounds.
     */
    const PERMIT_PRICE_POUNDS = 30;

    /**
     * Stripe API keys.
     * Stripe test cards: https://stripe.com/docs/testing
     * Test Visa: 4242 4242 4242 4242
     */
    const STRIPE_SECRET_KEY = 'sk_test_jPnPepQS0C4z8yWmjMgjT8P0';
    const STRIPE_PUBLIC_KEY = 'pk_test_MQXGNKwdA9Rak9gcEkDkucTM';
}
