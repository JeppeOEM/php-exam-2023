document.addEventListener("DOMContentLoaded", () => {
  q("#logout").addEventListener("click", () => {
    empty_cart();
    item_count("cart");
  });
  const index_page = q("#pages");
  const user = index_page.getAttribute("data-session");
  item_count("cart");
  if (user === "user") {
    // Your JavaScript function or code for logged-in users
    show_page("restaurants", build_restaurants);
  } else if (user === "partner") {
    show_page("orders_partner");
  } else if (user === "admin") {
    show_page("admin");
  } else {
    show_page("restaurants", build_restaurants);
  }

  q("#empty_cart").addEventListener("click", () => {
    empty_cart();
    item_count("cart");
  });
});

async function build_restaurants() {
  const json = await get_restaurants();
  const sorted = sort_az(json.restaurants, "restaurant_name");
  const restaurant_grid = q("#restaurant_grid");
  const template = q(".restaurant_article");
  remove_elements("restau");
  sorted.forEach((restaurant) => {
    const clone = template.content.cloneNode(true);
    q(".restaurant_name", clone).innerText = restaurant.restaurant_name;
    let article = q("article", clone);
    article.id = restaurant.restaurant_id;
    article.addEventListener("click", (event) => {
      get_products(event, restaurant.restaurant_name, restaurant.restaurant_id);
    });
    restaurant_grid.appendChild(clone);
  });
}

async function build_orders(user) {
  const json = await get_orders(user);
  let template, container, under_delivery;
  if (user === "admin") {
    container = q("#admin_orders");
    template = q("#admin_order");
    console.log("admin logged in");
    console.log(json, template, container);
  } else if (user === "partner") {
    container = q("#partner_orders");
    template = q("#partner_order");
    console.log("partner logged in");
  } else {
    container = q("#user_orders");
    template = q("#user_order");
    console.log("user logged in");
  }
  under_delivery = q("#under-delivery");
  console.log(under_delivery);
  // under_delivery_order = q("#under_delivery_order");
  console.log(json);
  // remove_elements("order_tr th");
  console.log(json.orders);
  await json.orders.forEach((order) => {
    const clone = template.content.cloneNode(true);
    const order_id = (q(".order_id", clone).innerText = order.order_id);
    // const restaurant_id = (q(".restaurant_id_order", clone).innerText = order.restaurant_fk);
    const user_id = (q(".user_id_order", clone).innerText = order.user_fk);
    q(".restaurant_name_order", clone).innerText = order.restaurant_name;
    q(".address_order", clone).innerText = order.address;
    q(".zip_order", clone).innerText = order.zip;
    q(".city_order", clone).innerText = order.city;
    q(".created_at_order", clone).innerText = to_date(order.created_at * 1000);
    const scheduled = (q(".scheduled_at_order", clone).innerText = to_date(order.scheduled_at * 1000));
    const modal_order = q(".modal_order", clone);
    build_modal(modal_order, order_id, order.restaurant_id);
    if (is_delivered(order.scheduled_at)) {
      container.appendChild(clone);
      console.log("DELIVERED");
    } else {
      console.log("Is Delivered:", is_delivered(order.scheduled_at));

      under_delivery.appendChild(clone);
    }
  });
}

async function build_modal(open_btn, order_id, restaurant_id) {
  const close = document.querySelector("#close_modal");
  const modal_order_info = document.querySelector("#modal");

  await open_btn.addEventListener("click", () => {
    console.log("click");
    build_single_order(order_id);
    modal_order_info.showModal();
  });

  close.addEventListener("click", () => {
    console.log("click");
    modal_order_info.close();
  });
}

async function build_single_order(order_id) {
  const response = await get_single_order(order_id);
  console.log(response);
  const order = response.products;
  console.log(order);
  // console.log(to_date(order.created_at), to_date(order.scheduled_at));
  // q("#modal_created").innerText = to_date(order.created_at);
  // q("#modal_scheduled").innerText = to_date(order.scheduled_at);
  // q("#modal_restaurant").innerText = order.restaurant_name;
  // q("#modal_address").innerText = order.address;
  // q("#modal_city").innerText = order.city;
  // q("#modal_zip").innerText = order.zip;
}

async function get_single_order(order_id) {
  console.log(order_id);
  try {
    const response = await fetch(`api/api-get-order-products.php?order_id=${order_id}`);
    // const response = await fetch(`api/api-get-single-order.php?order_id=${order_id}`);
    const data = await response.json();

    return data;
  } catch (error) {
    console.log("Error:", error);
  }
}

async function build_products(products, restaurant_name, restaurant_id) {
  const product_grid = q("#product_grid");
  const drinks_grid = q("#drinks_grid");
  const menu_grid = q("#menu_grid");
  sorted = sort_az(products.products, "product_name");
  q(".restaurant_title").innerText = restaurant_name;
  q(".restaurant_title").id = restaurant_id;
  const template = q("#product_article");
  remove_elements("product");
  sorted.forEach((product) => {
    const clone = template.content.cloneNode(true);
    q(".product_name", clone).innerText = product.product_name;
    q(".price", clone).innerText = product.price;
    let buy_btn = q(".buy", clone);
    buy_btn.id = product.product_id;
    buy_btn.setAttribute("data-restaurant", restaurant_id);
    buy_btn.addEventListener("click", (event) => {
      event.preventDefault();
      add_to_cart("cart", buy_btn.id);
      console.log(localStorage.getItem("cart"));
    });
    if (product.type === "food") {
      product_grid.appendChild(clone);
    } else if (product.type === "drink") {
      drinks_grid.appendChild(clone);
    } else {
      menu_grid.appendChild(clone);
    }
  });
}

function is_delivered(scheduled_at) {
  const current_time = new Date().getTime();

  //make into miliseconds
  // console.log(to_date(current_time), to_date(parseInt(scheduled_at) * 1000));
  if (current_time < parseInt(scheduled_at) * 1000) {
    return false;
  }
  return true;
}
