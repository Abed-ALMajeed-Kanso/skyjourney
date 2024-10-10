<!-- resources/views/create_user.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <!-- You can include Bootstrap CSS or any other CSS framework here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h1 class="mt-5">Create User</h1>

    <form action="{{ url('/users') }}" method="POST" class="mt-3">
        @csrf <!-- CSRF token for protection -->
        
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>
        
        <div class="form-group">
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm your password" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>

<!-- You can include Bootstrap JS or any other JavaScript libraries here -->
</body>
</html>
