<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Blog Post</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <style type="text/css">
        /* CLIENT-SPECIFIC STYLES */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; }
        img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { margin: 0 !important; padding: 0 !important; width: 100% !important; }

        /* iOS BLUE LINKS */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* DARK MODE STYLES - SIMPLIFIED */
        @media (prefers-color-scheme: dark) {
            .dark-bg { background-color: #1e293b !important; }
            .dark-text { color: #f1f5f9 !important; }
            .dark-secondary { color: #cbd5e1 !important; }
            .dark-border { border-color: #334155 !important; }
            .dark-button { background-color: #4f46e5 !important; }
            .dark-header { background-color: #4338ca !important; }
            .dark-footer { background-color: #1e293b !important; }
        }

        /* MOBILE STYLES - SIMPLIFIED */
        @media screen and (max-width: 600px) {
            .mobile-padding { padding-left: 10px !important; padding-right: 10px !important; }
            .mobile-stack { display: block !important; width: 100% !important; }
        }
    </style>
</head>
<body style="background-color: #f0f4f8; font-family: Arial, Helvetica, sans-serif; font-size: 16px; line-height: 1.5; color: #333333; margin: 0; padding: 0;">
    <!-- PREHEADER TEXT -->
    <div style="display: none; max-height: 0px; overflow: hidden;">
        Check out our latest blog post and stay updated with fresh content!
    </div>

    <!-- MAIN EMAIL CONTAINER -->
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding: 30px 10px;">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border: 1px solid #e2e8f0;" class="dark-bg">
                    <!-- HEADER -->
                    <tr>
                        <td align="center" style="background-color: #4f46e5; padding: 40px 30px; color: #ffffff;" class="dark-header">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: bold;">
                                {{ config('app.name') }}
                            </h1>
                            <p style="margin-top: 15px; margin-bottom: 0; color: #ffffff; font-size: 18px;">Fresh content just for you</p>
                        </td>
                    </tr>

                    <!-- MAIN CONTENT -->
                    <tr>
                        <td style="background-color: #ffffff;" class="dark-bg">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="padding: 40px 30px 20px;" class="mobile-padding">
                                        <!-- POST TITLE -->
                                        <h2 style="margin-top: 0; margin-bottom: 20px; font-size: 24px; font-weight: bold; color: #1e293b; line-height: 1.3;" class="dark-text">{{ $post->title }}</h2>

                                        <!-- DECORATIVE ACCENT LINE -->
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="80" style="margin-bottom: 25px;">
                                            <tr>
                                                <td style="height: 4px; background-color: #4f46e5;" class="dark-button"></td>
                                            </tr>
                                        </table>

                                        <!-- POST EXCERPT -->
                                        <p style="margin: 0 0 30px; font-size: 16px; line-height: 1.6; color: #4a5568;" class="dark-text">
                                            {!! nl2br(e(Str::limit(strip_tags($post->excerpt ?? $post->content), 300))) !!}
                                        </p>

                                        <!-- CTA BUTTON -->
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin: 30px 0;">
                                            <tr>
                                                <td align="center" style="background-color: #4f46e5; padding: 15px 30px;" class="dark-button">
                                                    <a href="{{ route('blog.post', $post->slug) }}" target="_blank" style="display: inline-block; color: #ffffff; font-size: 16px; font-weight: bold; text-decoration: none; text-transform: uppercase;">Read Full Article</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!-- RECENT POSTS SECTION -->
                                <tr>
                                    <td style="padding: 20px 30px 40px; background-color: #f8fafc;" class="mobile-padding dark-bg">
                                        <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 20px; font-weight: bold; color: #1e293b; padding-bottom: 10px; border-bottom: 2px solid #e2e8f0;" class="dark-text dark-border">More Articles You Might Enjoy</h3>

                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            @foreach($recentPosts as $recent)
                                            <tr>
                                                <td style="padding: 12px 0; border-bottom: 1px solid #e2e8f0;" class="dark-border">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td width="20" valign="top">
                                                                <div style="width: 6px; height: 6px; background-color: #4f46e5; margin-top: 8px;" class="dark-button"></div>
                                                            </td>
                                                            <td style="padding-left: 10px;">
                                                                <a href="{{ route('blog.post', $recent->slug) }}" style="color: #1e293b; text-decoration: none; font-weight: bold; font-size: 16px;" class="dark-text">
                                                                    {{ $recent->title }}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background-color: #1e293b; padding: 30px; text-align: center; border-top: 1px solid #334155;" class="dark-footer">
                            <p style="margin: 0 0 10px; font-size: 14px; color: #cbd5e1;" class="dark-secondary">
                                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                            </p>
                            <p style="margin: 0; font-size: 14px; color: #94a3b8;" class="dark-secondary">
                                <a href="https://techxtrasol.com/privacy-policy" style="color: #94a3b8; text-decoration: underline;" class="dark-secondary">Privacy Policy</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
