<table class="x_wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation"
       style="box-sizing: border-box; background-color: #fff; margin: 0; padding: 0; width: 100%;">
    <tbody>
    <tr>
        <td align="center" style="box-sizing:border-box">
            <table class="x_content" width="100%" cellpadding="0" cellspacing="0" role="presentation"
                   style="box-sizing:border-box; margin:0; padding:0; width:100%">
                <tbody>
                <tr>
                    <td class="x_header" style="box-sizing:border-box; padding:25px 0; text-align:center">
                        <a href="{{ url('/') }}"
                           target="_blank"
                           style="box-sizing:border-box; color:#3d4852; font-size:19px; font-weight:bold; text-decoration:none; display:inline-block">
                            <img class="x_logo" src="{{ asset('img/logo.png') }}" alt="Performance Pickleball"
                                 style="box-sizing:border-box; max-width:100%; border:none; height:120px; max-height:120px; width:120px;">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="x_body" width="100%" cellpadding="0" cellspacing="0"
                        style="box-sizing:border-box; background-color:#fff; border-bottom:1px solid #edf2f7; border-top:1px solid #edf2f7; margin:0; padding:0; width:100%; border:hidden!important">
                        <table class="x_inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation"
                               style="box-sizing:border-box; background-color:#ffffff; border-color:#e8e5ef; border-radius:2px; border-width:1px; box-shadow:0 0.125rem 1rem 1px rgba(0,0,0,.075); margin:0 auto; padding:0; width:570px">
                            <tbody>
                            <tr>
                                <td class="x_content-cell" style="box-sizing:border-box; max-width:100vw; padding:32px">
                                    <h1 style="box-sizing:border-box; color:#1a2755; font-size:22px; font-weight:bold; margin-top:0; text-align:left">
                                        Hi {{ $name }},
                                    </h1>
                                    <p style="box-sizing:border-box; font-size:16px; line-height:1.5em; margin-top:0; margin-bottom:24px; text-align:left">
                                        Welcome to Performance Pickleball RVA!
                                    </p>
                                    <p style="box-sizing:border-box; font-size:16px; line-height:1.5em; margin-top:0; margin-bottom:24px; text-align:left">
                                        Please be sure to download your app and login with the following info:
                                    </p>
                                    <p style="box-sizing:border-box; font-size:16px; line-height:1.5em; margin-top:0; text-align:left">
                                        <b style="text-transform: uppercase; color: #0d77bd;">Email: </b>
                                        {{ $email }}
                                    </p>
                                    <p style="box-sizing:border-box; font-size:16px; line-height:1.5em; margin-top:0; text-align:left">
                                        <b style="text-transform: uppercase; color: #0d77bd;">Pass: </b>
                                        {{ $password }}
                                    </p>
                                    <table class="x_subcopy" width="100%" cellpadding="0" cellspacing="0" role="presentation"
                                           style="box-sizing:border-box; padding-top:25px; text-align:center;">
                                        <tbody>
                                        <tr>
                                            <td style="box-sizing:border-box">
                                                <p style="box-sizing:border-box; line-height:1.5em; margin-top:0;">
                                                    <a href="https://apps.apple.com/us/app"
                                                       target="_blank"
                                                       style="text-decoration:none;">
                                                        <img src="{{ asset('img/app-store.png') }}" alt="App Store"
                                                             style="width:180px;" />
                                                    </a>
                                                </p>
                                                <p style="box-sizing:border-box; line-height:1.5em; margin-top:0;">
                                                    <a href="https://play.google.com/store/apps"
                                                       target="_blank"
                                                       style="text-decoration:none;">
                                                        <img src="{{ asset('img/google-play.png') }}" alt="App Store"
                                                             style="width:180px;" />
                                                    </a>
                                                </p>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="box-sizing:border-box">
                        <table class="x_footer" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation"
                               style="box-sizing:border-box; margin:0 auto; padding:0; text-align:center; width:100%; background-color: #0d77bd;">
                            <tbody>
                            <tr>
                                <td class="x_content-cell" align="center"
                                    style="box-sizing:border-box; color:#fff; max-width:100vw; padding:32px;">
                                    <p style="box-sizing:border-box; font-size:16px; font-weight: bold; line-height:1.5em; margin-top:0; margin-bottom:2px; color:#d0ff24;">
                                        {{ config('app.name') }}
                                    </p>
                                    <p style="box-sizing:border-box; font-size:16px; line-height:1.5em; margin-top:0; margin-bottom:32px;">
                                        8641 Quioccasin Rd, Henrico, VA 23229
                                    </p>
                                    <p style="box-sizing:border-box; line-height:1.5em; margin-top:0; font-size:12px;">
                                        <a href="{{ url('/') }}" target="_blank"
                                           style="color:#d0ff24;">www.ppbrva.com</a>
                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
