<?php
include 'db.php';

// Nag fe--fetch ng menu items sa the database
$stmt = $pdo->query("SELECT * FROM menu_items");
$menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the next order number
$stmt = $pdo->query("SELECT MAX(id) AS last_order_id FROM orders");
$lastOrder = $stmt->fetch(PDO::FETCH_ASSOC);
$nextOrderId = $lastOrder && $lastOrder['last_order_id'] ? $lastOrder['last_order_id'] + 1 : 1;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>QuickSales POS</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="flex bg-gray-900 text-white">

  <!-- Sidebar -->
    <aside class="w-1/5 bg-teal-900 text-white min-h-screen p-4 space-y-8">
      <h1 class="text-2xl font-bold mb-6">QuickSales</h1>
      <nav class="flex flex-col space-y-4 text-base font-medium">
        <a href="#" class="block font-semibold underline text-yellow-300">📋 Menu</a>
        <a href="salesreport.php" class="block hover:underline">📈 Sales Report</a>
        <a href="dashboard.php" class="block hover:underline">🏠 Dashboard</a>
        <a href="profile.php" class="block hover:underline">👤 Profile</a>
      </nav>
    </aside>

  <!-- Main Content -->
  <main class="flex-1 flex">
    <!-- Menu Section -->
    <section class="w-3/5 bg-teal-800 p-6 overflow-y-auto text-white">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold">MENU</h2>
        <button onclick="openModal()" class="bg-green-500 px-4 py-2 rounded text-sm font-medium">+ Add Item</button>
      </div>
      <div id="menu-items" class="grid grid-cols-3 gap-4">
        <?php foreach ($menuItems as $item): ?>
          <div onclick="addItem(<?= $item['id'] ?>, '<?= htmlspecialchars($item['name'], ENT_QUOTES) ?>', <?= $item['price'] ?>)"
               class="menu-card bg-gray-100 text-gray-900 rounded-lg p-3 text-center shadow">
            <img src="<?= htmlspecialchars($item['image_path']) ?>" class="mx-auto mb-2 h-24 w-full object-cover rounded" alt="<?= htmlspecialchars($item['name']) ?>" />
            <div class="font-semibold">₱<?= number_format($item['price'], 2) ?></div>
            <div class="text-sm font-bold"><?= htmlspecialchars($item['name']) ?></div>
            <div class="text-xs text-gray-600"><?= htmlspecialchars($item['description']) ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- Order Summary -->
    <section class="w-2/5 bg-gray-800 text-white p-6">
      <div id="order-list" class="mb-6 space-y-2"></div>
      <div class="text-sm font-semibold mb-2">Order No. #<?= $nextOrderId ?></div>
      <div class="border-t border-gray-400 pt-4 space-y-2 text-sm">
        <div class="flex justify-between"><span>SUBTOTAL</span><span id="subtotal">₱0.00</span></div>
        <div class="flex justify-between"><span>SERVICE CHARGE (10%)</span><span id="service-charge">₱0.00</span></div>
        <div class="flex justify-between text-lg font-semibold mt-2"><span>TOTAL</span><span id="total">₱0.00</span></div>
        <button onclick="openPaymentModal()" class="bg-yellow-500 mt-6 w-full py-3 rounded font-bold text-lg text-center w-full">Proceed ➡️</button>
      </div>
    </section>
  </main>

    <!-- Add Item Modal -->
  <div id="addItemModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white text-black p-6 rounded-lg w-96">
      <h2 class="text-xl font-bold mb-4">Add New Menu Item</h2>
      <form id="addItemForm">
        <div class="mb-3">
          <label class="block text-sm font-semibold mb-1">Image</label>
          <input type="file" id="itemImage" accept="image/*" required class="w-full border border-gray-300 rounded px-3 py-2" />
        </div>
        <div class="mb-3">
          <label class="block text-sm font-semibold mb-1">Name</label>
          <input type="text" id="itemName" required class="w-full border border-gray-300 rounded px-3 py-2" />
        </div>
        <div class="mb-3">
          <label class="block text-sm font-semibold mb-1">Price</label>
          <input type="number" id="itemPrice" required class="w-full border border-gray-300 rounded px-3 py-2" />
        </div>
        <div class="mb-3">
          <label class="block text-sm font-semibold mb-1">Description</label>
          <textarea id="itemDescription" rows="3" class="w-full border border-gray-300 rounded px-3 py-2"></textarea>
        </div>
        <div class="flex justify-end gap-2 mt-4">
          <button type="button" onclick="closeModal()" class="bg-gray-400 px-4 py-2 rounded">Cancel</button>
          <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Add</button>
        </div>
      </form>
    </div>
  </div>

  
  <div id="summaryModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden z-50">
    <div class="bg-white text-black rounded-lg w-96 p-6">
      <h2 class="text-xl font-bold mb-4">Review Order</h2>
      <div id="summaryContent" class="text-sm mb-4"></div>
      <div class="flex flex-col gap-2">
        <div class="flex justify-between gap-2">
          <button onclick="document.getElementById('summaryModal').classList.add('hidden')" class="bg-gray-500 text-white px-4 py-2 rounded w-1/2">Back</button>
          <button onclick="confirmPayment('cash')" class="bg-green-600 text-white px-4 py-2 rounded w-1/2">Pay with Cash</button>
        </div>
        <button onclick="confirmPayment('gcash')" class="bg-blue-600 text-white px-4 py-2 rounded">Pay with GCash</button>
      </div>
    </div>
  </div>

  <!-- Receipt Modal -->
  <div id="receiptModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden z-50">
    <div class="bg-white text-black rounded-lg w-96 p-6">
      <h2 class="text-xl font-bold mb-4">Receipt</h2>
      <div id="receiptContent" class="text-sm mb-4"></div>
      <button onclick="closeReceiptAndSubmit()" class="bg-blue-600 text-white px-4 py-2 rounded w-full">Confirm & Done</button>
    </div>
  </div>

  <!-- Payment Method Modal -->
  <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white text-black p-6 rounded-lg w-96 text-center space-y-4">
      <h2 class="text-xl font-bold">Choose Payment Method</h2>
      <button onclick="selectPayment('cash')" class="w-full bg-green-600 text-white py-2 rounded">💵 Cash</button>
      <button onclick="selectPayment('gcash')" class="w-full bg-blue-500 text-white py-2 rounded">📱 GCash</button>
      <button onclick="closePaymentModal()" class="text-sm text-gray-600 hover:underline mt-4">Cancel</button>
    </div>
  </div>

  <!-- GCash QR Modal -->
  <div id="gcashModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white text-black p-6 rounded-lg w-96 text-center relative space-y-4">
      <!-- X button in top-right corner -->
      <button onclick="closeGcashModal()" class="absolute top-2 right-2 text-gray-600 hover:text-red-500 text-xl font-bold">&times;</button>
      
      <h2 class="text-lg font-bold mb-2">Scan to Pay via GCash</h2>
      <img src="gcash-qr.png" alt="GCash QR" class="mx-auto h-48 w-48 border" />
      <button onclick="confirmPayment()" class="bg-blue-600 text-white px-4 py-2 rounded">Confirm Payment</button>
    </div>
  </div>

  <!-- Empty Order Warning Modal -->
  <div id="emptyOrderModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white text-black p-6 rounded-lg w-96 text-center">
      <h2 class="text-lg font-bold mb-4">No items in order</h2>
      <p class="mb-4">Please add at least one item before proceeding to payment.</p>
      <button onclick="closeEmptyOrderModal()" class="bg-blue-600 text-white px-4 py-2 rounded">OK</button>
    </div>
  </div>



  <script>
    let menuItems = <?php echo json_encode($menuItems); ?>;


        function openEmptyOrderModal() {
      document.getElementById('emptyOrderModal').classList.remove('hidden');
    }

    function closeEmptyOrderModal() {
      document.getElementById('emptyOrderModal').classList.add('hidden');
    }


        function closeGcashModal() {
      document.getElementById('gcashModal').classList.add('hidden');
    }

        function closeReceiptAndSubmit() {
      document.getElementById('receiptModal').classList.add('hidden');
      confirmPayment();
    }


    function renderMenu() {
      const menuSection = document.getElementById('menu-items');
      menuSection.innerHTML = '';
      menuItems.forEach(item => {
        menuSection.innerHTML += `
          <div onclick="addItem(${item.id}, '${item.name}', ${item.price})"
               class="menu-card bg-gray-100 text-gray-900 rounded-lg p-3 text-center shadow">
            <img src="${item.image_path || 'ss.jpeg'}"
                 class="mx-auto mb-2 h-24 w-full object-cover rounded"
                 alt="${item.name}" />
            <div class="font-semibold">₱${item.price}</div>
            <div class="text-sm font-bold">${item.name}</div>
            <div class="text-xs text-gray-600">${item.description || ''}</div>
          </div>
        `;
      });
    }

    function addItem(id, name, price) {
      const orderList = document.getElementById('order-list');
      const existingItem = Array.from(orderList.children).find(item => item.dataset.id == id);

      if (existingItem) {
        const qtySpan = existingItem.querySelector('.qty');
        qtySpan.innerText = parseInt(qtySpan.innerText) + 1;
      } else {
        const item = document.createElement('div');
        item.className = 'flex justify-between items-center text-sm border-b border-gray-600 py-1';
        item.dataset.id = id;
        item.dataset.price = price;
        item.innerHTML = `
          <span>${name}</span>
          <span>₱${price}</span>
          <span class="qty px-2">1</span>
          <button onclick="this.parentElement.remove(); updateTotal();" class="text-red-400 hover:text-red-600">×</button>
        `;
        orderList.appendChild(item);
      }

      updateTotal();
    }

    function updateTotal() {
      const items = document.querySelectorAll('#order-list div');
      let subtotal = 0;

      items.forEach(item => {
        const price = parseFloat(item.dataset.price);
        const qty = parseInt(item.querySelector('.qty').innerText);
        subtotal += price * qty;
      });

      let service = subtotal * 0.10;
      document.getElementById('subtotal').innerText = `₱${subtotal.toFixed(2)}`;
      document.getElementById('service-charge').innerText = `₱${service.toFixed(2)}`;
      document.getElementById('total').innerText = `₱${(subtotal + service).toFixed(2)}`;
    }

    function openModal() {
      document.getElementById('addItemModal').classList.remove('hidden');
    }

    function closeModal() {
      document.getElementById('addItemModal').classList.add('hidden');
      document.getElementById('addItemForm').reset();
    }

    function openPaymentModal() {
      const orderList = document.querySelectorAll('#order-list div');
      if (orderList.length === 0) {
        openEmptyOrderModal();
        return;
      }
      document.getElementById('paymentModal').classList.remove('hidden');
    }


    function closePaymentModal() {
      document.getElementById('paymentModal').classList.add('hidden');
    }

    function selectPayment(method) {
      closePaymentModal();
      if (method === 'cash') {
        showReceiptModal(); // 👈 Show receipt immediately
      } else if (method === 'gcash') {
        document.getElementById('gcashModal').classList.remove('hidden');
      }
    }
    function showReceiptModal() {
    const receiptContent = document.getElementById('receiptContent');
    const orderItems = document.querySelectorAll('#order-list div');

    let receiptHTML = '';
    let subtotal = 0;

    orderItems.forEach(item => {
      const name = item.querySelector('span').innerText;
      const qty = parseInt(item.querySelector('.qty').innerText);
      const price = parseFloat(item.dataset.price);
      const total = qty * price;
      subtotal += total;

      receiptHTML += `<div class="flex justify-between text-sm mb-1">
                        <span>${qty}x ${name}</span>
                        <span>₱${total.toFixed(2)}</span>
                      </div>`;
    });

    const service = subtotal * 0.10;
    const grandTotal = subtotal + service;

    receiptHTML += `
      <hr class="my-2 border-gray-300">
      <div class="flex justify-between text-sm"><strong>Subtotal</strong><span>₱${subtotal.toFixed(2)}</span></div>
      <div class="flex justify-between text-sm"><strong>Service Charge (10%)</strong><span>₱${service.toFixed(2)}</span></div>
      <div class="flex justify-between text-lg font-bold mt-2"><strong>Total</strong><span>₱${grandTotal.toFixed(2)}</span></div>
    `;

    receiptContent.innerHTML = receiptHTML;
    document.getElementById('receiptModal').classList.remove('hidden');
  }

    function confirmPayment() {
      document.getElementById('gcashModal').classList.add('hidden');
      submitOrder();
    }

        function submitOrder() {
      const orderList = document.querySelectorAll('#order-list div');
      const items = [];

      orderList.forEach(item => {
        const id = parseInt(item.dataset.id);
        const price = parseFloat(item.dataset.price);
        const qty = parseInt(item.querySelector('.qty').innerText);
        items.push({ id, quantity: qty, price });
      });

      fetch('createorder.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ items })
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          window.location.href = `thankyou.php?order_id=${data.order_id}`;
        } else {
          alert('Failed to save order: ' + data.message);
        }
      })

      .catch(err => {
        alert('Error: ' + err);
      });
    }


    document.getElementById('addItemForm').addEventListener('submit', function (e) {
      e.preventDefault();
      const name = document.getElementById('itemName').value;
      const price = parseFloat(document.getElementById('itemPrice').value);
      const description = document.getElementById('itemDescription').value;
      const imageFile = document.getElementById('itemImage').files[0];

      const reader = new FileReader();
      reader.onload = function (event) {
        const imageData = event.target.result;

        fetch('addmenuitem.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ name, price, description, image: imageData })
        })
        .then(res => res.json())
        .then(data => {
          if (data.status === 'success') {
            renderMenu();
            closeModal();
          } else {
            alert('Failed to add item: ' + data.message);
          }
        })
        .catch(err => alert('Error: ' + err));
      };

      if (imageFile) {
        reader.readAsDataURL(imageFile);
      }
    });

    window.onload = renderMenu;
  </script>

</body>
</html>
