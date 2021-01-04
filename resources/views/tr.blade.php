@if($id)
    <tr id="target-{{$id}}">
        <th scope="row">{{$sku}}</th>
        <td>{{$name}}</td>
        <td>{{$nomenclature}}</td>
        <td>{{$provider}}</td>
        <td class="text-center">
            <div class="bg-dark text-white">{{$price}}</div>
            <div class="bg-info">{{$eClub}}</div>
        </td>
        <td class="target-product" data-id="{{$id}}" data-toggle="modal" data-target="#exampleModalLong">{{$alternativePrice}}</td>
        <td>{{$difference}}</td>
        <td><button class="btn btn-success btn-sm editProduct" data-id="{{$id}}" data-toggle="modal" data-target="#edit_good" style="font-size: inherit;">Редактировать</button></td>
        <td><button class="btn btn-danger btn-sm removePrice" data-id="{{$id}}" style="font-size: inherit;">Сбросить</button></td>
    </tr>
@endif
