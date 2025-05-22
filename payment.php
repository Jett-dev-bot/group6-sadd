<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Payment Method</title>
  <link rel="stylesheet" href="payment.css">  
</head>
<body>

<form class="payment-container" id="paymentForm">
  <div class="option">
    <label>
      <input type="radio" name="payment_method" value="Gcash" />
      Gcash
    </label>
    <img src="gcash.png" alt="GCash Logo" />
  </div>

  <div class="option">
    <label>
      <input type="radio" name="payment_method" value="Cash Payment" />
      Cash Payment
    </label>
    <img src="cash.png" alt="Cash Logo" />
  </div>

  <button type="submit" id="payBtn" class="pay-button" disabled>
    🔒 Finish and Pay
  </button>
</form>

<!-- GCash Modal -->
<div id="gcashModal" class="modal">
  <div class="modal-content">
    <span class="close-modal" id="closeModal">&times;</span>
    <h3>Scan to Pay with GCash</h3>
    <img src="gcash-qr.jpg" alt="GCash QR Code" />
    <button class="confirm-button" id="confirmPayment">I've Paid</button>
  </div>
</div>

<script>
  const radioButtons = document.querySelectorAll('input[name="payment_method"]');
  const payBtn = document.getElementById('payBtn');

  radioButtons.forEach(radio => {
    radio.addEventListener('change', () => {
      payBtn.disabled = false;
      payBtn.classList.add("enabled");
    });
  });

  const gcashModal = document.getElementById('gcashModal');
  const closeModal = document.getElementById('closeModal');
  const confirmPayment = document.getElementById('confirmPayment');

  closeModal.addEventListener('click', () => {
    gcashModal.style.display = 'none';
  });

  window.addEventListener('click', (event) => {
    if (event.target === gcashModal) {
      gcashModal.style.display = 'none';
    }
  });

  // Show modal or redirect on submit
  document.getElementById('paymentForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const selected = document.querySelector('input[name="payment_method"]:checked');
    if (!selected) {
      alert("Please select a payment method.");
      return;
    }

    const method = selected.value;

    if (method === "Gcash") {
      gcashModal.style.display = 'block';
    } else {
      const confirmed = confirm(`You selected "${method}". Proceed to pay?`);
      if (confirmed) {
        window.location.href = "thankyou.php";
      }
    }
  });

  // Redirect after GCash payment confirmed
  confirmPayment.addEventListener('click', () => {
    window.location.href = "thankyou.php";
  });
</script>

</body>
</html>
