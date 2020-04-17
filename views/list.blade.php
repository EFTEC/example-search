<body>
<form method="post">
    search term:<input type="text" name="searchText" value="{{$searchText}}"/>
    <input type="submit" name="button" value="Find me" />
    
    
</form>

@if($count===0)
    <h5>No value</h5>
@else
    <h5>Rows {{$count}}</h5>
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>name</th>
            </tr>
        </thead>
        <tbody>
        @foreach($result as $item)
            <tr>
                <td>{{$item['idProduct']}}</td>
                <td>{{$item['name']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif


</body>