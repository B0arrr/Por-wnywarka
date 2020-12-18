$(document).ready(function(){

    load_data(1);

    function load_data(page)
    {
      $.ajax({
        url:"printing.php",
        method:"GET",
        data:{page:page},
        success:function(data)
        {
          $('#Products').html(data);
        }
      });
    }

    $(document).on('click', '.page-link', function(){
      var page = $(this).data('page_number');
      load_data(page);
    });
  });