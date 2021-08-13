@push('after_scripts')   

  <script>
    jQuery(document).ready(function($) {

      function calculateTotals() {
        console.log("entrooo");
        var jsonsContainer = jQuery('body div[data-repeatable-holder="headings"] .array-json');
        var subtotal = 0;
        var iva = 0;
        var total = 0;

        jsonsContainer.each(function(){
          var data = jQuery.parseJSON(jQuery(this).val());
          jQuery.each(data, function(){
            let qty = parseFloat(this.qty);
            let price = parseFloat(this.price);
            console.log(price);
            if (qty && price ) {
              subtotal = subtotal + (qty * price);
            }

          });
        });

        iva = subtotal * 0.22;
        total = subtotal + iva;
        jQuery('input[name="subtotal"]').val(subtotal);
        jQuery('input[name="iva"]').val(iva);
        jQuery('input[name="total"]').val(total);
       
      }

      console.log(jQuery('div[data-repeatable-identifier="headings"] .removeItem'));
      jQuery(document).on('remove', 'div[data-repeatable-identifier="headings"] .array-row',function(){
        calculateTotals();
      })
   
    });
  </script>
@endpush