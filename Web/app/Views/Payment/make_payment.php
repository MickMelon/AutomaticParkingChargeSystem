<form action="index.php?controller=payment&action=submitpayment" method="POST">
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="<?= $publicKey ?>"
    data-amount="<?= $amount ?>"
    data-name="Smart Parking Ltd."
    data-description="Pay your bill for <?= $reg ?>"
    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
    data-locale="auto"
    data-currency="gbp">
  </script>
  <input type="hidden" name="reg" value="<?= $reg ?>" />
  <input type="hidden" name="entrydatetime" value="<?= $entryDateTime ?>" />
  <input type="hidden" name="cost" value="<?= $amount ?>" />
</form>