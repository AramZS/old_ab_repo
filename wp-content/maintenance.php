    <?php
    $protocol = $_SERVER["SERVER_PROTOCOL"];
    if ( 'HTTP/1.1' != $protocol && 'HTTP/1.0' != $protocol )
        $protocol = 'HTTP/1.0';
    header( "$protocol 503 Service Unavailable", true, 503 );
    header( 'Content-Type: text/html; charset=utf-8' );
    ?>

    <html xmlns="http://www.w3.org/1999/xhtml">
    <title>Site Maintenance</title>
    <style>
        body { text-align: center; padding: 150px; }
        h1 { font-size: 50px; }
        body { font: 20px Helvetica, sans-serif; color: #333; }
        article { display: block; text-align: left; width: 650px; margin: 0 auto; }
        a { color: #dc8100; text-decoration: none; }
        a:hover { color: #333; text-decoration: none; }
    </style>

    <article>
    <h1>We&rsquo;re working on it!</h1>
    <div>
    <p>Sorry for the inconvenience but we&rsquo;ve taken the site down due to suspicious activity on our server. We'll be back up ASAP.</p>
    <p>&mdash; The AstroBetter Team</p>
    </div>
    </article>
    </html>


    <?php die(); ?>
