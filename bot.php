<?php  



	include('DB.php');

	$access_token = "EAARV2tvxESUBAOHG0Ixv4kJQx1pCRHaz1FQuJiEOeABvYCBmxSvg7P8xfuX1u3gXeZAnlqxGoJxj15CYpTkUWH24CK61eIo71ZAQwcTSV058WAicu21SbdVYn95cyXZBZCZBtKGcsw3A9zevz0GPXrFjGT3k6u5AvegL6b7DRMwZDZD";
	
	$challenge = $_REQUEST['hub_challenge'];
	$token = $_REQUEST['hub_verify_token'];
	$msgs = null;
	$reply = " No";

	
		
	if($token == 'abc123'){
		echo $challenge;
	}

	$db = new DB;
	$input = json_decode(file_get_contents('php://input'),true);

	$userId = $input['entry'][0]['messaging'][0]['sender']['id'];

	$message = $input['entry'][0]['messaging'][0]['message']['text'];
	$message = strtolower($message);
	$messagingArray = $input['entry'][0]['messaging'][0];
	//get started button
	if(isset($messagingArray['postback']))
	{
		if($messagingArray['postback']['payload'] == 'first hand shake')
		{

			$reply = "Hi I am Result-Bot . I help you to find results!! :)";
			
		}
	}



	//stop word removal	

	$stop_words = array("to","an","the","is","are","i","been","my","me");
	
	$msg = explode(' ', $message);
	
	for($i=0;$i<count($stop_words);$i++)
	{
		for($j=0;$j<count($msg);$j++)
		{

			
			if($msg[$j]==$stop_words[$i])
			{
				
				unset($msg[$j]);
				$msg = array_values($msg);

			}

		}
		
	}
	
//greetings
	$greetings = array("hi","hello","hey","hey there");
	$greet = array(
		"Hello there !! ",
		"Hiya",
		"Hey there",
		"Hello",
		"Hi",
		);

	for($i=0;$i<count($msg);$i++)
	{
		for($j=0;$j<count($greetings);$j++)
		{

			
			if($msg[$i]==$greetings[$j])
			{
				
				
				
				$reply = $greet[array_rand($greet)];
			}

		}
		
	}

	
	//results

	$question = array("where","how","when","has","can","is",null);
	$sub = array("know","have","want","give",null);
	$subs = array("publish",null);

	for($a=0;$a<count($msg);$a++)
	{
		if($msg[$a]=="results"||$msg[$a]=="res")
		{

			$msg[$a]="result";
		}

		if($msg[$a]=="published")
		{

			$msg[$a]="publish";
		}
	
	}
	
		for($i=0;$i<count($question);$i++)
		{
			for($j=0;$j<count($sub);$j++)
				{

				for($k=0;$k<count($subs);$k++)
					{


						$mesg = implode($msg);
						var_dump($mesg);
						
						
						

					if($mesg==$question[$i].$sub[$j]."result".$subs[$k])
					{
						
					$reply = ' {
								  "recipient":{
								    "id":"'.$userId.'"
								  },
								  "message":{
								    "text":"Please choose a Semester:",
								    "quick_replies":[
								      {
								        "content_type":"text",
								        "title":"1st Semester",
								        "payload":"semster"
								      },
								      {
								        "content_type":"text",
								        "title":"2nd Semester",
								        "payload":"semster"
								      },
								      {
								        "content_type":"text",
								        "title":"3rd Semester",
								        "payload":"semster"
								      },
								      {
								        "content_type":"text",
								        "title":"4th Semester",
								        "payload":"semster"
								      },
								      {
								        "content_type":"text",
								        "title":"5th Semester",
								        "payload":"semster"
								      },
								      {
								        "content_type":"text",
								        "title":"6th Semester",
								        "payload":"semster"
								      },
								      {
								        "content_type":"text",
								        "title":"7th Semester",
								        "payload":"semster"
								      },
								      {
								        "content_type":"text",
								        "title":"8th Semester",
								        "payload":"semster"
								      },
								      {
								        "content_type":"text",
								        "title":"8th Semester",
								        "payload":"semster"
								      }

								    ]
								  }
								}' ;
								sendMessage($reply);
							
					}
				}
			}
		}
		
	

	
	//semester select
	$me = $input['entry'][0]['messaging'][0]['message']['quick_reply'];
	if(isset($me))
	{
		if($me['payload'] == 'semster')
		{

			$reply = "Roll number please";
			
		}
	}


	//roll number only

		$mesg = implode($msg);
		if(preg_match('/(.*?)[0-9](.*?)/', $mesg))
		{
			preg_match_all('!\d+!', $mesg, $matches);
			$r=(int)$matches[0];

			$reply = $db->result($r);
		}
		

	// var_dump($message);
	


	


	   


	$negative = array("need not","dont");

	
	


	

	//processing
	
	 $url = 'https://graph.facebook.com/v2.8/me/messages?access_token='.$access_token;

	$json_data  = "{
		'recipient':{
			'id':'$userId'
		},
		'message':{
			'text':'$reply'
		}

		}";

		
	
		function sendMessage($rawResponse)
		{
			 $url = 'https://graph.facebook.com/v2.8/me/messages?access_token=EAARV2tvxESUBAOHG0Ixv4kJQx1pCRHaz1FQuJiEOeABvYCBmxSvg7P8xfuX1u3gXeZAnlqxGoJxj15CYpTkUWH24CK61eIo71ZAQwcTSV058WAicu21SbdVYn95cyXZBZCZBtKGcsw3A9zevz0GPXrFjGT3k6u5AvegL6b7DRMwZDZD';

			$ch = curl_init($url);

			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$rawResponse);
			curl_setopt($ch, CURLOPT_HTTPHEADER,['content-type:application/json']);
			
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_exec($ch);
		}



	$ch = curl_init($url);

	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$json_data);
	curl_setopt($ch, CURLOPT_HTTPHEADER,['content-type:application/json']);
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	if(!empty($input['entry'][0]['messaging'][0]['message']||!empty($messagingArray['postback'])))
	{
		curl_exec($ch);
	}

     

	