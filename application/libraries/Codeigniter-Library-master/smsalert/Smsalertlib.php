<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter SMS Alert Library
 *
 * Generate SMS Alert in your CodeIgniter applications.
 *
 * @package         CodeIgniter
 * @subpackage      Libraries
 * @category        Libraries
 * @author          SMS Alert
 * @license         MIT License
 * @link            https://github.com/SMSAlert/API-Integration-Sample-Code-PHP
 */

require_once(dirname(__FILE__) . '/vendor/autoload.php');
use SMSAlert\Lib\Smsalert\Smsalert;

class Smsalertlib
{
    private $user = ''; // write your SMSAlert Username in between ''
    private $pass = ''; // write your SMSAlert Password in between ''
    private $senderid = ''; // write your Sender ID in between ''
    
    /**
     * Send SMS alert for sender
     *
     * @access  public
     * @param   string  $MOBILENO The MOBILENO to load
     * @param   string  $TEXT The TEXT to load     
     * @return  void
     */
    public function smssend($MOBILENO, $TEXT)
    {
        $smsalert      = (new Smsalert())
                ->authWithUserIdPwd($this->user, $this->pass);      
       $smsalert->setSender($this->senderid)
         ->send($MOBILENO, $TEXT);        
        return $this;

    }


    /**
     * For Create group
     *
     * @access  public
     * @param   string  $grpname The grpname to load
     * @return  void
     */
    public function creategroup($grpname)
    {
       $smsalert      = (new Smsalert())
                ->authWithUserIdPwd($this->user, $this->pass);
       $result = $smsalert->createGroup($grpname);
       return $this;

    }


    /**
     * For Import Contact for sender
     *
     * @access  public
     * @param   string  $grpname The grpname to load
     * @param   array   $datas The datas data
     * @return  void
     */    
    public function createcontact($grpname, $datas)
    {
       
        $smsalert      = (new Smsalert())
                ->authWithUserIdPwd($this->user, $this->pass);
        $datas = array(array('person_name'=>$datas['person_name'],'number'=>$datas['number']));        
        $result = $smsalert->importXmlContact($datas,$grpname);
        return $this;

    }
    
    /**
     * For Send Group Sms 
     *
     * @access  public
     * @param   string  $grid The grid to load
     * @param   string  $text The text to load
     * @return  void
     */
    public function sendgroupsms($grid, $text)
    {
       $smsalert      = (new Smsalert())
                ->authWithUserIdPwd($this->user, $this->pass);
       $result = $smsalert->setSender($this->senderid)
         ->sendGroupSms($grid,$text); 
       return $this;

    }

  }
?>
