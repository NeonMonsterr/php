<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
  <div class="container">
    <form action="{{route('authors.update')}}" method="POST">
      @csrf
        <div class="form-group">
            <label for="name">name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter name">
          </div>
        <div class="form-group">
          <label for="email">Email address</label>
          <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email">
        </div>
        <div class="form-group">
          <label for="BookCount">Book count</label>
          <input type="number" class="form-control" name="book_count" id="BookCount" placeholder="Enter book count" required min="0">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
  </div>  
</body>
</html>