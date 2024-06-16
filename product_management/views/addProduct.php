<?php
session_start();
require '../../config.php';
include $ROOT_PATH . "header.php"; // Include the header file
$shelfID = $_GET['shelfID']; // Get shelf ID from URL 
?>

<div class="container mx-auto p-4">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-4">Add New Product</h1>
        <form action=<?php echo htmlspecialchars("../controllers/processAddProduct.php?shelfID=" . $shelfID); ?> method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Product Name</label>
                <input type="text" name="name" id="name" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="category" class="block text-gray-700">Category</label>
                <input type="text" name="category" id="category" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="initialQuantity" class="block text-gray-700">Initial Quantity</label>
                <input type="number" name="initialQuantity" id="initialQuantity" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="currentQuantity" class="block text-gray-700">Current Quantity</label>
                <input type="number" name="currentQuantity" id="currentQuantity" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="buyDate" class="block text-gray-700">Buy Date</label>
                <input type="date" name="buyDate" id="buyDate" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="expiringDate" class="block text-gray-700">Expiring Date</label>
                <input type="date" name="expiringDate" id="expiringDate" class="w-full p-2 border border-gray-300 rounded-lg">
                <button type="button" onclick="document.getElementById('expiringDateCamera').click()" class="bg-yellow-500 text-white px-4 py-2 rounded-lg mt-2 flex items-center">
                    <i class="fas fa-camera mr-2"></i>
                    Scan Expiring Date
                </button>
                <input type="file" id="expiringDateCamera" class="hidden" accept="image/*" capture="environment">
            </div>
            <div class="mb-4">
                <label for="price" class="block text-gray-700">Unit Price</label>
                <input type="number" step="0.01" name="price" id="price" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4 text-center">
                <label for="imgProduct" class="block text-gray-700 mb-2">Product Image</label>

                <div class="flex flex-wrap justify-center">
                    <input type="file" name="imgProduct" id="imgProduct" class="hidden" accept="image/*">
                    <button type="button" onclick="document.getElementById('imgProduct').click()" class="bg-blue-500 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-upload mr-2"></i>
                        <span class="hidden sm:inline ml-2">Upload from File</span>
                    </button>

                    <input type="file" name="imgProductCamera" id="imgProductCamera" class="hidden" accept="image/*" capture="environment">
                    <button type="button" onclick="document.getElementById('imgProductCamera').click()" class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-camera mr-2"></i>
                        <span class="hidden sm:inline ml-2">Capture from Camera</span>
                    </button>
                </div>

            </div>
            <div class="mb-4 text-center">
                <button type="button" onclick="showProductModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Select Existing Product</button>
            </div>
            <div class="text-center">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Add Product</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div id="productModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-3/4 max-w-lg">
        <h2 class="text-xl font-bold mb-4">Select a Product</h2>
        <input type="text" id="searchInput" placeholder="Search products..." class="w-full p-2 mb-4 border border-gray-300 rounded-lg">
        <div id="productList" class="overflow-y-auto max-h-64">
            <!-- Products will be loaded here -->
        </div>
        <button type="button" onclick="hideProductModal()" class="bg-red-500 text-white px-4 py-2 rounded-lg mt-4">Close</button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/tesseract.js@2.1.1/dist/tesseract.min.js"></script>

