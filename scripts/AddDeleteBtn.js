document.addEventListener('DOMContentLoaded',() => {
    const addBtn = document.getElementById('add_product_btn');
    addBtn.addEventListener('click', () => {
        window.location.href = 'AddProduct.php';
    });
});


(function massDeleteBtnFunctionality() {
    let massDeleteBtn = $("header div button").eq(1);
    let form = $("section form").eq(0);

    massDeleteBtn.on('click', function() {
        let checkboxes = $("section form input[type=checkbox]:checked");

        if(checkboxes.length == 0) 
            alert('Please, select products to delete');
        else 
            form.submit();
    });
})();

(function footerAdaptiveness() {
    let products = $(".product-item"); // Ensure the class matches your HTML

    if (products.length > 8) {
        // Calculate number of rows based on 4 items per row
        let rowCount = Math.ceil(products.length / 4);

        // Adjust the gap size, assuming each row roughly occupies 200px height
        let gapSize = (rowCount - 3) * 200; // Adjust as necessary for your design

        // Set the footer's bottom position dynamically
        $("footer").css("bottom", -gapSize + 'px');
    } else {
        // Reset to default if not exceeding 8 products
        $("footer").css("bottom", '0px');
    }
})();