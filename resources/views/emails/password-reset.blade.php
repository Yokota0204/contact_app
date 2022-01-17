<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      .contents {
        background-color: #eee;
        height: 100%;
        width: 100%;
        padding: 100px 0;
        margin: 0 auto;
      }
      .contents .title {
        text-align: center;
        width: 100%;
        margin-bottom: 30px;
      }
      .contents .text {
        padding: 30px;
        width: 50%;
        margin: 0 auto;
        background-color: #fff;
      }
      .contents .text .btn {
        display: block;
        width: 230px;
        margin: 30px auto;
        padding: 15px 20px;
        background-color: #000;
        color: #fff;
        text-align: center;
        font-weight: bold;
        border-radius: 10px;
        text-decoration: none;
      }
      .contents .text .signature {
        width: 100%;
        text-align: right;
      }
      .contents .copy-right {
        width: 100%;
        margin-top: 30px;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <div class="contents">
      <h2 class="title">{{ __('passwords.reset_mail.app_title') }}</h2>
      <div class="text text-secondary">
        <p>{{ __('passwords.reset_mail.line1') }}</p>
        <a class="btn btn-primary" href="{{ $url }}">{{ __('passwords.reset_mail.action') }}</a>
        <p>{{ __('passwords.reset_mail.line2') }}</p>
        <p>{{ __('passwords.reset_mail.line3', ['count' => $count]) }}</p>
        <p>{{ __('passwords.reset_mail.line4') }}</p>
        <p class="signature">{{ __('passwords.reset_mail.app_title') }}</p>
      </div>
      <div class="copy-right my-2 text-secondary">{{ __('passwords.reset_mail.copyright') }}</div>
    </div>
  </body>
</html>