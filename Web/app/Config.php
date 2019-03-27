<?php
namespace App;

/**
 * Stores all the global configuration settings for the app.
 */
class Config
{
    /**
     * Database connection details.
     */
    const DB_SERVER = 'lochnagar.abertay.ac.uk';
    const DB_NAME = 'sqlcmp311gc1801';
    const DB_USER = 'sqlcmp311gc1801';
    const DB_PASS = 'cRTjaE4dArAk';

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

    const HOURLY_PARKING_RATE_POUNDS = 2;

    /**
     * Stripe API keys.
     * Stripe test cards: https://stripe.com/docs/testing
     * Test Visa: 4242 4242 4242 4242
     */
    const STRIPE_SECRET_KEY = 'sk_test_jPnPepQS0C4z8yWmjMgjT8P0';
    const STRIPE_PUBLIC_KEY = 'pk_test_MQXGNKwdA9Rak9gcEkDkucTM';
}
