<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Products</title>
</head>
<body>
<?= $this->extend('layouts/Header'); ?>

<?= $this->section('content'); ?>

<div class="bg-gray-100">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-2xl py-16 sm:py-24 lg:max-w-none lg:py-32">
            <h2 class="text-2xl font-bold text-gray-900"><?= $category['name']; ?> Products</h2>

            <div class="mt-6 space-y-12 lg:grid lg:grid-cols-3 lg:gap-x-6 lg:space-y-0">
            <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                      <a href="/ProductDetail/<?= $product['id']; ?>" class="group">
                            <img src="<?= $product['photo']; ?> " 
                                 alt="<?= esc($product['name']) ?>" 
                                 class="aspect-square w-full rounded-lg bg-gray-200 object-cover group-hover:opacity-75 xl:aspect-[7/8]">
                            <h3 class="mt-4 text-sm text-gray-700"><?= esc($product['name']) ?></h3>
                            <p class="mt-1 text-sm text-gray-500"><?= esc($product['description']) ?></p>
                            <p class="mt-1 text-lg font-medium text-gray-900">Rp<?= number_format($product['price'], 0, ',', '.') ?></p>
                            <span class="mt-2 inline-block text-xs px-2 py-1 rounded-full <?= $product['status'] === 'sold out' ? 'bg-red-200 text-red-800' : 'bg-green-200 text-green-800' ?>">
                                <?= esc($product['status']) ?>
                            </span>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500">Tidak ada produk yang tersedia.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
</body>
</html>
