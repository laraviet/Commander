<?php
namespace Laracasts\Commander\Laraviet;

class BaseArrayCommand
{
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
}
