<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm Your Subscription - Techxtrasol Agency</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Light theme (default) */
        body {
            background-color: #f5f7fa;
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            color: #333333;
            line-height: 1.6;
        }

        /* Dark theme using media query */
        @media (prefers-color-scheme: dark) {
            body {
                background-color: #1a1a1a !important;
                color: #ffffff !important;
            }
            .container {
                background-color: #2a2a2a !important;
                border-color: #444444 !important;
            }
            .header {
                border-bottom-color: #444444 !important;
                background-color: #222222 !important;
            }
            .footer {
                border-top-color: #444444 !important;
                background-color: #222222 !important;
            }
            h1 {
                color: #ffffff !important;
            }
            p {
                color: #dddddd !important;
            }
            .confirm-button {
                background-color: #6366F1 !important;
            }
            .confirm-button:hover {
                background-color: #818cf8 !important;
            }
            .unsubscribe-button {
                background-color: #374151 !important;
                color: #e5e7eb !important;
                border-color: #4b5563 !important;
            }
            .muted-text {
                color: #9ca3af !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f5f7fa;">
    <!-- Main Table -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <!-- Email Container -->
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); border: 1px solid #e5e7eb;">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding: 25px; border-bottom: 1px solid #e5e7eb; background-color: #f8f9fa; border-radius: 8px 8px 0 0;">
                            <a href="{{ config('app.url') }}" style="text-decoration: none; font-size: 24px; font-weight: bold; color: #333333;">
                                <span style="color: #4F46E5;">Tech</span>xtrasol
                            </a>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center">
                                        <h1 style="font-size: 24px; margin: 0 0 20px 0; color: #1f2937; font-weight: 700;">Confirm Your Subscription</h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding-bottom: 30px;">
                                        <p style="font-size: 16px; line-height: 1.6; color: #4b5563; margin: 0 0 20px 0;">
                                            Thank you for subscribing to our newsletter! We're excited to share the latest tech insights, solutions, and updates with you.
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding-bottom: 30px;">
                                        <table cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="center" style="border-radius: 6px;" bgcolor="#4F46E5">
                                                    <a href="{{ $url }}" target="_blank" class="confirm-button" style="display: inline-block; padding: 14px 30px; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: bold;">
                                                        Confirm Subscription
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <p class="muted-text" style="font-size: 14px; color: #6b7280; margin: 0;">
                                            By confirming, you'll receive our latest updates, tech news, and exclusive offers.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Divider -->
                    <tr>
                        <td style="padding: 0 30px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="border-top: 1px solid #e5e7eb; padding: 20px 0;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Unsubscribe Section -->
                    <tr>
                        <td align="center" style="padding: 0 30px 30px 30px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" style="padding-bottom: 15px;">
                                        <p class="muted-text" style="font-size: 14px; color: #6b7280; margin: 0;">
                                            If you didn't request this subscription, you can safely:
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <table cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="center" style="border-radius: 6px; border: 1px solid #e5e7eb;" bgcolor="#f3f4f6">
                                                    <a href="{{ $unsubscribeUrl }}" target="_blank" class="unsubscribe-button" style="display: inline-block; padding: 10px 20px; font-size: 14px; color: #4b5563; text-decoration: none; border-radius: 6px;">
                                                        Unsubscribe
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding: 20px; border-top: 1px solid #e5e7eb; background-color: #f8f9fa; border-radius: 0 0 8px 8px;" class="footer">
                            <p class="muted-text" style="font-size: 12px; color: #6b7280; margin: 0;">
                                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
