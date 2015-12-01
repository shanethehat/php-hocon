<?php
/**
 * Created by PhpStorm.
 * User: shane
 * Date: 30/11/15
 * Time: 12:52
 */

namespace PhpHocon\Token;


class Key
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
