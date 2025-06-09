<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            margin: 120px 50px 80px 50px;
        }

        body {
            font-family: sans-serif;
        }

        header {
            position: fixed;
            top: -100px;
            left: 0;
            right: 0;
            height: 100px;
        }

        .content {
            margin-top: 20px;
        }

        .logo {
            height: 60px;
        }
    </style>
</head>
<body>

<header>
    <table width="100%">
        <tr>
            <td width="15%" style="text-align: left;">
                <img src="{{ public_path('img/temp_logo.png') }}" class="logo">
            </td>
            <td width="70%" style="text-align: center; font-family: serif;">
                <div>
                    <div style="font-family: 'Old English MT', serif; font-size: 18px;">
                        Republic of the Philippines
                    </div>
                    <div style="font-weight: bold; font-size: 14px;">
                        PROVINCE OF NUEVA VIZCAYA
                    </div>
                    <div style="font-weight: bold; font-size: 14px;">
                        BAYOMBONG
                    </div>
                    <div style="font-size: 12px;">-o0o-</div>
                    <div style="font-weight: bold; font-size: 16px;">
                        PROVINCIAL ENGINEERING OFFICE
                    </div>
                    <p style="margin: 0;">People’s Hall, Capitol Compound, Bayombong, Nueva Vizcaya, 3700</p>
                </div>
            </td>
            <td width="15%" style="text-align: right;">
                <img src="{{ public_path('img/left_logo.png') }}" class="logo">
            </td>
        </tr>
    </table>
</header>

<div class="content">
    {!! $content !!}
</div>

</body>
</html>
