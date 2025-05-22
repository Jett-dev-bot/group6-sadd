<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Order</title>
  <link rel="stylesheet" href="order.css">
</head>
<body>

<h2>Create New Order</h2>

<form id="orderForm">
  <table>
    <thead>
      <tr>
        <th>Menu Item</th>
        <th>Price (₱)</th>
        <th>Quantity</th>
      </tr>
    </thead>
    <tbody id="menuTableBody">
      <!-- JavaScript will fill this -->
    </tbody>
  </table>

  <button type="submit">Submit Order</button>
</form>

<p id="message"></p>

<script>
  const menuItems = [
    { id: 1, name: "Arla Shawarma", price: 120 },
    { id: 2, name: "Chicken Shawarma", price: 100 },
    { id: 3, name: "Veggie Shawarma", price: 90 }
  ];

  const tableBody = document.getElementById("menuTableBody");

  // Populate table
  menuItems.forEach(item => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${item.name}</td>
      <td>₱${item.price}</td>
      <td>
        <input type="number" min="0" value="0" data-id="${item.id}" data-price="${item.price}" />
      </td>
    `;
    tableBody.appendChild(row);
  });

  const form = document.getElementById("orderForm");
  const message = document.getElementById("message");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const inputs = document.querySelectorAll('input[type="number"]');
    const items = [];

    inputs.forEach(input => {
      const quantity = parseInt(input.value);
      if (quantity > 0) {
        items.push({
          id: parseInt(input.dataset.id),
          quantity,
          price: parseFloat(input.dataset.price)
        });
      }
    });

    if (items.length === 0) {
      message.textContent = "Please select at least one item.";
      message.className = "error";
      return;
    }

    try {
      const response = await fetch("createorder.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ items })
      });

      const result = await response.json();
      if (result.status === "success") {
        message.textContent = `Order #${result.order_id} has been created successfully.`;
        message.className = "success";
        form.reset();
      } else {
        message.textContent = "Error: " + result.message;
        message.className = "error";
      }
    } catch (err) {
      message.textContent = "Failed to submit order.";
      message.className = "error";
    }
  });
</script>

</body>
</html>
