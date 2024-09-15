
(function dynamicForm() {
    let typeSwitcher = $("#productType");

    typeSwitcher.on('change', function(){
        let fieldName = typeSwitcher.val() + "-info";
        let infos = $("fieldset");

        infos.hide();
        let neededInfo = $("#" + fieldName);
        neededInfo.css("display","flex");

    });
})();

(function saveBtn(){
    let btnSave = $("header div button").eq(0);
    let form = $("form").eq(0);

    btnSave.on("click", function(){
        checkFormFields(form);
    });
})();

(function cancelBtn(){
    let btnCancel =  $("header div button").eq(1);
    btnCancel.on("click", function(){
        window.location.href = "ProductList.php";
    });
})();

function checkFormFields(form) {
    let inputs = $("input:visible");
    let warning = $("#input-warning");
    let takenSkuValues = $("#sku-taken-values-container").text();

    for(let i = 0; i < inputs.length; i++) {
        if(inputs.eq(i).val().length == 0) {
            warning.text("Please, submit required data");
            if(warning.is(":hidden"))
                warning.slideToggle();
            return;
        }

        switch(i) {
            case 0:
                const valueArray = takenSkuValues.split(' ');
                for(let i = 0; i < valueArray.length; i++) {
                    if(valueArray[i] == inputs.eq(0).val()) {
                        warning.text("SKU is taken, try another");
                        if(warning.is(":hidden"))
                            warning.slideToggle();
                        return;
                    }
                }
                break;
            case 2:
            case 3:
            case 4:
            case 5:
                if(parseFloat(inputs.eq(i).val()) <= 0) {
                    warning.text("Please, provide the data of indicated type");
                    if(warning.is(":hidden"))
                        warning.slideToggle();
                    return;
                }
                break;  
        }
        
    }

    form.submit();
}

