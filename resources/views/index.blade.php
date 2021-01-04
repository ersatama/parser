<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Parser') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Optional theme -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function shopSearch(val) {
            let timer;
            clearTimeout(timer);
            if (val === '') {
                return $('#shop-product-body').html('');
            }
            timer       =   setTimeout(function()
            {
                clearTimeout(timer);
                $.get('/shop/search/'+val,function(data) {
                    $('#shop-product-body').html(data);
                });
            },500);
        }
    </script>
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">

    <!-- Page Heading -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div style="overflow: hidden;">
                <div class="btn float-left">Europharma - Детский мир</div>
                <a href="/logout"><button class="btn btn-dark float-right">Выйти</button></a>
            </div>
        </div>
    </header>
    <main>
        <div class="container mt-3 mb-3 d-flex justify-content-center">
            @php
            use App\Contracts\ProductContract;
            $cities     =   [
                ProductContract::PRICE_ALMATY       =>  'Алматы',
                ProductContract::PRICE_NURSULTAN    =>  'Нур Султан',
                ProductContract::PRICE_SHYMKENT     =>  'Шымкент',
                ProductContract::PRICE_KARAGANDA    =>  'Караганда',
                ProductContract::PRICE_USKAMAN      =>  'Усть-Каменогорск',
            ];
            $city       =   $cities[ProductContract::PRICE_ALMATY];
            $cityUrl    =   $cities[ProductContract::PRICE_ALMATY];
            $request    =   app('request')->input('city');
            if (array_key_exists($request,$cities)) {
                $city       =   $cities[$request];
                $cityUrl    =   $request;
            }
            @endphp
            <div class="btn-group" role="group" aria-label="Basic example">
                @foreach($cities as $key=>$value)
                    <a href="/dashboard?city={{$key}}" type="button" class="btn btn-secondary btn-info {{$city===$value?'disabled':''}}">{{$value}}</a>
                @endforeach
            </div>
            <div class="btn-group ml-3" role="group" aria-label="Basic example">
                <button class="btn btn-dark btn-sm" data-toggle="modal" data-target="#add_good">Добавить товар</button>
            </div>
            <div class="btn-group ml-3" role="group" aria-label="Basic example">
                <a href="/export?city={{$cityUrl}}" download class="btn btn-success btn-sm">
                    <div class="mt-1">Скачать в Excel</div>
                </a>
            </div>
        </div>
    </main>
    <!-- Page Content -->
    <script>
        function filter()
        {
            let timer;
            clearTimeout(timer);
            timer   =   setTimeout(function() {
                let code                =   $('.search-code').val().trim();
                let code_status         =   true;
                if (code === '')
                {
                    code_status         =   false;
                }
                let name                =   $('.search-name').val().trim();
                let name_status         =   true;
                if (name === '-')
                {
                    name_status         =   false;
                }
                let nomenclature        =   $('.search-nomenclature').val().trim();
                let nomenclature_status =   true;
                if (nomenclature === '')
                {
                    nomenclature_status =   false;
                }
                let provider        =   $('.search-provider').val().trim();
                let provider_status =   true;
                if (provider === '-')
                {
                    provider_status =   false;
                }
                let list            =   $('#product-list > tr');
                if (!code_status && !name_status && !nomenclature_status && !provider_status)
                {
                    return $('#product-list > tr').fadeIn(0);
                }
                for (let i=0;i<list.length;i++)
                {

                    let item        =   list.eq(i);
                    let item_code   =   parseInt(item.find('th').html().trim());
                    if (code_status && (parseInt(code) !== item_code))
                    {
                        list.eq(i).fadeOut(0);
                        continue;
                    }
                    let item_name   =   item.find('td').eq(0).html().trim();
                    let re          =   new RegExp(name ,'gi');
                    if (name_status && (!re.test(item_name)))
                    {
                        list.eq(i).fadeOut(0);
                        continue;
                    }
                    let item_nomenclature   =   item.find('td').eq(1).html().trim();
                    re                      =   new RegExp(nomenclature ,'gi');
                    if (nomenclature_status && (!re.test(item_nomenclature)))
                    {
                        list.eq(i).fadeOut(0);
                        continue;
                    }

                    let item_provider       =   item.find('td').eq(2).html().trim();
                    re                      =   new RegExp(provider ,'gi');
                    if (provider_status && (!re.test(item_provider)))
                    {
                        list.eq(i).fadeOut(0);
                        continue;
                    }
                    list.eq(i).fadeIn(0);
                }
            },1000);
        }
    </script>
    <main>
        <div class="container">
            <table class="table table-bordered table-striped bg-white text-xsmall" style="font-size: 10px;">
                <thead class="bg-dark text-white">
                    <tr>
                        <th scope="col" style="width: 6%">
                            <input class="form-control font-weight-bold form-control-sm border-0 rounded-0 p-2 search-code" type="text" placeholder="Код" style="font-size: 10px;" oninput="filter()">
                        </th>
                        <th scope="col" style="width: 10%">
                            <select class="form-control font-weight-bold form-control-sm border-0 rounded-0 bg-dark text-white search-name" style="font-size: 10px;" onchange="filter()">
                                <option value="-">Имя</option>
                                @foreach($name as &$item)
                                    @if (trim($item)!=='')
                                        <option value="{{$item}}">{{$item}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </th>
                        <th scope="col" style="width: 30%">
                            <input class="form-control font-weight-bold form-control-sm border-0 rounded-0 p-2 search-nomenclature" type="text" placeholder="Номенклатура" style="font-size: 10px;" oninput="filter()">
                        </th>
                        <th scope="col" style="width: 8%">
                            <select class="form-control font-weight-bold form-control-sm border-0 rounded-0 bg-dark search-provider text-white" style="font-size: 10px;" onchange="filter()">
                                <option value="-">Поставщик</option>
                                @foreach($provider as &$item)
                                    @if (trim($item)!=='')
                                        <option value="{{$item}}">{{$item}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </th>
                        <th scope="col">
                            <input class="form-control font-weight-bold form-control-sm border-0 rounded-0 p-2 bg-dark text-white" type="text" value="EuroPharma" readonly style="font-size: 10px;">
                        </th>
                        <th scope="col">
                            <input class="form-control font-weight-bold form-control-sm border-0 rounded-0 p-2 bg-dark text-white" type="text" value="Детский мир" readonly style="font-size: 10px;">
                        </th>
                        <th scope="col">
                            <input class="form-control font-weight-bold form-control-sm border-0 rounded-0 p-2 bg-dark text-white" type="text" value="Разница" readonly style="font-size: 10px;">
                        </th>
                        <th scope="col" colspan="2">
                            <input class="form-control font-weight-bold form-control-sm border-0 rounded-0 p-2 bg-dark text-white" type="text" value="Управление" readonly style="font-size: 10px;">
                        </th>
                    </tr>
                </thead>
                <tbody id="product-list">
                @foreach($products as $product)
                    @include('tr',[
                        ProductContract::ID                 =>  $product[ProductContract::ID],
                        ProductContract::SKU                =>  $product[ProductContract::SKU],
                        ProductContract::NAME               =>  $product[ProductContract::NAME],
                        ProductContract::NOMENCLATURE       =>  $product[ProductContract::NOMENCLATURE],
                        ProductContract::PROVIDER           =>  $product[ProductContract::PROVIDER],
                        ProductContract::PRICE              =>  $product[ProductContract::PRICE],
                        ProductContract::E_CLUB             =>  $product[ProductContract::E_CLUB],
                        ProductContract::ALTERNATIVE_PRICE  =>  $product[ProductContract::ALTERNATIVE_PRICE],
                        ProductContract::DIFFERENCE         =>  $product[ProductContract::DIFFERENCE],
                    ])
                @endforeach
                </tbody>
            </table>
        </div>
    </main>
</div>
<div class="modal fade" id="edit_good" tabindex="-1" role="dialog" aria-labelledby="edit_good_title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" style="font-size: 16px;" id="edit_good_title">Редактирование товара</h5>
                <button type="button" class="close edit_good-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body edit_good_body" data-id="">
                <div class="form-group row mx-0 font-weight-bold">
                    <label class="col-sm-4 col-form-label px-0" style="font-size: 10px;">Код товара</label>
                    <input type="text" class="form-control col-sm-8 edit_good_sku rounded-0" style="font-size: 10px;" required readonly>
                </div>
                <hr>
                <div class="form-group row mx-0 font-weight-bold">
                    <label class="col-sm-4 col-form-label px-0" style="font-size: 10px;">Производитель</label>
                    <input type="text" class="form-control col-sm-8 edit_good_product_name rounded-0 bg-light" style="font-size: 10px;" required>
                </div>
                <div class="form-group row mx-0 font-weight-bold">
                    <label class="col-sm-4 col-form-label px-0" style="font-size: 10px;">Номенклатура</label>
                    <textarea class="form-control col-sm-8 edit_good_nomenclature rounded-0 bg-light" style="font-size: 10px;" rows="3"></textarea>
                </div>
                <div class="form-group row mx-0 font-weight-bold">
                    <label class="col-sm-4 col-form-label px-0" style="font-size: 10px;">Поставщик</label>
                    <input type="text" class="form-control col-sm-8 edit_good_provider rounded-0 bg-light" style="font-size: 10px;" required>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Алматы</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 edit_good_price_almaty bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 edit_good_price_almaty_eclub bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Нурсултан</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 edit_good_price_nursultan bg-light rounded-0" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 edit_good_price_nursultan_eclub bg-light rounded-0" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Актобе</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 edit_good_price_aktobe bg-light rounded-0" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 edit_good_price_aktobe_eclub bg-light rounded-0" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Ускаман</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 edit_good_price_uskaman rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 edit_good_price_uskaman_eclub rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Шымкент</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 edit_good_price_shymkent rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 edit_good_price_shymkent_eclub rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Караганда</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 edit_good_price_karaganda rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 edit_good_price_karaganda_eclub rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Кызыл Орда</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 edit_good_price_kyzylorda rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 edit_good_price_kyzylorda_eclub rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Уральск</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 edit_good_price_uralsk rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 edit_good_price_uralsk_eclub rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Талдыкорган</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 edit_good_price_taldykorgan rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 edit_good_price_taldykorgan_eclub rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Актау</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 edit_good_price_aktau rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 edit_good_price_aktau_eclub rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Тараз</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 edit_good_price_taraz rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 edit_good_price_taraz_eclub rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Семей</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 edit_good_price_semey rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 edit_good_price_semey_eclub rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Туркестан</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 edit_good_price_turkestan rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 edit_good_price_turkestan_eclub rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-success w-100 edit_good_ready_product font-weight-bold" style="font-size: 10px;">Сохранить</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', ".deleteProduct" , function() {
        let id  =   $(this).attr('data-id');
        $("#target-"+id).remove();
        $.get('/product_delete/'+id)
    });
    $(document).on('click', ".editProduct" , function() {
        let id  =   $(this).attr('data-id');
        $.get('/product/id/'+id, function(data) {
            let info    =   data;
            if (info)
            {
                $(".edit_good_body").attr('data-id',info.id);
                $(".edit_good_sku").val(info.sku);
                $(".edit_good_product_name").val(info.name);
                $(".edit_good_nomenclature").val(info.nomenclature);
                $(".edit_good_provider").val(info.provider);
                $(".edit_good_price_almaty").val(info.price_almaty);
                $(".edit_good_price_nursultan").val(info.price_nursultan);
                $(".edit_good_price_aktobe").val(info.price_aktobe);
                $(".edit_good_price_uskaman").val(info.price_uskaman);
                $(".edit_good_price_shymkent").val(info.price_shymkent);
                $(".edit_good_price_karaganda").val(info.price_karaganda);
                $(".edit_good_price_kyzylorda").val(info.price_kyzylorda);
                $(".edit_good_price_uralsk").val(info.price_uralsk);
                $(".edit_good_price_taldykorgan").val(info.price_taldykorgan);
                $(".edit_good_price_aktau").val(info.price_aktau);
                $(".edit_good_price_taraz").val(info.price_taraz);
                $(".edit_good_price_semey").val(info.price_semey);
                $(".edit_good_price_turkestan").val(info.price_turkestan);
                $(".edit_good_price_almaty_eclub").val(info.price_almaty_eclub);
                $(".edit_good_price_nursultan_eclub").val(info.price_nursultan_eclub);
                $(".edit_good_price_aktobe_eclub").val(info.price_aktobe_eclub);
                $(".edit_good_price_uskaman_eclub").val(info.price_uskaman_eclub);
                $(".edit_good_price_shymkent_eclub").val(info.price_shymkent_eclub);
                $(".edit_good_price_karaganda_eclub").val(info.price_karaganda_eclub);
                $(".edit_good_price_kyzylorda_eclub").val(info.price_kyzylorda_eclub);
                $(".edit_good_price_uralsk_eclub").val(info.price_uralsk_eclub);
                $(".edit_good_price_taldykorgan_eclub").val(info.price_taldykorgan_eclub);
                $(".edit_good_price_aktau_eclub").val(info.price_aktau_eclub);
                $(".edit_good_price_taraz_eclub").val(info.price_taraz_eclub);
                $(".edit_good_price_semey_eclub").val(info.price_semey_eclub);
                $(".edit_good_price_turkestan_eclub").val(info.price_turkestan_eclub);
            }
        })
    });
    $(document).on('click', ".edit_good_ready_product" , function() {
        let id                  =   $(".edit_good_body").attr('data-id');
        let name                =   $(".edit_good_product_name").val().trim();
        let nomenclature        =   $(".edit_good_nomenclature").val().trim();
        let provider            =   $(".edit_good_provider").val().trim();
        let almaty              =   $(".edit_good_price_almaty").val().trim();
        let nursultan           =   $(".edit_good_price_nursultan").val().trim();
        let aktobe              =   $(".edit_good_price_aktobe").val().trim();
        let uskaman             =   $(".edit_good_price_uskaman").val().trim();
        let shymkent            =   $(".edit_good_price_shymkent").val().trim();
        let karaganda           =   $(".edit_good_price_karaganda").val().trim();
        let kyzylorda           =   $(".edit_good_price_kyzylorda").val().trim();
        let uralsk              =   $(".edit_good_price_uralsk").val().trim();
        let taldykorgan         =   $(".edit_good_price_taldykorgan").val().trim();
        let aktau               =   $(".edit_good_price_aktau").val().trim();
        let taraz               =   $(".edit_good_price_taraz").val().trim();
        let semey               =   $(".edit_good_price_semey").val().trim();
        let turkestan           =   $(".edit_good_price_turkestan").val().trim();
        let almaty_eclub        =   $(".edit_good_price_almaty_eclub").val().trim();
        let nursultan_eclub     =   $(".edit_good_price_nursultan_eclub").val().trim();
        let aktobe_eclub        =   $(".edit_good_price_aktobe_eclub").val().trim();
        let uskaman_eclub       =   $(".edit_good_price_uskaman_eclub").val().trim();
        let shymkent_eclub      =   $(".edit_good_price_shymkent_eclub").val().trim();
        let karaganda_eclub     =   $(".edit_good_price_karaganda_eclub").val().trim();
        let kyzylorda_eclub     =   $(".edit_good_price_kyzylorda_eclub").val().trim();
        let uralsk_eclub        =   $(".edit_good_price_uralsk_eclub").val().trim();
        let taldykorgan_eclub   =   $(".edit_good_price_taldykorgan_eclub").val().trim();
        let aktau_eclub         =   $(".edit_good_price_aktau_eclub").val().trim();
        let taraz_eclub         =   $(".edit_good_price_taraz_eclub").val().trim();
        let semey_eclub         =   $(".edit_good_price_semey_eclub").val().trim();
        let turkestan_eclub     =   $(".edit_good_price_turkestan_eclub").val().trim();
        let info        =   {
            id: id,
            name: name,
            nomenclature: nomenclature,
            provider: provider,
            price_almaty: almaty,
            price_nursultan: nursultan,
            price_aktobe: aktobe,
            price_uskaman: uskaman,
            price_shymkent: shymkent,
            price_karaganda: karaganda,
            price_kyzylorda: kyzylorda,
            price_uralsk: uralsk,
            price_taldykorgan: taldykorgan,
            price_aktau: aktau,
            price_taraz: taraz,
            price_semey: semey,
            price_turkestan: turkestan,
            price_almaty_eclub: almaty_eclub,
            price_nursultan_eclub: nursultan_eclub,
            price_aktobe_eclub: aktobe_eclub,
            price_uskaman_eclub: uskaman_eclub,
            price_shymkent_eclub: shymkent_eclub,
            price_karaganda_eclub: karaganda_eclub,
            price_kyzylorda_eclub: kyzylorda_eclub,
            price_uralsk_eclub: uralsk_eclub,
            price_taldykorgan_eclub: taldykorgan_eclub,
            price_aktau_eclub: aktau_eclub,
            price_taraz_eclub: taraz_eclub,
            price_semey_eclub: semey_eclub,
            price_turkestan_eclub: turkestan_eclub,
        };
        $(".edit_good-close").click();
        $.post('/update',info,function(data) {
            $("#target-"+id).replaceWith(data);
        });
    })
