<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload berita</title>
</head>
<body>
    <h1>Upload Berita</h1>
    <form action="{{ url('api/berita/store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <input type="date" name="update" placeholder="Update" required>
        <input type="text" name="title" placeholder="Title" required>
        <input type="text" name="description" placeholder="description" required>
        <input type="text" name="infotitle" placeholder="Info Title" required>
        <input type="file" name="imageurl"><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
