var showOrder = true;
var orderList = [];
var finalPrice = 0;

function changeTotalPrice() {
  finalPrice = 0;
  orderList.forEach((item) => (finalPrice += item.totalPrice));
  document.getElementById("totalPrice").innerText =
    finalPrice.toFixed(2) + " EGP";
}

function AddToOrder(product) {
  const title = product.querySelector(".card-title").textContent;
  const price = product.querySelector(".card-price").textContent;

  if (!orderList.some((Item) => Item.id == product.id)) {
    orderList.push({
      productName: title,
      id: product.id,
      quantity: 1,
      productPrice: parseFloat(price),
      totalPrice: parseFloat(price),
    });

    var orderDiv = document.getElementById("order");
    orderDiv.innerHTML += `<div id= "${product.id}" class="d-flex align-items-center align-content-center mb-3">
        <h5 style="width: 2em;">${title}</h5>
        <div class="d-flex align-items-center align-content-center mx-3">
          <button class="btn btn-danger px-3 minus-btn" onclick="decrement(this)">-</button>
          <h4 class="mx-3 mt-1 quantity">1</h4>
          <button class="btn btn-success px-3 plus-btn" onclick="Increment(this)">+</button>
        </div>
        <h5 class="price">${price}</h5>
      </div>`;
  }

  changeTotalPrice();
}

function Increment(element) {
  var product = orderList.find(
    (Item) => Item.id == element.parentNode.parentNode.id
  );
  if (product) {
    product.quantity = product.quantity + 1;
    product.totalPrice = product.productPrice * product.quantity;
    element.previousElementSibling.innerText = product.quantity;
    element.parentNode.nextElementSibling.innerText =
      product.totalPrice.toFixed(2) + " EGP";
  }

  changeTotalPrice();
}

function decrement(element) {
  var product = orderList.find(
    (Item) => Item.id == element.parentNode.parentNode.id
  );

  if (product) {
    if (product.quantity > 1) {
      product.quantity = product.quantity - 1;
      product.totalPrice = product.productPrice * product.quantity;
      console.log(product.quantity);
      element.nextElementSibling.innerText = product.quantity;
      element.parentNode.nextElementSibling.innerText =
        product.totalPrice.toFixed(2) + " EGP";
    } else if (product.quantity == 1) {
      element.parentNode.parentNode.remove();
      orderList.splice(
        orderList.findIndex((item) => item.id == product.id),
        1
      );
      console.log(orderList);
    }
  }

  changeTotalPrice();
}

function sendOrder() {
  var selectionElement = document.getElementById("roomOption");
  var selectionValue = selectionElement.value;

  var notesElement = document.getElementById("note").value;

  var orderDetails = {
    user_id: 1,
    room_id: selectionValue,
    status: "processing",
    total_price: finalPrice,
    notes: notesElement,
    order_items: orderList,
  };

  console.log(JSON.stringify(orderDetails));
  fetch("store_order.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(orderDetails),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
    })
    .catch((error) => {
      console.log(error);
    });
}
