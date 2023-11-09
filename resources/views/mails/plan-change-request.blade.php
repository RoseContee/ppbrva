<table class="x_wrapper" role="presentation" style="width:100%; background-color:#fff;">
    <tbody>
    <tr>
        <td>
            <table class="x_content" role="presentation" style="width:100%;">
                <tbody>
                <tr>
                    <td class="x_header" style="padding:25px 0; text-align:center;">
                        <a href="{{ url('/') }}" target="_blank"
                           style="display:inline-block; color:#3d4852; font-size:19px; font-weight:bold; text-decoration:none;">
                            <img class="x_logo" src="{{ asset('img/logo.png') }}" alt="Performance Pickleball"
                                 style="max-width:100%; max-height:120px; width:120px; height:120px;">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="x_body" style="width:100%; background-color:#fff; border:hidden!important">
                        <table class="x_inner-body" role="presentation"
                               style="width:570px; margin:0 auto; background-color:#ffffff; border: 1px #e8e5ef; border-radius:2px; box-shadow:0 0.125rem 1rem 1px rgba(0,0,0,.075);">
                            <tbody>
                            <tr>
                                <td class="x_content-cell" style="max-width:100vw; padding:32px">
                                    <h1 style="color:#1a2755; font-size:22px; font-weight:bold;">
                                        Membership Plan Change Request
                                    </h1>
                                    <p style="color:#0d77bd; font-size:16px; font-weight:bold; line-height:1.5em; margin:0;">
                                        {{ $member['name'] }}
                                    </p>
                                    <p style="color:#1a2755; font-size:16px; line-height:1.5em; margin:0 0 24px 0;">
                                        Member #{{ $member['memberID'] }}
                                    </p>
                                    @if ($member['phone'])
                                    <p style="color:#1a2755; font-size:16px; line-height:1.5em; margin:0;">
                                        {{ $member['phone'] }}
                                    </p>
                                    @endif
                                    <p style="color:#1a2755; font-size:16px; line-height:1.5em; margin:0 0 24px 0;">
                                        {{ $member['email'] }}
                                    </p>
                                    <p style="color:#1a2755; font-size:16px; line-height:1.5em; margin:0;">
                                        <b style="color:#0d77bd;">Current plan: </b> {{ $member['plan']['name'] ?? 'Unknown' }}
                                    </p>
                                    <p style="color:#1a2755; font-size:16px; line-height:1.5em; margin:0 0 24px 0;">
                                        <b style="color:#0d77bd;">Requested plan: </b> {{ $plan }}
                                    </p>
                                    <p style="color:#707070; font-size:16px; line-height:1.5em; margin:0 0 24px 0;">
                                        This member has requested to change their plan, please contact them to confirm the details.
                                    </p>
                                    <p style="color:#707070; font-size:16px; line-height:1.5em; margin:0;">
                                        Plans can be updated in the
                                        <a href="{{ route('members.edit', $member['id']) }}" target="_blank" style="color:#0d77bd;">Members</a>
                                        section of the admin portal by editing the desired member record
                                        and choosing a new plan option.
                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="x_footer" role="presentation"
                               style="width:100%; margin:0 auto; text-align:center; background-color: #0d77bd;">
                            <tbody>
                            <tr>
                                <td class="x_content-cell" style="max-width:100vw; color:#fff; padding:32px;">
                                    <p style="color:#d0ff24; font-size:16px; font-weight: bold; line-height:1.5em; margin:0 0 2px 0;">
                                        {{ config('app.name') }}
                                    </p>
                                    <p style="font-size:16px; line-height:1.5em; margin:0 0 32px 0;">
                                        {{ env('CONTACT_ADDRESS') }}
                                    </p>
                                    <p style="font-size:12px; line-height:1.5em; margin:0;">
                                        <a href="{{ url('/') }}" target="_blank" style="color:#d0ff24;">www.ppbrva.com</a>
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
