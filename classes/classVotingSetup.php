<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of classVoting
 *
 * @author Pavel
 */
class VotingSetup {
    private $_p;
    private $_setupId;
    private $_setupLine;
    private $_puchLine = array();
    
    public function __construct() {
        $this->_setupId = '';
        $this->_setupLine = '';
        $this->_p = 0;
        return $this->_p;
    }
  
    public function add ($sid, $sline, $pid, $pline) {
        $this->_setupId = $sid;              
        $this->_setupLine = $sline;             
        $this->_puchLine[] = array('id'=>$pid, 'line'=>$pline);       
        return ++$this->_p;
    }   
    
    public function addSetup ($sid, $sline) {
        $this->_setupId = $sid;
        $this->_setupLine = $sline;
        return $this->_p;
    }
    
    
    /**
     * 
     * @param type $pid
     * @param type $pline
     */
    public function addPunch ($pid, $pline) {
        $this->_puchLine[] = new VotingPunchline($pid, $pline);
        return ++$this->_p;
    }
    
    public function getCount () {
        return $this->_p;
    }
    
    public function getId () {
        return $this->_setupId;
    }
    
    public function getLine () {
        return $this->_setupLine;
    }   
    
    public function getPunchlines () {
        return $this->_puchLine;
    } 
    
    public function getSinglePunchline ($n) {
        return $this->_puchLine[$n];
    }     
}

?>
