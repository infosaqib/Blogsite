@includeif('common.header', ['page' => 'Products'])
<div">
    <table border="true">
        <tr>
            <th>id</th>
            <th>Title</th>
            <th>Category</th>
            <th>Price</th>
        </tr>
        @isset($products)
            @foreach ($products as $product)
                <tr>
                    <td>{{$product['id']}}</td>
                    <td>{{$product['title']}}</td>
                    <td>{{$product['category']}}</td>
                    <td>{{$product['price']}}</td>
            @endforeach
        @endisset
    </table>
    </div>