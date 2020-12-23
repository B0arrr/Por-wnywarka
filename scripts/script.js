$(document).ready(function(){

	let page = 1;
	let category = '';
	let producent = '';
	let shop = '';

    load_data(page, category, producent, shop);

    function load_data(page, category, producent, shop)
    {
      $.ajax({
        url:"printing.php",
        method:"GET",
        data:{'page':page,'category':category, 'producent':producent, 'shop':shop},
        success:function(data) {
          $('#Products').html(data);
          $(document).scrollTop(0);
        }
      });
    }

    $(document).on('click', '.page-link', function(){
      var page = $(this).data('page_number');
      load_data(page, category, producent, shop);
    });

	$(document).on('change', '#categories', function(){
		category = $(this).val();
		load_data(1, category, producent, shop);
	});

	$(document).on('change', '#producents', function(){
		producent = $(this).val();
		load_data(1, category, producent, shop);
	});

	$(document).on('change', '#shops', function(){
		shop = $(this).val();
		load_data(1, category, producent, shop);
	});

    $(document).on('click', '#search-box', function(){
        shop = $(this).val();
        load_data(1, category, producent, shop);
    });
});