<?
$link = "unsubscribe.php?id=$user['id']&validation_hash=".md5($user['id'].$SECRET_STRING)
<a href="<?=$link?>">Unsubscribe</a>

function unsubscribe() 
{
$expected = md5( $user['id'] . $SECRET_STRING );
if( $_GET['validation_hash'] != $expected )
        throw new Exception("Validation failed.");
sql("UPDATE users SET wants_newsletter = FALSE WHERE id = " . escape($_GET['id']);
}
