<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contact Us Message</title>
</head>
<body>
    <p>You have received a new message from the Contact Us form:</p>
    
    <p><strong>Name:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Mobile:</strong> {{ $data['mobile'] }}</p>
    <p><strong>Message:</strong></p>
    <p>{{ $data['message'] }}</p>
</body>
</html>