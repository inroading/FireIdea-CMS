<?php
$s=Think::instance('SaeStorage');
$url=rtrim($s->getUrl('Public',''),'/');
return array(
    'TMPL_PARSE_STRING'=>array(
        '__PUBLIC__'=>$url
    )
);
?>