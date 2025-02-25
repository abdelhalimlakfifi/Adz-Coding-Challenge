export const fetchProducts = async (selectedCategory, sortBy) => {
    try {
        let url = '/api/v1/products';
        const params = new URLSearchParams();
        
        if (selectedCategory) {
            params.append('category', selectedCategory);
        }
        
        if (sortBy) {
            params.append('sort_price', sortBy === 'high' ? 'desc' : 'asc');
        }

        if (params.toString()) {
            url += `?${params.toString()}`;
        }

        const response = await fetch(url);
        return await response.json();
    } catch (error) {
        console.error('Error fetching products:', error);
        return [];
    }
};

export const createProduct = async (form) => {
    try {
        // Create FormData object
        const formData = new FormData();
        formData.append('name', form.name);
        formData.append('price', form.price);
        formData.append('description', form.description);
        if (form.image) {
            formData.append('image', form.image);
        }
        form.categories.forEach(categoryId => {
            formData.append('categories[]', categoryId);
        });

        const response = await fetch('/api/v1/products', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
            },
            body: formData
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        return await response.json();
    } catch (error) {
        console.error('Error creating product:', error);
        throw error; // Rethrow the error for handling in the component
    }
};



