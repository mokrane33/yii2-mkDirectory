<?php
/**
 * Created by PhpStorm.
 * User: mokrane
 * Date: 27/03/2016
 * Time: 15:08
 */

namespace app\resources;


class Resources
{
   public $type=[
        '1' => 'PADDING',
        '2' => 'VALIDE',
        '3' => 'CLOSE',
        ];
    public function getStatus()
    {
        return $this->type;
    }
}