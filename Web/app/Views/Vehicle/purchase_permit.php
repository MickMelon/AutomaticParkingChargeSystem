<form action="index.php?controller=vehicle&action=submitpermitpayment" method="POST">
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="<?= $publicKey ?>"
    data-amount="<?= $amount ?>"
    data-name="Smart Parking Ltd."
    data-description="Purchase a season permit for your vehicle."
    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
    data-locale="auto"
    data-currency="gbp">
  </script>
  <input type="hidden" name="reg" value="<?= $reg ?>" />
</form>