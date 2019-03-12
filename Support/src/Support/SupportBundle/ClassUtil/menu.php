<?php

namespace Support\SupportBundle\ClassUtil;

use Support\SupportBundle\Entity\Tipusr;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of menu
 *
 * @author Irra_b
 */
class menu {

    //put your code here
    private $d;

    public function __construct($m) {
        $this->d = $m;
    }

    public function getDonut($id, $type) {
        $em = $this->d->getManager();
        if ($type == 3) {
            $donut = $em->createQuery(
                            'SELECT s.estado,count(s)as total
                  FROM SupportBundle:DocmanSolicitud s JOIN s.solicitante u JOIN s.problema pr
                  WHERE u.soporte=:id
                  group by s.estado')->setParameter('id', $id);
        }
        if ($type == 7) {
            $donut = $em->createQuery(
                            'SELECT p.estado,count(p) as total
                  FROM SupportBundle:DocmanSolicitud p 
                  JOIN p.solicitante c 
                  JOIN p.problema pr 
                  JOIN pr.usuariofuncional uf
                  WHERE uf.id=:id
                  AND p.derivado=1
                  group by p.estado')->setParameter('id', $id);
        }
        return $donut->getResult();
    }

    public function getSolicitudes($id, $type) {
        $em = $this->d->getManager();
        if ($type == 3) {
            $q = $em->createQuery(
                            'SELECT p,c 
                  FROM SupportBundle:DocmanSolicitud p JOIN p.solicitante c JOIN p.problema pr LEFT JOIN pr.usuariofuncional uf
                  WHERE c.soporte=:id
                  AND p.estado=0
                  Order By p.fechaSolicitud, p.horaSolicitud')->setParameter('id', $id);
        }
        if ($type == 7) {
            $q = $em->createQuery(
                            'SELECT p,c,pr,uf 
                  FROM SupportBundle:DocmanSolicitud p 
                  JOIN p.solicitante c 
                  JOIN p.problema pr 
                  JOIN pr.usuariofuncional uf
                  WHERE uf.id=:id
                  AND p.derivado=1
                  AND p.estado=0
                  Order By p.fechaSolicitud, p.horaSolicitud')->setParameter('id', $id);
        }
        return $q->getResult();
    }

    public function getTop($id, $type) {
        $em = $this->d->getManager();
        if ($type == 3) {
            $q = $em->createQuery(
                    'SELECT c.name as name,count(p)as y,c.id
                  FROM SupportBundle:DocmanSolicitud p JOIN p.solicitante c  
                  WHERE c.soporte=:id
                  AND p.estado=1
                  Group By p.solicitante');
            $q->setParameter('id', $id);
            $q->setMaxResults(10);
        }
        if ($type == 7) {
            $q = $em->createQuery(
                            'SELECT c.name as name,count(p)as y,c.id 
                  FROM SupportBundle:DocmanSolicitud p 
                  JOIN p.solicitante c 
                  JOIN p.problema pr 
                  JOIN pr.usuariofuncional uf
                  WHERE uf.id=:id
                  AND p.derivado=1
                  AND p.estado=1
                  Group By p.solicitante')->setParameter('id', $id);
        }
        return $q->getResult();
    }

}
