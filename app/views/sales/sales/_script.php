<script>
    biz.sales = (function($) {
        var local = {
            applyProduct: function($row, item, sel_uom) {
                $row.find('span.product').text(item.cd + ' ' + item.text);
                $row.find('input[data-field="product_id"]').val(item.id);

                // apply uoms
                var $select = $row.find('select[data-field="uom_id"]').html('');
                $.each(item.uoms, function() {
                    var $opt = $('<option>').val(this.id).text(this.nm).attr('data-isi', this.isi);
                    if (sel_uom !== undefined && sel_uom == this.id) {
                        $opt.prop('selected', true);
                    }
                    $select.append($opt);
                });
            },
            addItem: function(item) {
                var has = false;
                $.each($('#detail-grid').mdmTabularInput('getAllRows'), function() {
                    var $row = $(this);
                    if ($row.find('input[data-field="product_id"]').val() == item.id) {
                        has = true;
                        var $qty = $row.find('input[data-field="qty"]');
                        $qty.val($qty.val() == '' ? '2' : $qty.val() * 1 + 1);
                    }
                });
                if (!has) {
                    var $row = $('#detail-grid').mdmTabularInput('addRow');

                    local.applyProduct($row, item);
                    $row.find('input[data-field="qty"]').val('1');
                    $('#detail-grid').mdmTabularInput('selectRow', $row);
                    $row.find('input[data-field="qty"]').focus();
                }
                local.normalizeItem();
            },
            normalizeItem: function() {
                var total = 0.0;
                $.each($('#detail-grid').mdmTabularInput('getAllRows'), function() {
                    var $row = $(this);
                    var q = $row.find('input[data-field="qty"]').val();
                    q = (q == '' ? 1 : q);
                    var isi = $row.find('[data-field="uom_id"] > :selected').data('isi');
                    isi = isi ? isi : 1;
                    var t = isi * q * $row.find('input[data-field="price"]').val();
                    $row.find('span.total-price').text(biz.format(t));
                    $row.find('input[data-field="total_price"]').val(t);
                    total += t;
                });
                $('#sales-value').val(total);
                $('#total-price').text(biz.format(total));
            },
            showDiscount: function() {
                var sales_val = $('#sales-value').val();
                var disc_val = $('#item-discount').val();
                if (disc_val * 1 != 0) {
                    $('#bfore').show();
                    var disc_val = sales_val * disc_val * 0.01;
                    $('#sales-val').text(biz.format(sales_val));
                    $('#disc-val').text(biz.format(disc_val));
                    $('#total-price').text(biz.format(sales_val - disc_val));
                } else {
                    $('#total-price').text(biz.format(sales_val));
                    $('#bfore').hide();
                }
            },
            onProductChange: function() {
                var item = biz.master.searchProductByCode(this.value);
                if (item !== false) {
                    local.addItem(item);
                }
                this.value = '';
                $(this).autocomplete("close");
            },
        }
        var pub = {
            onReady: function() {
                $('#detail-grid')
                    .off('keydown.sales', ':input[data-field]')
                    .on('keydown.sales', ':input[data-field]', function(e) {
                        if (e.keyCode == 13) {
                            var $this = $(this);
                            var $inputs = $this.closest('tr').find(':input:visible[data-field]');
                            var idx = $inputs.index(this);
                            if (idx >= 0) {
                                if (idx < $inputs.length - 1) {
                                    $inputs.eq(idx + 1).focus();
                                } else {
                                    $('#product').focus();
                                }
                            }
                        }
                    });
                    
                var clicked = false;
                $('#detail-grid')
                    .off('click.sales, focus.sales', 'input[data-field]')
                    .on('click.sales, focus.sales', 'input[data-field]', function(e) {
                        if (e.type == 'click') {
                            clicked = true;
                        } else {
                            if (!clicked) {
                                $(this).select();
                            }
                            clicked = false;
                        }
                    });

                $('#product').change(local.onProductChange);
                $('#product').focus();
                $('#product').data('ui-autocomplete')._renderItem = biz.global.renderItem;
                
                $('#detail-grid').on('change','[data-field]',function(){
                    local.normalizeItem();
                });
                
                local.showDiscount();
                $('#item-discount').change(local.showDiscount);

                $(window).keydown(function(event) {
                    if (event.keyCode == 13) {
                        var $target = $(event.target);
                        if ($target.is('#product') || $target.is('#saleshdr-item_discount')) {
                            $target.change();
                        } else {
                            event.preventDefault();
                        }
                        return false;
                    }
                });

                // inisialisasi uom
                $.each($('#detail-grid').mdmTabularInput('getAllRows'), function() {
                    var $row = $(this);
                    var product = biz.master.products[$row.find('[data-field="product_id"]').val()];
                    if (product) {
                        local.applyProduct($row, product, $row.find('[data-field="sel_uom_id"]').val());
                    }
                });

                $('#detail-grid').mdmNumericInput('input[data-field]');
                local.normalizeItem();
            },
            onProductSelect: function(event, ui) {
                local.addItem(ui.item);
            }
        };
        return pub;
    })(window.jQuery);
</script>