</script>
<div class="modal fade" id="add_good" tabindex="-1" role="dialog" aria-labelledby="add_good_title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_good_title" style="font-size: 16px;">Добавить товар</h5>
                <button type="button" class="close good-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" data-id="">
                <div class="form-group row mx-0 font-weight-bold">
                    <label class="col-sm-4 col-form-label px-0" style="font-size: 10px;">Код товара</label>
                    <input type="text" class="form-control col-sm-8 sku bg-light rounded-0" style="font-size: 10px;">
                </div>
                <hr>
                <div class="form-group row mx-0 font-weight-bold">
                    <label class="col-sm-4 col-form-label px-0" style="font-size: 10px;">Производитель</label>
                    <input type="text" class="form-control col-sm-8 product_name bg-light rounded-0" style="font-size: 10px;">
                </div>
                <div class="form-group row mx-0 font-weight-bold">
                    <label class="col-sm-4 col-form-label px-0" style="font-size: 10px;">Номенклатура</label>
                    <textarea class="form-control col-sm-8 product_nomenclature rounded-0 bg-light" style="font-size: 10px;" rows="3" ></textarea>
                </div>
                <div class="form-group row mx-0 font-weight-bold">
                    <label class="col-sm-4 col-form-label px-0" style="font-size: 10px;">Поставщик</label>
                    <input type="text" class="form-control col-sm-8 product_provider bg-light rounded-0" style="font-size: 10px;" required>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Алматы</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 price_almaty bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 price_almaty_eclub bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Нурсултан</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 price_nursultan bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 price_nursultan_eclub bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Актобе</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 price_aktobe bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 price_aktobe_eclub bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Ускаман</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 price_uskaman bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 price_uskaman_eclub bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Шымкент</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 price_shymkent bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 price_shymkent_eclub bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Караганда</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 price_karaganda bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 price_karaganda_eclub bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Кызыл Орда</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 price_kyzylorda bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 price_kyzylorda_eclub bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Уральск</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 price_uralsk bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 price_uralsk_eclub bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Талдыкорган</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 price_taldykorgan bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 price_taldykorgan_eclub bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Актау</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 price_aktau bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 price_aktau_eclub bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Тараз</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 price_taraz bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 price_taraz_eclub bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Семей</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 price_semey bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 price_semey_eclub bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 font-weight-bold" style="font-size: 10px;">Туркестан</div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена" class="form-control col-sm-12 price_turkestan bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row mx-0 font-weight-bold">
                            <input type="text" placeholder="Цена eclub" class="form-control col-sm-12 price_turkestan_eclub bg-light rounded-0 bg-light" style="font-size: 10px;">
                        </div>
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-success w-100 ready_product btn-sm">Сохранить</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', ".ready_product" , function() {
        let sku                 =   $('.sku').val().trim();
        let name                =   $('.product_name').val().trim();
        let nomenclature        =   $('.product_nomenclature').val().trim();
        let provider            =   $('.product_provider').val().trim();
        let almaty              =   $('.price_almaty').val().trim();
        let nursultan           =   $('.price_nursultan').val().trim();
        let aktobe              =   $('.price_aktobe').val().trim();
        let uskaman             =   $('.price_uskaman').val().trim();
        let taldykorgan         =   $('.price_taldykorgan').val().trim();
        let aktau               =   $('.price_aktau').val().trim();
        let taraz               =   $('.price_taraz').val().trim();
        let semey               =   $('.price_semey').val().trim();
        let turkestan           =   $('.price_turkestan').val().trim();
        let almaty_eclub        =   $('.price_almaty_eclub').val().trim();
        let nursultan_eclub     =   $('.price_nursultan_eclub').val().trim();
        let aktobe_eclub        =   $('.price_aktobe_eclub').val().trim();
        let uskaman_eclub       =   $('.price_uskaman_eclub').val().trim();
        let taldykorgan_eclub   =   $('.price_taldykorgan_eclub').val().trim();
        let aktau_eclub         =   $('.price_aktau_eclub').val().trim();
        let taraz_eclub         =   $('.price_taraz_eclub').val().trim();
        let semey_eclub         =   $('.price_semey_eclub').val().trim();
        let turkestan_eclub     =   $('.price_turkestan_eclub').val().trim();
        let data                =   {
            sku                 :   sku,
            name                :   name,
            nomenclature        :   nomenclature,
            provider            :   provider,
            price_almaty        :   almaty,
            price_nursultan           :   nursultan,
            price_aktobe              :   aktobe,
            price_uskaman             :   uskaman,
            price_taldykorgan         :   taldykorgan,
            price_aktau               :   aktau,
            price_taraz               :   taraz,
            price_semey               :   semey,
            price_turkestan           :   turkestan,
            price_almaty_eclub        :   almaty_eclub,
            price_nursultan_eclub     :   nursultan_eclub,
            price_aktobe_eclub        :   aktobe_eclub,
            price_uskaman_eclub       :   uskaman_eclub,
            price_taldykorgan_eclub   :   taldykorgan_eclub,
            price_aktau_eclub         :   aktau_eclub,
            price_taraz_eclub         :   taraz_eclub,
            price_semey_eclub         :   semey_eclub,
            price_turkestan_eclub     :   turkestan_eclub
        };
        $.post('/store',data,function(data) {
            $('#product-list').prepend(data);
            $(".good-close").click();
        });
    });