<script>
    const BASE_URL = '<?php echo $BASE_URL; ?>';

    function showProductModal() {
        document.getElementById('productModal').classList.remove('hidden');
        fetchProducts();
    }

    function hideProductModal() {
        document.getElementById('productModal').classList.add('hidden');
    }

    async function fetchProducts() {
        try {
            const response = await fetch(BASE_URL + 'endpoints-API/fetchProductsTemplate.php');
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            products = await response.json();
            displayProducts(products);
        } catch (error) {
            console.error('Fetch error:', error);
            // show an error message to the user
        }
    }

    function displayProducts(productsToDisplay) {
        const productList = document.getElementById('productList');
        productList.innerHTML = '';

        productsToDisplay.forEach(product => {
            const productItem = document.createElement('div');
            productItem.className = 'p-2 border-b border-gray-300 cursor-pointer';
            productItem.innerHTML = `
                <div class="flex items-center">
                    <img src="${BASE_URL}uploads/${product.imgProduct}" alt="${product.name}" class="h-12 w-12 object-cover rounded-lg mr-4">
                    <div>
                        <p class="font-bold">${product.name}</p>
                        <p class="text-gray-600">${product.category}</p>
                    </div>
                </div>
            `;
            productItem.onclick = () => selectProduct(product);
            productList.appendChild(productItem);
        });
    }

    function selectProduct(product) {
        document.getElementById('name').value = product.name;
        document.getElementById('category').value = product.category;
        // set an image preview
        const imgInput = document.getElementById('imgProduct');
        const imgPreview = document.getElementById('imgProductPreview');
        if (imgPreview) {
            imgPreview.src = `${BASE_URL}uploads/${product.imgProduct}`;
        } else {
            const img = document.createElement('img');
            img.id = 'imgProductPreview';
            img.src = `${BASE_URL}uploads/${product.imgProduct}`;
            img.className = 'h-64 w-full object-cover rounded-lg mb-4';
            imgInput.insertAdjacentElement('beforebegin', img);
        }

        hideProductModal();
    }

    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const filteredProducts = products.filter(product => {
            return product.name.toLowerCase().includes(searchTerm) || product.category.toLowerCase().includes(searchTerm);
        });
        displayProducts(filteredProducts);
    });

    // Handling expiring date scanning
    document.getElementById('expiringDateCamera').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            Tesseract.recognize(
                file,
                'eng',
                {
                    logger: m => console.log(m)
                }
            ).then(({ data: { text } }) => {
                const dateText = extractDate(text);
                if (dateText) {
                    document.getElementById('expiringDate').value = dateText;
                } else {
                    alert('No valid date found. Please try again.');
                }
            }).catch(error => {
                console.error(error);
                alert('Error recognizing date. Please try again.');
            });
        }
    });

    function extractDate(text) {
        const datePattern = /(\d{4}-\d{2}-\d{2})|(\d{2}\/\d{2}\/\d{4})|(\d{2}-\d{2}-\d{4})/;
        const match = text.match(datePattern);
        if (match) {
            // Convert date to YYYY-MM-DD format if necessary
            let date = match[0];
            if (date.includes('/')) {
                const parts = date.split('/');
                date = `${parts[2]}-${parts[0].padStart(2, '0')}-${parts[1].padStart(2, '0')}`;
            } else if (date.includes('-') && date.length === 10 && date.charAt(2) === '-') {
                const parts = date.split('-');
                date = `${parts[2]}-${parts[1].padStart(2, '0')}-${parts[0].padStart(2, '0')}`;
            }
            return date;
        }
        return null;
    }
</script>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            const buyDateInput = document.getElementById('buyDate');
            const initialQuantityInput = document.getElementById('initialQuantity');
            const currentQuantityInput = document.getElementById('currentQuantity');

            // Set today's date to the buy date input field
            const today = new Date();
            const year = today.getFullYear();
            const month = ('0' + (today.getMonth() + 1)).slice(-2);
            const day = ('0' + today.getDate()).slice(-2);
            buyDateInput.value = `${year}-${month}-${day}`;

            function setInitialQuantity() {
                currentQuantityInput.value = initialQuantityInput.value;
            }

            initialQuantityInput.addEventListener('input', setInitialQuantity);

            currentQuantityInput.addEventListener('input', function() {
                if (parseInt(currentQuantityInput.value) > parseInt(initialQuantityInput.value)) {
                    currentQuantityInput.value = initialQuantityInput.value;
                    alert('Current quantity cannot be more than initial quantity.');
                }
            });

            // Set the initial quantity value when the page loads
            setInitialQuantity();
        });
    </script>

</body>
</html>
