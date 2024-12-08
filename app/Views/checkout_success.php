<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="alert alert-success">
        <h4>Checkout Successful!</h4>
        <p>Your transaction ID is <strong>#<?= $transactionId; ?></strong></p>
    </div>
    <a href="/" class="btn btn-primary">Back to Home</a>
</div>
<?= $this->endSection() ?>