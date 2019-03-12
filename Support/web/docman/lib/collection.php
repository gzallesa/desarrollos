<?php
/**
 * Description of noticias
 *
 * @author Irra_b
 */
class collection {
    private $list;
    public function __construct() {
        $this->list=array();
    }
    public function add($element)
    {
        array_push($this->list, $element);
    }
    public function length()
    {
        return count($this->list);
    }
    public function getElement($i)
    {
        return $this->list[$i];
    }
    public function addCollection(collection $c)
    {
        for($i=0;$i<$c->length();$i++)
        {
            $this->add($c->getElement($i));
        }
    }
}
