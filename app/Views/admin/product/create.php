<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <?= $this->extend('layoutadmin/Header'); ?>
    <?= $this->section('content'); ?>
    
    <div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
        <!-- Form -->
        <form action="<?= base_url('/admin/product/store'); ?>" method="post" enctype="multipart/form-data" onsubmit="removeRupiahSymbol()">
        <!-- Input Name -->
        <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                <input type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Product Name" required />
            </div>

            <!-- Input Description -->
            <div class="mb-5">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                <textarea id="description" name="description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Product Description" required></textarea>
            </div>

            <!-- Input Price -->
            <div class="mb-5">
    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
    <input 
        type="text" 
        id="price" 
        name="price" 
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
        placeholder="Product Price" 
        required 
        oninput="formatRupiah(this)"
    />
</div>

            <!-- Input Color -->
            <div class="mb-5">
                <label for="color" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Color</label>
                <input type="text" id="color" name="color" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Product Color" required />
            </div>

            <!-- Select Category -->
            <div class="mb-5">
    <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Category</label>
    <select id="category_id" name="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        <option value="">Select a category</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
        <?php endforeach; ?>
    </select>
</div>

            <!-- Dropzone -->
             <div class="flex items-center justify-center w-full">
                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
        <div class="flex flex-col items-center justify-center pt-5 pb-6">
            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
            </svg>
            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
        </div>
        <!-- File input -->
        <input id="dropzone-file" type="file" name="photo" class="hidden" />
    </label>
</div>


            <!-- Submit Button -->
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </form>
    </div>
</div>


<script>
    function formatRupiah(element) {
        let value = element.value.replace(/\D/g, ''); // Remove non-numeric characters
        value = new Intl.NumberFormat('id-ID').format(value); // Format as Rupiah
        element.value = 'Rp ' + value; // Add 'Rp' and set the value back
    }

    // Fungsi untuk menghapus simbol 'Rp' sebelum mengirimkan form
    function removeRupiahSymbol() {
        const priceInput = document.getElementById('price');
        let value = priceInput.value.replace(/\D/g, ''); // Remove non-numeric characters (including 'Rp')
        priceInput.value = value; // Set the value back without 'Rp'
    }
</script>

    
    <?= $this->endSection(); ?>
</body>
</html>
