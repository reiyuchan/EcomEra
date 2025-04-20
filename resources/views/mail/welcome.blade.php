<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ config('app.name') }}!</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            padding: 20px 0;
        }

        .logo {
            max-width: 200px;
            height: auto;
        }

        .main-image {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 8px;
            margin: 15px 0;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white !important;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin: 15px 0;
        }

        .social-icons {
            text-align: center;
            margin: 20px 0;
        }

        .social-icon {
            margin: 0 10px;
            text-decoration: none;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777777;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
        }

        .unsubscribe {
            font-size: 11px;
            color: #999999;
            text-align: center;
            margin-top: 30px;
        }

        .unsubscribe a {
            color: #999999;
        }

        .highlight-box {
            background-color: #f8f8f8;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <!-- Replace with your logo -->
        <img src="{{ asset('/images/logo.jpg') }}" alt="{{ config('app.name') }}" class="logo">
    </div>

    <!-- Main welcome image -->
    <img src="{{ asset('/images/welcome.jpg') }}" alt="Welcome to our store" class="main-image">

    <h1 style="text-align: center;">Welcome to {{ config('app.name') }}!</h1>




    <div class="highlight-box">
        <h3 style="margin-top: 0;">Hi {{ $name }}</h2>
            <p>We're thrilled to have you as part of our community! At {{ config('app.name') }}, we're committed to
                bringing
                you
                the
                best products and shopping experience.</p>
            <p>Thanks for joining us.</p>
            <p style="text-align: center;"><a href={{ config('app.frontend_url') }} target="__blank"
                    class="button">Start Shopping
                    Now</a></p>
    </div>

    <h2>What to Expect:</h2>
    <ul>
        <li>High-quality products at competitive prices</li>
        <li>Fast and reliable shipping</li>
        <li>Exceptional customer service</li>
    </ul>

    <div class="social-icons">
        <p>Follow us on social media:</p>
        <a href="{{ config('app.social_media.facebook') }}" class="social-icon">
            <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/facebook.svg" alt="Facebook" width="30">
        </a>
        <a href="{{ config('app.social_media.instagram') }}" class="social-icon">
            <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/instagram.svg" alt="Instagram" width="30">
        </a>
        <a href="{{ config('app.social_media.tiktok') }}" class="social-icon">
            <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/tiktok.svg" alt="Instagram" width="30">
        </a>
        <a href="{{ config('app.social_media.x') }}" class="social-icon">
            <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/x.svg" alt="Twitter" width="30">
        </a>
    </div>

    <div class="footer">
        <p>{{ config('app.name') }} - [Your Store Tagline]</p>
        <p>[Your Store Address] | [City, State ZIP] | {{ config('mail.contact') }}</p>
        <p>&copy; [Current Year] {{ config('app.name') }}. All rights reserved.</p>
    </div>

    <div class="unsubscribe">
        <p>You received this email because you signed up for an account at {{ config('app.name') }}.</p>
        <p>
            <a href="{{ $unsub_url }}">unsubscribe</a> |
            <a href="[Privacy Policy URL]">Privacy Policy</a>
        </p>
    </div>
</body>

</html>
