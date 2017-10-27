?
$link = "unsubscribe.php?id=$user['id']&validation_hash=".md5($user['id'].$SECRET_STRING)
<a href="<?=$link?>">Unsubscribe</a>
