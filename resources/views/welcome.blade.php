<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tagalog-English Translator</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <link rel="stylesheet" href="/style.css">
</head>

<body>

    <div id="chat-container" class="chat" data-profile-image-url="{{ asset('images/profile-image.png') }}">
        <div class="top">
            <div>
                <p>Tagalog-English Translator</p>
                <small>Online</small>
            </div>
        </div>


        <div class="messages">
            <div class="left message">
                <img src="{{ asset('images/profile-image.png') }}" alt="profile-image">
                <p>I-type ang mga salita sa ibaba!!</p>
            </div>
        </div>

        <div class="bottom">
            <form>
                <input type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">
                <button type="submit"></button>
            </form>
        </div>
    </div>


    <script src="{{ asset('custom.js') }}"></script>
</body>


</html>