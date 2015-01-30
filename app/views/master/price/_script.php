<script>
    biz.price = (function($) {
        var pub = {
            onProductSearch: function(event, ui) {
                $('#price-product_id').removeAttr('value');
            },
            onProductSelect: function(event, ui) {
                $('#price-product_id').val(ui.item.id);
            }
        }
        return pub;
    })(window.jQuery);
</script>