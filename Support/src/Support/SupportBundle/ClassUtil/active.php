<?php

/**
 * Description of active
 *
 * @author Irra_b
 */

namespace Support\SupportBundle\ClassUtil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
class active {

    //put your code here
    public function getActive($session) {
        return $session->get('active');
    }
    public function setActive($active){
        $session = new Session();
        $session->set('active', $active);
    }
}
