<?php
return array_merge(
    ['settings' => require_once __DIR__ .'/settings.php'],
    require_once __DIR__ .'/dependencies.php'
);
