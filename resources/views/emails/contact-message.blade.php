<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New website contact message</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111827; line-height: 1.6;">
    <h2>New website contact message</h2>
    <p><strong>Name:</strong> {{ $contactMessage['name'] }}</p>
    <p><strong>Email:</strong> <a href="mailto:{{ $contactMessage['email'] }}">{{ $contactMessage['email'] }}</a></p>
    <p><strong>Subject:</strong> {{ $contactMessage['subject'] }}</p>
    <hr>
    <p style="white-space: pre-wrap;">{{ $contactMessage['message'] }}</p>
</body>
</html>
