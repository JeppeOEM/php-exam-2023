<main id="orders_user" class="page">
    <section class="overflow-x-auto px-12 border-1 py-8 mt-8">

        <form class="search_orders_user flex flex-col py-2" method="post">
            <label for="search">Search Orders</label>
            <div>
                <input name="search" type="text" class="border border-blue-500 border-solid w-159 p-2 rounded-lg mb-4 text-black">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user']['user_id'] ?>">
                <button class="bg-blue-500 text-white p-2 px-4 rounded" type="submit">Search</button>
            </div>

        </form>
        <button onclick="build_orders('user')" class="bg-blue-500 text-white p-2 px-4 rounded">Reset search</button>

        <h2 class="text-2xl font-bold my-4 ">Under delivery</h2>
        <div class="table-container max-h-96 overflow-y-auto  ">
            <table class="min-w-full rounded-lg">
                <thead class="sticky top-0">
                    <tr class="[&>*]:border bg-gray-200 px-4 py-2">
                        <th>Order ID</th>
                        <th>User ID</th>
                        <th>Created At</th>
                        <th>Scheduled At</th>
                        <th>Restaurant Name</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Zip</th>
                        <th>View order</th>
                    </tr>
                </thead>
                <tbody id="under_delivery_user">
                </tbody>
            </table>
        </div>
        <p class="py-2">Address information is for the restaurant</p>
    </section>

    <section class="overflow-x-auto px-12 border-1 py-6">

        <h2 class="text-2xl font-bold my-4">Order history</h2>

        <div class="table-container max-h-96 overflow-y-auto  ">
            <table class="min-w-full rounded-lg">
                <thead class="sticky top-0">
                    <tr class="[&>*]:border bg-gray-200 px-4 py-2">
                        <th>Order ID</th>
                        <th>User ID</th>
                        <th>Created At</th>
                        <th>Scheduled At</th>
                        <th>Restaurant Name</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>ZIP Code</th>
                        <th>View order</th>

                    </tr>
                </thead>
                <tbody id="user_orders">
                    <template id="user_order">
                        <tr class="order_tr [&>*]:border px-8 py-2">
                            <td class="border px-8 py-2 order_id"></td>
                            <td class="border px-8 py-2 user_id_order"></td>
                            <td class="border px-8 py-2 created_at_order"></td>
                            <td class="border px-8 py-2 scheduled_at_order"></td>
                            <td class="border px-8 py-2 restaurant_name_order"></td>
                            <td class="border px-8 py-2 address_order"></td>
                            <td class="border px-8 py-2 city_order"></td>
                            <td class="border px-8 py-2 zip_order"></td>
                            <td class="border px-8 py-2">
                                <button class="bg-blue-500 text-white p-2 px-4 rounded modal_order">View order</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <p class="py-2">Address information is for the restaurant</p>
    </section>

</main>