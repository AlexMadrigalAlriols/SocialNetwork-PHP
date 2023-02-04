<html>

<head>
    <title>MTGCollectioner</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#242424" style="background-color:#242424; margin:0; padding:0;">
    <table width="100%" bgcolor="#242424" style="background-color:#242424;">
        <tr>
            <td style="padding: 10px;" align="center">
                <table width="650" align="center"
                    style="width:650px; font-family: Helvetica, Arial, sans-serif; color: #999;">
                    <tr>
                        <td height="100" width="650" align="center" style="text-align: center;">
                            <a rel="nofollow" target="_blank" href="https://www.mtgcollectioner.com"
                                title="Go MtgCollectioner">
                                <img src="https://i.imgur.com/qQViD7F.png" width="250" alt="MTGCollectioner">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="text-align: center">
                            <table width="650px"
                                style="border-radius: 5px; margin-bottom: 2rem; font-family: Helvetica, Arial, sans-serif; font-size:12pt; color: rgb(26, 29, 45); background: #f7f7f7; line-height: 18pt; -webkit-box-shadow: 0px 0px 16px 0px rgba(0,0,0,0.1); -moz-box-shadow: 0px 0px 16px 0px rgba(0,0,0,0.1); box-shadow: 0px 0px 16px 0px rgba(0,0,0,0.1); border-top: 3px solid #4723D9;">
                                <tr>
                                    <td bordercolor="#4723D9"
                                        style="padding:45px 30px; font-size:12pt; color:#003840; text-align:left;">
                                        <p style="font-size:24pt;"><strong style="color: 4723D9">Reset Password</strong></p>
                                        <p>Hi, @<?=$username;?></p>
                                        <p>A password reset has been requested. If you did not make this request, you can safely ignore this email.</p>
                                        <p><strong>Otherwise, click here to change your password</strong></p>
                                        <a href="https://mtgcollectioner.com/forgot-password/<?=$verify_code . "#" . $id_user . "#" . sha1($username)?>" rel="nofollow"
                                            target="_blank" style="color:#fff;text-decoration:none; ">
                                            <p
                                                style="text-align:center;display:block;margin:30px 4% 0 4%;padding:10px 25px;background:#4723D9;font-size:14pt;line-height:18pt; border-radius: 5px;">
                                                Change password</small>
                                            </p>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top"
                                        style="padding:0 0 10px 0; font-family: Helvetica, Arial, sans-serif; color: rgb(150, 150, 150); ">
                                        <font style="font-size:10pt;">&#169;MTGCollectioner | <a
                                                href="https://www.mtgcollectioner.com/login" rel="nofollow"
                                                target="_blank"
                                                style="text-decoration:underline; color: rgb(150, 150, 150); color:#969696">Privacy
                                                Policy</a></font><br>
                                        <font style="font-size:10pt;"><a
                                                href="https://www.mtgcollectioner.com" rel="nofollow"
                                                target="_blank"
                                                style="text-decoration:underline; color: rgb(150, 150, 150); color:#969696">www.mtgcollectioner.com</a></font><br>
                                    </td>
                                </tr>
                            </table>
                            <br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>