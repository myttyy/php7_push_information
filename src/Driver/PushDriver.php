<?php
namespace myttyy\Driver;

interface PushDriver
{
    public function push($template): bool;
}