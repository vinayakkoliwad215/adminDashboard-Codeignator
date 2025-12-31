## Overview

Sms Alert Codeigniter Library for sending transactional/promotional SMS, through your custom code. Easy to integrate, you just need to write 2 lines of code to send SMS.

## Parameters Details
### If you have no account on smsalert.co.in, kindly register https://www.smsalert.co.in/

* username : SMS Alert User Name

* password : SMS Alert current Password

* senderid : Receiver will see this as sender's ID(for demo account use DEMOOO)


## Usage
### Change below variables in SMS Alert library:

  $user = "Smsalert username";  
  $pass = "Smsalert password";  
  $senderid = "Smsalert senderid";  

### Now, in your controller function, where you wish to send an SMS/text message, add below code:

   $this->load->library('smsalert/smsalertlib'); 
   
   $this->smsalertlib->smssend($MOBILENO, $TEXT);  
    
## Support 
  Email :  support@cozyvision.com  
  Phone :  080-1055-1055
