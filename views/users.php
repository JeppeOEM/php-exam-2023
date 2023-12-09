<?php

$order_id = $_GET['order_id'];
$db = _db();
$q = $db->prepare('SELECT * FROM users2 WHERE user_role = "partner"');
$q->execute();
$partners = $q->fetchAll();
$q = $db->prepare('SELECT * FROM users2 WHERE user_role = "user"');
$q->execute();
$users = $q->fetchAll();
?>

<main id="users_admin" class="page">
    <h2 class="text-2xl font-bold mb-4">USERS</h2>
    <div class="overflow-x-auto px-12">
        <div class="table-container max-h-96 overflow-y-auto">
            <table class="min-w-full border rounded-lg">
                <thead>
                    <tr>
                        <th class="border bg-gray-200 px-4 py-1">ID</th>
                        <th class="border bg-gray-200 px-4 py-1">Name</th>
                        <th class="border bg-gray-200 px-4 py-1">Last Name</th>
                        <th class="border bg-gray-200 px-4 py-1">Email</th>
                        <th class="border bg-gray-200 px-4 py-1">Role</th>
                        <th class="border bg-gray-200 px-4 py-1">Blocked</th>
                        <th class="border bg-gray-200 px-4 py-1">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td class="border px-4 py-1 text-center"><?= $user['user_id'] ?></td>
                            <td class="border px-4 py-1 text-center"><?= $user['user_name'] ?></td>
                            <td class="border px-4 py-1 text-center"><?= $user['user_last_name'] ?></td>
                            <td class="border px-4 py-1 text-center"><?= $user['user_email'] ?></td>
                            <td class="border px-4 py-1 text-center"><?= $user['user_role'] ?></td>
                            <td class="border px-4 py-1 text-center">
                                <button class="<?= $user['user_blocked'] == 0 ? 'bg-green-500' : 'bg-red-500' ?> text-white px-4 py-1 rounded text-center" onclick="toggle_blocked(event, <?= $user['user_id'] ?>, <?= $user['user_blocked'] ?>)">
                                    <?= $user['user_blocked'] == 0 ? "Unblocked" : "Blocked" ?>
                                </button>
                            </td>
                            <td class="border px-4 py-1 text-center">
                                <button class="bg-red-500 text-white px-4 py-1 rounded " onclick="delete_user(<?= $user['user_id'] ?>)">
                                    Delete User
                                </button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <h2 class="text-2xl font-bold my-4">PARTNERS</h2>
    <div class="overflow-x-auto px-12">
        <div class="table-container max-h-96 overflow-y-auto">
            <table class="min-w-full border rounded-lg">
                <thead>
                    <tr>
                        <th class="border bg-gray-200 px-4 py-1">ID</th>
                        <th class="border bg-gray-200 px-4 py-1">Name</th>
                        <th class="border bg-gray-200 px-4 py-1">Last Name</th>
                        <th class="border bg-gray-200 px-4 py-1">Email</th>
                        <th class="border bg-gray-200 px-4 py-1">Role</th>
                        <th class="border bg-gray-200 px-4 py-1">Blocked</th>
                        <th class="border bg-gray-200 px-4 py-1">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($partners as $partner) : ?>
                        <tr>
                            <td class="border px-4 py-1"><?= $partner['user_id'] ?></td>
                            <td class="border px-4 py-1"><?= $partner['user_name'] ?></td>
                            <td class="border px-4 py-1"><?= $partner['user_last_name'] ?></td>
                            <td class="border px-4 py-1"><?= $partner['user_email'] ?></td>
                            <td class="border px-4 py-1"><?= $partner['user_role'] ?></td>
                            <td class="border px-4 py-1">
                                <button class="<?= $partner['user_blocked'] == 0 ? 'bg-green-500' : 'bg-red-500' ?> text-white px-4 py-1 rounded" onclick="toggle_blocked(event, <?= $partner['user_id'] ?>, <?= $partner['user_blocked'] ?>)">
                                    <?= $partner['user_blocked'] == 0 ? "Unblocked" : "Blocked" ?>
                                </button>
                            </td>
                            <td class="border px-4 py-1">
                                <button class="bg-red-500 text-white px-4 py-1 rounded" onclick="delete_user(<?= $partner['user_id'] ?>)">
                                    Delete User
                                </button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</main>