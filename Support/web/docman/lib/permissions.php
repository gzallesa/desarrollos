<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of permissions
 *
 * @author Irra_b
 */
class permissions {
    private $file;
    private $users;
    private $groups;
    public function __construct($file,$users,$groups)
    {
        $this->file=$file;
        $this->users=$users;
        $this->groups=$groups;
    }
    public function getFile()
    {
        return $this->file;
    }
    public function getUsers()
    {
        return $this->users;
    }
    public function getUsersRead()
    {
        if(substr($this->users, 0, 1)=='-')
        {
            return false;
        }
        if(substr($this->users, 0, 1)=='r')
        {
            return true;
        }
    }
    public function getUsersWrite()
    {
        if(substr($this->users, 1, 1)=='-')
        {
            return false;
        }
        if(substr($this->users, 1, 1)=='w')
        {
            return true;
        }
    }
    public function getUsersX()
    {
        if(substr($this->users, 2, 1)=='-')
        {
            return false;
        }
        if(substr($this->users, 2, 1)=='x')
        {
            return true;
        }
    }
    public function getGroupRead()
    {
        if(substr($this->groups, 0, 1)=='-')
        {
            return false;
        }
        if(substr($this->groups, 0, 1)=='r')
        {
            return true;
        }
    }
    public function getGroupWrite()
    {
        if(substr($this->groups, 1, 1)=='-')
        {
            return false;
        }
        if(substr($this->groups, 1, 1)=='w')
        {
            return true;
        }
    }
    public function getGroupX()
    {
        if(substr($this->groups, 2, 1)=='-')
        {
            return false;
        }
        if(substr($this->groups, 2, 1)=='x')
        {
            return true;
        }
    }
    public function getGroups()
    {
        return $this->groups;
    }
    public function setUsers($users)
    {
        $this->users=$users;
    }
    public function setGroups($groups)
    {
        $this->groups=$groups;
    }
}
