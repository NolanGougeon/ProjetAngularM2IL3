<?php

function sendMail($email,$object,$contenu){
$header="MIME-Version: 1.0\r\n";
	$header.='From:"GlazikGym.com"<support@glazikgym.com>'."\n";
	$header.='Content-Type:text/html; charset="uft-8"'."\n";
	$header.='Content-Transfer-Encoding: 8bit';
	$message="
	<html>
        <meta http-equiv=\"Content-Type \" content=\"text/html; charset=utf-8 \">
        <meta name=\"viewport \" content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0 \">
        <style type=\"text/css \">
            html {
                width: 100%;
            }

            body {
                width: 100%;
                margin: 0;
                padding: 0;
                -webkit-font-smoothing: antialiased;
                mso-margin-top-alt: 0px;
                mso-margin-bottom-alt: 0px;
                mso-padding-alt: 0px 0px 0px 0px;
                background: #E7E7E7;
            }

            img {
                border: none!important;
            }
        </style>
        <body style=\"margin: 0; padding: 0; \" yahoo=\"fix \"

                <div class='top' style=\"background-color: #eeeeee;
                         background-size: cover; -webkit-background-size: cover;  width: 100%; height: 300;  \">

                    <div style=\"color:black; font-family:'Raleway', Helvetica, Arial,
                                    sans-serif; font-size: 27px; font-weight:100; text-transform: uppercase; line-height:50px; letter-spacing:1px;\">
                        Welcome ! {$contenu['civilite']} {$contenu['nom']};
                        <hr/>
                    </div>

                    <div style=\"color:black; font-family:'Raleway', Helvetica, Arial, sans-serif; font-size: 21px; font-weight: 200; text-transform: uppercase; line-height:50px; letter-spacing:1px; \">
                        Veuillez confirmer Votre inscription cher GLAZYK Member Associate.

                        <span style='float:right'>
                            <a href=\"{$contenu['lienActive']}\" style=\"padding: 10px 30px; background:indianred; color: white; text-decoration:none\">Cliquez ici</a>
                        </span>
                    </div>

                </div>

        </body>
</html> ";
	mail($email, $object, $message, $header);
}