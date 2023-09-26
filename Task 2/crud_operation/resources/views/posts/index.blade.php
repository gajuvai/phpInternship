<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <title>Document</title>
</head>
<body>
   <div class="container">
    <div class="col-6 pt-4">
        <div>
            <h1>Post List</h1>
            <a href="{{ route('post.create') }}" class="btn btn-primary">Add Post</a>
        </div>
        <div class="pt-5">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Content</th>
                    <th scope="col">Published At</th>
                    <th scope="col">Author</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach($posts as $post)
                        <tr>
                            <th>{{$post->id}}</th>
                            <td>{{$post->title}}</td>
                            <td>{{$post->content}}</td>
                            <td>{{$post->publish_at}}</td>
                            <td>{{$post->author}}</td>
                        </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
   </div>

   <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
   </script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"></script>
   <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
   
</body>
</html>