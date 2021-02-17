$(document).ready(function(){

    const container = $('.container').html();
	let page = 1;
	let category = '';
	let producent = '';
	let shop = '';
	let name = '';
	let newurl = '';
    let search='';

    preparation();

    function preparation(){
        load_data(get_url(), get_data());
    }

    function get_data(){
        let data;
        if(search !=='')
        {
          data = {'page': page,
              'category': category,
              'producent': producent,
              'shop': shop,
              'search':search,
              'name': name}
        }else {
            name === '' ? data = {
                'page': page,
                'category': category,
                'producent': producent,
                'shop': shop,
                'search': search
            } : data = {'name': name};
        }
        return data;
    }

    function get_url(){
        let url;
        name === '' ? url = 'home/printing.php' : url = 'game/game.php';
        return url;
    }

    function load_data(url, data) {
        newurl = window.location.pathname;
        if(search !=='')
        {
            newurl === window.location.pathname ? newurl += '#szukaj='+search : newurl = window.location.pathname;
        }else {

            if (name === '') {
                if (page !== 1) {
                    newurl === window.location.pathname ? newurl += '#strona=' + page : newurl = window.location.pathname;
                }

                if (category !== '') {
                    newurl === window.location.pathname ? newurl += '#kategoria=' + category : newurl += '&kategoria=' + category;
                }

                if (producent !== '') {
                    newurl === window.location.pathname ? newurl += '#producent=' + producent : newurl += '&producent=' + producent;
                }

                if (shop !== '') {
                    newurl === window.location.pathname ? newurl += '#sklep=' + shop : newurl += '&sklep=' + shop;
                }

            } else {
                newurl += '#gra=' + name;
            }
        }
        $.ajax({
            url:url,
            method:"GET",
            data:data,
            success:function(data) {
                name === '' ? $('#Products').html(data) : $('.container').html(data);
                $(document).scrollTop(0);
            }
        });
        window.history.replaceState({path: newurl}, '', newurl);
    }

    $(document).on('click', '.page-link', function(){
      page = $(this).data('page_number');
      preparation();
    });

	$(document).on('change', '#categories', function(){
		category = $(this).val();
		page = 1;
        preparation();
	});

	$(document).on('change', '#producents', function(){
		producent = $(this).val();
        page = 1;
        preparation();
	});

	$(document).on('change', '#shops', function(){
		shop = $(this).val();
        page = 1;
        preparation();
	});

    $(document).on('click', '#home', function (){
        name = category = producent = shop = '';
        page = 1;
        $('.container').html(container);
        preparation();
    });

    $(document).on('click', '#Goback', function (){
        name = '';
        $('.container').html(container);
        preparation();
    });

    $(document).on('click', '.text-decoration-none', function (){
        name = $(this).find('.card-title').text();
        preparation();
    });

    $(document). on('click', '#loupe', function (){
        $(function (){
            $('#categories option').filter(function() {
                return ($(this).text() === 'Kategoria...');
            }).prop('selected', true);

            $('#producents option').filter(function() {
                return ($(this).text() === 'Producent...');
            }).prop('selected', true);

            $('#shops option').filter(function() {
                return ($(this).text() === 'Sklep...');
            }).prop('selected', true);
        });

        name = category = producent = shop = '';
        page=1;
        search= $('#search_box').val();

        preparation();
    });

    $("#search_box").on("keydown",function search(e) {
        if(e.keyCode === 13) {
            $('#loupe').click();
            console.log("enter");
        }
    });

    $(window).bind('hashchange', function(){
        const href = window.location.href;
        const params = href.split('#')[1];

        if (params && params !== '') {
            const result = params.split('&').reduce(function (res, item) {
                const parts = item.split('=');
                res[parts[0]] = parts[1];
                return res;
            }, {});
            result['strona'] === undefined ? page = 1 : page = result['strona'];
            result['kategoria'] === undefined ? category = '' : category = result['kategoria'];
            result['producent'] === undefined ? producent = '' : producent = result['producent'];
            result['sklep'] === undefined ? shop = '' : shop = result['sklep'];
            result['gra'] === undefined ? name = '' : name = result['gra'];
            result['szukaj'] === undefined ? name = '' : search = result['szukaj'];
            const max_page = $('.page-item').last().prev().text();
            page > max_page ? page = 1 : page;
        }
        preparation();
        if (name === '')
        {
            $(function (){
                if (category !== '') {
                    $('#categories option').filter(function() {
                        return ($(this).text() === category);
                    }).prop('selected', true);
                }
                if (producent !== '') {
                    $('#producents option').filter(function() {
                        return ($(this).text() === producent);
                    }).prop('selected', true);
                }
                if (shop !== ''){
                    $('#shops option').filter(function() {
                        return ($(this).text() === shop);
                    }).prop('selected', true);
                }
            });
        }
    });
});