<template>
    <div id="app">
        <h1>Products</h1>
        <div class="products-grid">
            <div v-for="product in products" :key="product.id" class="product-card">
                <h3>{{ product.name }}</h3>
                <p>{{ product.description }}</p>
                <p class="price">€{{ product.price }}</p>
                <div v-if="product.categories.length" class="categories">
                    <span v-for="category in product.categories" 
                          :key="category.id" 
                          class="category-tag">
                        {{ category.name }}
                    </span>
                </div>
                <Button label="Add to Cart" />
            </div>
        </div>
    </div>
</template>

<script>
    import Button from 'primevue/button';
    import { onMounted, ref } from 'vue';

    export default {
        name: 'ProductList',
        components: {
            Button
        },
        setup() {
            const products = ref([]);

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

            onMounted(() => {
                getProducts();
            });

            return {
                products
            };
        }
    };
</script>

<style scoped>
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 2rem;
    padding: 1rem;
}

.product-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 1rem;
    text-align: center;
}

.price {
    font-size: 1.25rem;
    font-weight: bold;
    color: #2c3e50;
}

.categories {
    margin: 0.5rem 0;
}

.category-tag {
    background-color: #e9ecef;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    margin: 0.25rem;
    display: inline-block;
    font-size: 0.875rem;
}
</style>
