<template>
    <div id="main">
        <div class="header-container">
            <h1>Products</h1>
            <button class="add-product-button" @click="openSidebar">
                Add Product
            </button>
        </div>
        <div class="filters-container">
            <select class="filter-select" v-model="selectedCategory">
                <option value="">All Categories</option>
                <option v-for="category in categories" 
                        :key="category.id" 
                        :value="category.id">
                    {{ category.name }}
                </option>
            </select>
            <select class="filter-select" v-model="sortBy">
                <option value="">Sort by Price</option>
                <option value="low">Price: Low to High</option>
                <option value="high">Price: High to Low</option>
            </select>
        </div>
        <div class="products-grid">
            <ProductCard 
                v-for="product in filteredAndSortedProducts" 
                :key="product.id" 
                :product="product" 
            />
        </div>
    </div>
    <CreateProductSidebar 
        :is-open="isSidebarOpen" 
        @close="closeSidebar"
        @product-created="handleProductCreated"
    />
</template>

<script>
    import { onMounted, ref, computed } from 'vue';
    import ProductCard from '../components/ProductCard.vue';
    import CreateProductSidebar from '../components/CreateProductSidebar.vue';

    export default {
        name: 'ProductList',
        components: {
            ProductCard,
            CreateProductSidebar
        },
        setup() {
            const products = ref([]);
            const isSidebarOpen = ref(false);
            const selectedCategory = ref('');
            const sortBy = ref('');
            const categories = ref([]);

            const filteredAndSortedProducts = computed(() => {
                let filtered = [...products.value];
                
                // Apply category filter
                if (selectedCategory.value) {
                    filtered = filtered.filter(product => {
                        // console.log(JSON.stringify(product.categories));
                        const obj = JSON.parse(JSON.stringify(product.categories));
                        console.log(obj)
                        console.log(selectedCategory.value)
                        return obj.some(category => category.id === selectedCategory.value)
                    }
                    );
                }
                
                // Apply price sorting
                if (sortBy.value) {
                    filtered.sort((a, b) => {
                        if (sortBy.value === 'low') {
                            return a.price - b.price;
                        } else {
                            return b.price - a.price;
                        }
                    });
                }
                
                return filtered;
            });

            const getProducts = async () => {
                try {
                    const response = await fetch('/api/v1/products');
                    const data = await response.json();
                    products.value = data;
                } catch (error) {
                    console.error('Error fetching products:', error);
                    products.value = [];
                }
            };

            const getCategories = async () => {
                try {
                    const response = await fetch('/api/v1/categories');
                    const data = await response.json();
                    categories.value = data;
                } catch (error) {
                    console.error('Error fetching categories:', error);
                    categories.value = [];
                }
            };

            const openSidebar = () => {
                isSidebarOpen.value = true;
            };

            const closeSidebar = () => {
                isSidebarOpen.value = false;
            };

            const handleProductCreated = () => {
                getProducts(); // Refresh the products list
            };

            onMounted(() => {
                getProducts();
                getCategories();
            });

            return {
                products,
                isSidebarOpen,
                selectedCategory,
                sortBy,
                categories,
                filteredAndSortedProducts,
                openSidebar,
                closeSidebar,
                handleProductCreated
            };
        }
    };
</script>

<style scoped>
    #main {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    h1 {
        font-size: 2.5rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 2rem;
        text-align: center;
        position: relative;
    }

    h1::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background-color: #3498db;
        border-radius: 2px;
    }

    .filters-container {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        justify-content: flex-end;
    }

    .filter-select {
        padding: 0.5rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background-color: white;
        color: #4a5568;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s ease;
        min-width: 150px;
    }

    .filter-select:hover {
        border-color: #3498db;
    }

    .filter-select:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 2rem;
        padding: 1rem 0;
    }

    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .add-product-button {
        padding: 0.75rem 1.5rem;
        background-color: #3498db;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.95rem;
        transition: background-color 0.2s ease;
    }

    .add-product-button:hover {
        background-color: #2980b9;
    }

    @media (max-width: 768px) {
        #main {
            padding: 1rem;
        }

        h1 {
            font-size: 2rem;
        }

        .filters-container {
            flex-direction: column;
        }

        .filter-select {
            width: 100%;
        }

        .header-container {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>
