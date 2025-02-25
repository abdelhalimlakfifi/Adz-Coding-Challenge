<template>
    <div class="product-card">
        <div class="product-image">
            <img :src="product.image_path ? '/storage/' + product.image_path : 'https://placehold.co/600x400'" :alt="product.name">
        </div>
        <div class="product-content">
            <h3>{{ product.name }}</h3>
            <p class="description">{{ product.description }}</p>
            <p class="price">€{{ product.price }}</p>
            <div class="categories">
                <template v-if="product.categories && product.categories.length">
                    <span v-for="category in product.categories" 
                          :key="category.id" 
                          class="category-tag">
                        {{ category.name }}
                    </span>
                </template>
                <span v-else class="category-tag no-category">
                    Uncategorized
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    import Button from 'primevue/button';
    import { defineComponent } from 'vue';

    export default defineComponent({
        name: 'ProductCard',
        components: {
            Button
        },
        props: {
            product: {
                type: Object,
                required: true
            }
        }
    });
</script>

<style scoped>
.product-card {
    border-radius: 12px;
    overflow: hidden;
    background: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
}

.product-image {
    width: 100%;
    height: 200px;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-content {
    padding: 1.5rem;
}

h3 {
    margin: 0 0 0.5rem;
    font-size: 1.25rem;
    color: #2d3748;
}

.description {
    color: #4a5568;
    font-size: 0.875rem;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.price {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.categories {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: 1rem;
}

.category-tag {
    background-color: #edf2f7;
    color: #4a5568;
    padding: 0.35rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    transition: background-color 0.2s ease;
}

.category-tag:hover {
    background-color: #e2e8f0;
}

.no-category {
    background-color: #cbd5e0;
    color: #2d3748;
}
</style>
