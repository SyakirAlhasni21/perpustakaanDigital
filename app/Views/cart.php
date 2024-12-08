<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="mb-4">Your Cart</h1>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('msg')): ?>
        <div class="alert alert-info">
            <?= htmlspecialchars((string) session()->getFlashdata('msg')) ?>
        </div>
    <?php endif; ?>

    <!-- Display Cart Items -->
    <?php if (!empty($cart)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>ISBN</th>
                    <th>Quantity</th>
                    <th>Date Added</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['JudulBuku'] ?? 'Unknown') ?></td>
                        <td><?= htmlspecialchars($item['ISBN']) ?></td>
                        <td>
                            <form action="/cart/updateQuantity" method="post" class="d-inline">
                                <input type="hidden" name="isbn" value="<?= htmlspecialchars($item['ISBN']) ?>">
                                <button type="submit" name="quantity" value="decrease" class="btn btn-sm btn-warning">-</button>
                                <?= htmlspecialchars($item['Quantity']) ?>
                                <button type="submit" name="quantity" value="increase" class="btn btn-sm btn-success">+</button>
                            </form>
                        </td>
                        <td><?= htmlspecialchars($item['DateAdded']) ?></td>
                        <td>
                            <form action="/cart/remove" method="post" class="d-inline">
                                <input type="hidden" name="isbn" value="<?= htmlspecialchars($item['ISBN']) ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Checkout Button -->
        <div class="text-end mt-3">
            <form action="/checkout" method="post">
                <button type="submit" class="btn btn-primary btn-lg">Proceed to Checkout</button>
            </form>
        </div>
    <?php else: ?>
        <p>Your cart is empty. <a href="/">Browse books</a> to add some!</p>
    <?php endif; ?>
</div>

<script src="<?= base_url('js/bootstrap.bundle.min.js') ?>"></script>
<?= $this->endSection() ?>