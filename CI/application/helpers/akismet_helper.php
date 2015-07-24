 <?php

/*$data = array(
          'blog' => '',
          'user_ip' => '127.0.0.1',
          'user_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6',
          'referrer' => '',
          'permalink' => '',
          'comment_type' => 'comment',
          'comment_author' => 'admin',
          'comment_author_email' => 'test@test.com',
          'comment_author_url' => '',
          'comment_content' => 'It is important to test Akismet with a significant amount of real, live data in order to draw any conclusions on accuracy. Akismet works by comparing content to genuine spam activity happening right now (and this is based on more than just the content itself), so artificially generating spam comments is not a viable approac');*/

function akismet_comment_check( $key, $data ) {
$request = 'blog='. urlencode($data['blog']) .
           '&user_ip='. urlencode($data['user_ip']) .
           '&user_agent='. urlencode($data['user_agent']) .
           '&referrer='. urlencode($data['referrer']) .
           '&permalink='. urlencode($data['permalink']) .
           '&comment_type='. urlencode($data['comment_type']) .
           '&comment_author='. urlencode($data['comment_author']) .
           '&comment_author_email='. urlencode($data['comment_author_email']) .
           '&comment_author_url='. urlencode($data['comment_author_url']) .
           '&comment_content='. urlencode($data['comment_content']);
$host = $http_host = $key.'.rest.akismet.com';
$path = '/1.1/comment-check';
$port = 443;
$akismet_ua = "WordPress/3.8.1 | Akismet/2.5.9";
$content_length = strlen( $request );
$http_request  = "POST $path HTTP/1.0\r\n";
$http_request .= "Host: $host\r\n";
$http_request .= "Content-Type: application/x-www-form-urlencoded\r\n";
$http_request .= "Content-Length: {$content_length}\r\n";
$http_request .= "User-Agent: {$akismet_ua}\r\n";
$http_request .= "\r\n";
$http_request .= $request;
$response = '';
if( false != ( $fs = @fsockopen( 'ssl://' . $http_host, $port, $errno, $errstr, 10 ) ) ) {
     
    fwrite( $fs, $http_request );
 
    while ( !feof( $fs ) )
        $response .= fgets( $fs, 1160 ); // One TCP-IP packet
    fclose( $fs );
     
    $response = explode( "\r\n\r\n", $response, 2 );
}
 
if ( 'true' == $response[1] )
    return true;
else
    return false;
}