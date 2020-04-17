<body>
<form method="post">
    search term:<input type="text" name="searchText" value="{{$searchText}}"/>
    <input type="submit" name="button" value="Find me" />
    
    
</form>


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



</body>