<?php

Broadcast::channel('{tenant}.orders', function () {
    return true;
});

Broadcast::channel('{tenant}.orders.{order}', function () {
    return true;
});
