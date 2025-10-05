<button onclick="onBuyClicked()">Pay Now</button>

<script>
/**
 * Detect whether the user is on a mobile device.
 * @returns {boolean}
 */
function isMobileDevice() {
  return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

/**
 * Called when the user clicks the "Pay Now" button
 */
function onBuyClicked() {
  if (!isMobileDevice()) {
    alert('Please use a mobile device with Google Pay to complete the payment.');
    return;
  }

  if (!window.PaymentRequest) {
    alert('Web payments are not supported in this browser.');
    return;
  }

  const supportedInstruments = getMobileUPIPayment();

  const details = {
    total: {
      label: 'Total',
      amount: {
        currency: 'INR',
        value: '1.00',
      },
    },
    displayItems: [{
      label: 'Invoicezy Service',
      amount: {
        currency: 'INR',
        value: '1.00',
      },
    }],
  };

  let request;
  try {
    request = new PaymentRequest(supportedInstruments, details);
  } catch (e) {
    console.error('Payment Request Error: ' + e.message);
    return;
  }

  request.canMakePayment().then(result => {
    if (!result) {
      alert('Google Pay is not available on this mobile device.');
      return;
    }

    request.show().then(instrumentResponse => {
      console.log('Payment success:', instrumentResponse);
      instrumentResponse.complete('success');
    }).catch(err => {
      console.error('Payment cancelled:', err);
    });

  }).catch(err => {
    console.error('canMakePayment error:', err);
  });
}

/**
 * Get UPI payment config for mobile Google Pay.
 */
function getMobileUPIPayment() {
  return [{
    supportedMethods: 'https://tez.google.com/pay',
    data: {
      pa: '8750101087@ptaxis',
      pn: 'Prem Morya',
      tr: 'TXNsadf',
      tn: 'Payment via Invoicezy',
      mc: '7372',
      url: 'https://pro.invoicezy.com/payment',
    }
  }];
}
</script>
