if (stripeKey) {
   var stripe = Stripe(stripeKey);
   var elements = stripe.elements();
   var style = {
        base: {
            fontSize: '16px',
            color: '#32325d',
        },
    };

   var card = elements.create('card', {style: style});
    card.mount('#card-element');

    function stripe_payment() {
        $('#payment_method').parent().removeClass('has-error');
        stripe.createToken(card).then(function (result) {
            if (result.error) {
               var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                stripeTokenHandler(result.token);
            }
        });

    }

    function stripeTokenHandler(token) {
       var form = document.getElementById('paymentForm');
       var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
        form.submit();
    }
}


