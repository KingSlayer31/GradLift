<?php
require_once(get_theme_root() . '/backer-child/stripe-php/lib/Stripe.php');
// Set your secret key: remember to change this to your live secret key in production
// See your keys here https://dashboard.stripe.com/account
$test_secret_key = "sk_test_VFH5IcKIHgZNHHFf9YKKwBQc";
$test_publishable_key = "pk_test_zjxHvfB1GivnK6GlQw2rxMHk";
$live_secret_key = "sk_live_vhbLOgvkWoaEopBZnu246FyW";
$live_publishable_key = "pk_live_9hOPUxo6aqdYI3t1BoaBiKAW";

Stripe::setApiKey($test_secret_key);
$current_user = wp_get_current_user();
$current_login = $current_user->data->user_login;

$token = $_POST['stripeToken'];
// Create the charge on Stripe's servers - this will charge the user's card
if ($token){
    try {
    $charge = Stripe_Charge::create(array(
      "amount" => 2500, // amount in cents, again
      "currency" => "usd",
      "card" => $token,
      "description" => $current_login)
    );
    } catch(Stripe_CardError $e) {
      // The card has been declined
    }
}
//update profile to say user-paid
// var_dump($charge);
// $to_update['paid_app_fee'] = 'true';
// $ultimatemember->user->update_profile( $to_update );
?>   

<div class="stripe-form">
    <form action="" method="POST">
      <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="pk_live_9hOPUxo6aqdYI3t1BoaBiKAW"
        data-amount="2500"
        data-name="Gradlift Scholarship"
        data-description="Application Fee"
        data-image="/i/g128.png">
      </script>
    </form>
</div>