</script>
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Детский мир Алматы</h5>
                <button type="button" class="btn btn-success btn-sm mod-save" style="position: absolute;right: 50px;" data-dismiss="modal">
                    <span aria-hidden="true">Сохранить</span>
                </button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body detskiimir-modal" data-id="">
                <table class="table table-bordered table-striped bg-white р6" style="font-size: 10px;">
                    <thead class="bg-light">
                    <style>
                        .table thead th {
                            border-bottom: 1px solid #dee2e6 !important;
                        }
                    </style>
                    <tr>
                        <th scope="col" style="width: 20%">id</th>
                        <th scope="col" style="width: 60%">Название товара</th>
                        <th scope="col" style="width: 20%">Цена</th>
                    </tr>
                    <tr>
                        <th colspan="3">
                            <input type="text" class="form-control shop-search" oninput="shopSearch()" placeholder="Поиск по названию товара" style="font-size: 12px;">
                        </th>
                    </tr>
                    </thead>
                    <tbody id="shop-product-body"></tbody>
                </table>
                <script>
                    function shopSearch() {
                        let timer;
                        let val =   $(".shop-search").val().trim();
                        clearTimeout(timer);
                        if (val === '') {
                            return $('#shop-product-body').html('');
                        }
                        timer   =   setTimeout(function()
                        {
                            clearTimeout(timer);
                            if ($(".shop-search").val().trim() === val) {
                                $.get('/shop/search/'+val,function(data) {
                                    $('#shop-product-body').html(data);
                                });
                            }
                        },500);
                    }
                    $(document).on('click', '.shop-item', function() {
                        let name    =   'selected bg-success text-white';
                        $('.shop-item').removeClass(name);
                        $(this).addClass(name);
                    });
                </script>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Отменить</button>
                <button type="button" class="btn btn-info btn-sm mod-save" data-dismiss="modal">Сохранить</button>
            </div>
            <script>
                $(document).on('click', ".target-product" , function() {
                    let selected    =   $(this).attr('data-id');
                    $(".detskiimir-modal").attr('data-id',selected);
                });
                $(document).on('click', ".mod-save" , function() {
                    let selected    =   $('.selected').attr('data-id');
                    if (selected === undefined) return;
                    let target      =   $('.detskiimir-modal').attr('data-id');
                    $.ajax({
                        url: '/update/'+target+'/'+selected,
                        success: function(data) {
                            $("#target-"+target).replaceWith(data);
                        }
                    });
                });
                $(document).on('click', ".removePrice" , function() {
                    let id  =   $(this).attr('data-id');
                    $.get('/remove/'+id, function(data) {
                        $("#target-"+id).replaceWith(data);
                    });
                });
            </script>
        </div>
    </div>
</div>
</body>
</html>
