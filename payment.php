<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Payment Method</title>
  <style>
    body {
      margin: 0;
      font-family: sans-serif;
      background-color: #045b63;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .payment-container {
      background-color: #34727c;
      border-radius: 15px;
      padding: 30px;
      width: 300px;
    }
    .option {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 15px 10px;
      border-bottom: 1px solid #ccc;
      color: white;
    }
    .option:last-child {
      border-bottom: none;
    }
    .option input[type="radio"] {
      margin-right: 10px;
      transform: scale(1.2);
    }
    .option label {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 16px;
      cursor: pointer;
      flex-grow: 1;
    }
    .option img {
      width: 30px;
      height: 30px;
    }
    .pay-button {
      margin-top: 20px;
      width: 100%;
      background-color: #c4e7db;
      color: #000;
      font-weight: bold;
      padding: 10px;
      border-radius: 12px;
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      cursor: not-allowed;
    }
    .pay-button.enabled {
      cursor: pointer;
      background-color: #b2dfdb;
    }

    /* Modal styling */
    .modal {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.6);
    }

    .modal-content {
      background-color: #fff;
      margin: 10% auto;
      padding: 20px 20px 70px;
      border-radius: 10px;
      max-width: 300px;
      text-align: center;
      position: relative;
    }


    .modal-content img {
      width: 65%;
      height: auto;
    }

    .close-modal {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 40px;
      cursor: pointer;
      font-weight: bold;
    }

    .confirm-button {
      position: absolute;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      padding: 10px 20px;
      background-color: #34727c;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;

    }
  </style>
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
