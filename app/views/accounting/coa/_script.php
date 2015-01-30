<script>
    biz.coa = (function($) {
        var pub = {
            onParentSearch: function(event, ui) {
                $('#coa-parent_id').removeAttr('value');
            },
            onParentSelect: function(event, ui) {
                $('#coa-parent_id').val(ui.item.id);
            },
        }
        return pub;
    })(window.jQuery);
</script>