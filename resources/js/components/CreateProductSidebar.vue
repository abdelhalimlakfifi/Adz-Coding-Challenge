<template>
    <Transition name="sidebar">
        <div class="sidebar-overlay" v-if="isOpen" @click.self="close">
            <div class="sidebar">
                <div class="sidebar-header">
                    <h2>Add New Product</h2>
                    <button class="close-button" @click="close">&times;</button>
                </div>
                <div class="sidebar-content">
                    <form @submit.prevent="handleSubmit">
                        <div class="form-group">
                            <label for="name">Product Name *</label>
                            <input 
                                type="text" 
                                id="name" 
                                v-model="form.name" 
                                required
                                :class="{ 'error': errors.name }"
                            >
                            <span class="error-message" v-if="errors.name">{{ errors.name }}</span>
                        </div>
                        <div class="form-group">
                            <label for="price">Price *</label>
                            <input 
                                type="number" 
                                id="price" 
                                v-model="form.price" 
                                step="0.01" 
                                required
                                :class="{ 'error': errors.price }"
                            >
                            <span class="error-message" v-if="errors.price">{{ errors.price }}</span>
                        </div>
                        <div class="form-group">
                            <label for="category">Categories *</label>
                            <select 
                                id="category" 
                                v-model="form.categories" 
                                multiple 
                                class="multiselect"
                                :class="{ 'error': errors.categories }"
                                required
                            >
                                <option v-for="category in categories" :key="category.id" :value="category.id">
                                    {{ category.name }}
                                </option>
                            </select>
                            <span class="error-message" v-if="errors.categories">{{ errors.categories }}</span>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" v-model="form.description" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Product Image</label>
                            <input 
                                type="file" 
                                id="image" 
                                @change="handleImageChange" 
                                accept="image/*"
                                class="file-input"
                            >
                        </div>
                        <button type="submit" class="submit-button">Create Product</button>
                    </form>
                </div>
            </div>
        </div>
    </Transition>
</template>

<script>
import { ref, onMounted } from 'vue';
import { createProduct } from '../services/product.service'; // Import the new function
import { fetchCategories } from '../services/categories.service'; // Import fetchCategories

export default {
    name: 'CreateProductSidebar',
    props: {
        isOpen: {
            type: Boolean,
            required: true
        }
    },
    emits: ['close', 'product-created'],
    setup(props, { emit }) {
        const categories = ref([]);
        const form = ref({
            name: '',
            price: '',
            categories: [],
            description: '',
            image: null
        });
        
        const errors = ref({
            name: '',
            price: '',
            categories: ''
        });

        const getCategories = async () => {
            try {
                categories.value = await fetchCategories(); // Use the imported function
                console.log(categories.value);
            } catch (error) {
                console.error('Error fetching categories:', error);
            }
        };

        onMounted(() => {
            getCategories();
        });

        const close = () => {
            emit('close');
        };

        const handleImageChange = (event) => {
            form.value.image = event.target.files[0];
        };

        const validateForm = () => {
            let isValid = true;
            errors.value = {
                name: '',
                price: '',
                categories: ''
            };

            if (!form.value.name.trim()) {
                errors.value.name = 'Product name is required';
                isValid = false;
            }

            if (!form.value.price || form.value.price <= 0) {
                errors.value.price = 'Valid price is required';
                isValid = false;
            }

            if (!form.value.categories.length) {
                errors.value.categories = 'At least one category must be selected';
                isValid = false;
            }

            return isValid;
        };

        const handleSubmit = async () => {
            try {
                // Validate form data
                if (!validateForm()) {
                    return;
                }

                // Prepare the form data object
                const productData = {
                    name: form.value.name,
                    price: form.value.price,
                    description: form.value.description,
                    image: form.value.image,
                    categories: form.value.categories
                };

                // Make the API call using the new service function
                const data = await createProduct(productData);
                
                // Emit the created product
                emit('product-created', data);
                
                // Reset form
                form.value = {
                    name: '',
                    price: '',
                    categories: [],
                    description: '',
                    image: null
                };
                
                // Close the sidebar
                close();
            } catch (error) {
                console.error('Error creating product:', error);
                // Here you might want to add error handling UI feedback
            }
        };

        return {
            form,
            categories,
            errors,
            close,
            handleSubmit,
            handleImageChange
        };
    }
};
</script>

<style scoped>
.sidebar-overlay {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(15, 23, 42, 0.3);  /* Modern semi-transparent overlay */
    backdrop-filter: blur(4px);  /* Modern blur effect */
    display: flex;
    justify-content: flex-end;
    z-index: 1000;
}

.sidebar {
    width: 400px;
    background-color: #ffffff;
    height: 100%;
    padding: 2rem;
    box-shadow: -8px 0 25px -10px rgba(0, 0, 0, 0.15);  /* Softer, modern shadow */
}

.sidebar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.sidebar-header h2 {
    font-weight: 600;
    color: #0f172a;  /* Modern slate color */
}

.close-button {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #64748b;  /* Modern slate gray */
    transition: color 0.2s ease;
}

.close-button:hover {
    color: #0f172a;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: #334155;  /* Modern slate */
    font-weight: 500;
    font-size: 0.875rem;
}

.form-group label::after {
    content: " *";
    color: #ef4444;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 0.625rem;
    border: 1px solid #e2e8f0;  /* Modern border color */
    border-radius: 0.5rem;
    background-color: #f8fafc;  /* Light background */
    transition: all 0.2s ease;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #3b82f6;  /* Modern blue */
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);  /* Subtle focus ring */
    background-color: #ffffff;
}

.submit-button {
    width: 100%;
    padding: 0.75rem;
    background-color: #3b82f6;  /* Modern blue */
    color: white;
    border: none;
    border-radius: 0.5rem;
    cursor: pointer;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.submit-button:hover {
    background-color: #2563eb;  /* Darker blue on hover */
    transform: translateY(-1px);  /* Subtle lift effect */
}

.submit-button:active {
    transform: translateY(0);
}

/* Animation styles */
.sidebar-enter-active,
.sidebar-leave-active {
    transition: opacity 0.3s ease;
}

.sidebar-enter-active .sidebar,
.sidebar-leave-active .sidebar {
    transition: transform 0.3s ease;
}

.sidebar-enter-from,
.sidebar-leave-to {
    opacity: 0;
}

.sidebar-enter-from .sidebar,
.sidebar-leave-to .sidebar {
    transform: translateX(100%);
}

.sidebar-enter-to,
.sidebar-leave-from {
    opacity: 1;
}

.sidebar-enter-to .sidebar,
.sidebar-leave-from .sidebar {
    transform: translateX(0);
}

.multiselect {
    min-height: 100px;
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 0.5rem;
    padding: 0.5rem;
    width: 100%;
}

.multiselect:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    background-color: #ffffff;
}

.multiselect option {
    padding: 0.5rem;
    margin: 0.25rem 0;
}

.file-input {
    width: 100%;
    padding: 0.625rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.5rem;
    background-color: #f8fafc;
    transition: all 0.2s ease;
}

.file-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    background-color: #ffffff;
}

.error {
    border-color: #ef4444 !important;
    background-color: #fef2f2 !important;
}

.error:focus {
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
}

.error-message {
    color: #ef4444;
    font-size: 0.75rem;
    margin-top: 0.25rem;
    display: block;
}

/* Remove asterisk for optional fields */
.form-group label[for="description"]::after,
.form-group label[for="image"]::after {
    content: none;
}
</style> 