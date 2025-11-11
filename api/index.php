<?php

@mkdir('/tmp/api-docs', 0755, true);
@mkdir('/tmp/views', 0755, true);
@mkdir('/tmp/cache', 0755, true);

require __DIR__ . '/../public/index.php';