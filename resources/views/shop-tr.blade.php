@if(sizeof($shopProducts)>0)
    @foreach($shopProducts as &$shopProduct)
        <tr style="cursor: pointer;" data-id="{{$shopProduct->id}}" data-name="{{$shopProduct->name}}" data-price="{{$shopProduct->price}}" class="shop-item">
            <td style="width: 20%">{{$shopProduct->code}}</td>
            <td style="width: 60%">{{$shopProduct->name}}</td>
            <td style="width: 20%">{{$shopProduct->price}} ₸</td>
        </tr>
    @endforeach
@else
    <tr>
        <td style="width: 100%" colspan="3">Ничего не найдено</td>
    </tr>
@endif
