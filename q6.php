<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu Card</title>
  <style>
    body {
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #f2f2f2;
    }

    .menu {
      text-align: center;
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }

    button {
      padding: 10px 20px;
      font-size: 16px;
      border: none;
      background-color: #4CAF50;
      color: white;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin-bottom: 10px;
    }

    button:hover {
      background-color: #45a049;
    }

    input[type="checkbox"] {
      margin-right: 5px;
    }

    #totalCost {
      font-size: 18px;
      font-weight: bold;
    }
  </style>
</head>

<body>

  <div class="menu">
    <h2>Menu Card</h2>
    <button onclick="addItem('Burger')">Burger</button>
    <button onclick="addItem('Fries')">Fries</button>
    <button onclick="addItem('Pizza')">Pizza</button>
    <button onclick="addItem('Pasta')">Pasta</button>
    <button onclick="addItem('Salad')">Salad</button>
    <button onclick="addItem('Coke')">Coke</button>
    <div id="totalCost"></div>
  </div>


  <script>
    let totalCost = 0;

    function addItem(itemName) {
      const menu = document.querySelector('.menu');
      const itemDiv = document.createElement('div');
      const checkbox = document.createElement('input');
      const label = document.createElement('label');

      checkbox.type = 'checkbox';
      checkbox.addEventListener('change', function() {
        if (this.checked) {
          label.textContent = 'Final price: $' + (parseFloat(this.value) * 2);
          totalCost += parseFloat(this.value) * 2;
        } else {
          label.textContent = '';
          totalCost -= parseFloat(this.value) * 2;
        }
        updateTotalCost();
      });

      switch (itemName) {
        case 'Burger':
          checkbox.value = 5;
          break;
        case 'Fries':
          checkbox.value = 4;
          break;
        case 'Pizza':
          checkbox.value = 8;
          break;
        case 'Pasta':
          checkbox.value = 10;
          break;
        case 'Salad':
          checkbox.value = 6;
          break;
        case 'Coke':
          checkbox.value = 3;
          break;
        default:
          break;
      }

      label.textContent = itemName + ': $' + checkbox.value;

      itemDiv.appendChild(checkbox);
      itemDiv.appendChild(label);
      menu.appendChild(itemDiv);
    }

    function updateTotalCost() {
      const totalCostElement = document.getElementById('totalCost');
      totalCostElement.textContent = "Total Cost: $" + totalCost;
    }
  </script>

</body>

</html>