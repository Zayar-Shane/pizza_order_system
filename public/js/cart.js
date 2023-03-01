
$(document).ready(function () {
    // when + button click
    $('.btn-plus').click(function() {
        $parentNode = $(this).parents("tr");
        claculateClick($parentNode);
        summaryCalculation();
    });

    // when - button click
    $('.btn-minus').click(function() {
        $parentNode = $(this).parents("tr");
        claculateClick($parentNode);
        summaryCalculation();
    });

    // calculate total value
    function claculateClick($parentNode) {
        $price = Number($parentNode.find('#price').html().replace("Kyats", ""));
        $qty = Number($parentNode.find('#qty').val());
        $total = $price * $qty;
        $parentNode.find('#total').html($total + " " + "Kyats");
    }

    // calculate final total value
    function summaryCalculation() {
        $subTotal = 0;
        $('.priceList tbody tr').each(function(index, row) {
            $subTotal += Number($(row).find('#total').text().replace("Kyats", ""));
        });
        $('#subTotal').html(`${$subTotal} Kyats`);
        $('#finalTotal').html(`${$subTotal + 3000} Kyats`);
    }
});
