<!DOCTYPE html>
<html>
<head>
    <title>New Link Shared</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');
        .primary-color { color: #6366f1; }
        .btn {
            background-color: #6366f1;
            color: white !important;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            font-weight: 500;
        }
    </style>
</head>
<body style="margin: 0; padding: 0; font-family: 'Inter', sans-serif; background-color: #f8fafc;">

    <!-- Main Content -->
    <div style="max-width: 600px; margin: 30px auto; padding: 0 20px;">
        <div style="background-color: white; border-radius: 8px; padding: 40px 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h1 style="margin: 0 0 25px; font-size: 24px; color: #1e293b;">
                Hello, <span class="primary-color">{{ $notifiable->name }}</span>! 👋
            </h1>
            
            <p style="font-size: 16px; color: #475569; line-height: 1.6; margin: 0 0 25px;">
                <strong style="color: #1e293b;">{{ $sharedBy }}</strong> has shared a link with you:
            </p>

            <div style="background-color: #f8fafc; border-radius: 6px; padding: 20px; margin: 30px 0;">
                <h2 style="margin: 0 0 15px; font-size: 20px; color: #1e293b;">
                    {{ $linkTitle }}
                </h2>
                <a href="https://ndfproject.my.id/dashboard/link" class="btn">
                    Open Dashboard 
                </a>
                <div style="margin-top: 25px; color: #64748b; font-size: 14px;">
                    <p style="margin: 8px 0;">
                        <strong>Shared at:</strong> {{ $sharedAt }}
                    </p>
                </div>
            </div>

            <p style="font-size: 14px; color: #64748b; line-height: 1.6; margin: 25px 0 0;">
                You're receiving this email because someone shared a link with you through Linksy.
                If this wasn't you, please ignore this email.
            </p>
        </div>
    </div>

    <!-- Footer -->
    <div style="max-width: 600px; margin: 30px auto; text-align: center; padding: 0 20px;">
        <div style="color: #64748b; font-size: 12px; line-height: 1.6;">
            <p style="margin: 8px 0;">
                © {{ date('Y') }} {{ $appName }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>