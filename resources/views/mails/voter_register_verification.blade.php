<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">
        @font-face {
            font-family: "Special Elite";
            font-style: normal;
            font-weight: 400;
            src: local("Special Elite"), local("SpecialElite-Regular"),
                url(https://fonts.gstatic.com/s/specialelite/v6/9-wW4zu3WNoD5Fjka35JmwYWpCd0FFfjqwFBDnEN0bM.woff2)
                format("woff2");
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC,
                U+2000-206F, U+2074, U+20AC, U+2212, U+2215, U+E0FF, U+EFFD, U+F000;
        }

        body {
            font-family: "Special Elite", monospace, Courier New;
            background: #eee;
        }

        .email {
            display: block;
            width: 470px;
            padding: 60px 100px;
            margin: 50px auto;
            background: #fff;
            box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
        }

        .signature-name {
            text-align: initial;
            font: 16px;
            color: #666;
            padding: 0 20px;
            line-height: 24px;
        }

        .signature-title {
            font-size: 14px;
            color: #666;
        }

        .signature-contact {
            color: #999;
            font-size: 14px;
            text-align: initial;
            padding: 20px 20px;
        }
        .signature-contact a {
            color: #999;
            text-decoration: none;
            line-height: 24px;
        }

        p {
            font-size: 18px;
            margin-bottom: 1.5em;
            line-height: 1.6;
            color: #444;
        }
    </style>
</head>

<body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
    <div class="email">
        <p>Dear {{$voter_profile->first_name. ' '. $voter_profile->last_name}},</p>
        <p>We are delighted to inform you that your voter ID registration process has been successfully completed! 🎉Your commitment to civic responsibility is commendable, and we want to express our gratitude for participating in the democratic process.</p>
        <p>Here are the details of your registration:</p>
        <p>- Voter ID Registration Number: {{ $voter_profile->register_id}}</p>
        <p>- Name: {{$voter_profile->first_name. ' '. $voter_profile->last_name}}</p>
        <p>- Date of Birth: {{$voter_profile->dob}}</p>
        <p>- Email: {{$voter_profile->email}}</p>
        <p>- Mobile: {{$voter_profile->mobile}}</p>
        <p>As a registered voter, you play a crucial role in shaping the future of our community and nation. Your vote is your voice, and we encourage you to exercise this right in upcoming elections.</p>
        <p>Thank you once again for your active participation in the electoral process. We wish you all the best, and may your voice be heard in the upcoming elections!</p>
    </div>
</body>

</html>