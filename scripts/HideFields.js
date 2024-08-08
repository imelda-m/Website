document.addEventListener('DOMContentLoaded', () => {
    const productTypeSelect = document.getElementById('productType');
    const dvdFields = document.getElementById('dvd-fields');
    const bookFields = document.getElementById('book-fields');
    const furnitureFields = document.getElementById('furniture-fields');

    productTypeSelect.addEventListener('change', () => {
        // Hide all type-specific fields initially
        dvdFields.style.display = 'none';
        bookFields.style.display = 'none';
        furnitureFields.style.display = 'none';

        // Show the relevant fields based on the selected product type
        const selectedType = productTypeSelect.value;
        if (selectedType === 'DVD') {
            dvdFields.style.display = 'block';
        } else if (selectedType === 'Book') {
            bookFields.style.display = 'block';
        } else if (selectedType === 'Furniture') {
            furnitureFields.style.display = 'grid';
        }
    });
});
