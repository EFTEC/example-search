<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
<div class="container">
    <h1>Example of Search</h1>
<form method="post" class="form-inline">
    Search term:<input class="form-control" type="text" name="searchText" value="{{$searchText}}"/>
    &nbsp;&nbsp;&nbsp;
    <input type="submit" name="button" class="btn btn-primary" value="Find me" />
    
    
</form>

@if($count===0)
    <h5>No value</h5>
@else
    <h5>Rows {{$count}}</h5>
    <table class="table">
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

</div>
</body>