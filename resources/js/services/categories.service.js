
export const fetchCategories = async () => {
    try {
        const response = await fetch('/api/v1/categories');
        console.log(response);
        return await response.json();
    } catch (error) {
        console.error('Error fetching categories:', error);
        return [];
    }
};

