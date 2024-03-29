<?php
include_once ('log.php');
require_once ('includes/connection.php');

/**
 * wechat php test
 */
traceHttp ();
// define your token
define ( "TOKEN", "lumia123weixin" );
$wechatObj = new wechatCallbackapiTest ();
$wechatObj->valid ();
$wechatObj->responseMsg ();
class wechatCallbackapiTest {
	public function valid() {
		$echoStr = $_GET ["echostr"];
		logger ( "valid" );
		
		// valid signature , option
		if ($this->checkSignature ()) {
			echo $echoStr;
			// exit;
		}
	}
	public function responseMsg() {
		// get post data, May be due to the different environments
		$conn = dbConnect ( 'write', 'pdo' );
		$conn->query ( "SET NAMES 'utf8'" );
		$postStr = $GLOBALS ["HTTP_RAW_POST_DATA"];
		logger ( "post:" . $postStr );
		// extract post data
		if (! empty ( $postStr )) {
			/*
			 * libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
			 * the best way is to check the validity of xml by yourself
			 */
			libxml_disable_entity_loader ( true );
			$postObj = simplexml_load_string ( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );
			$fromUsername = $postObj->FromUserName;
			$toUsername = $postObj->ToUserName;
			$keyword = trim ( $postObj->Content );
			
			$MsgType = $postObj->MsgType;
			
			$time = time ();
			$textTpl = "<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[%s]]></MsgType>
			<Content><![CDATA[%s]]></Content>
			</xml>";
			
			// ################################################################################################################################################
			// ################################################################################################################################################
			// ############ first of all, check if this is an event, if it's an subscription event, do the necessary here #######################
			// ################################################################################################################################################
			// ################################################################################################################################################
			if ($MsgType == 'event') {
				$theevent = $postObj->Event;
				// ####################################################################################
				// ####################################################################################
				// #################################################################################### if the event is menu click, do the action here and fini
				// ####################################################################################
				// ####################################################################################
				if ($theevent == 'SCAN'){
					$sql_check_user = 'SELECT id, website_username, website_password FROM clients_list WHERE wechat_open_id = "' . $fromUsername . '"';
					$stmt_user = $conn->query ( $sql_check_user );
					$found_user = $stmt_user->rowCount ();
					if ($found_user) {
						foreach ( $stmt_user as $r_user ) {
							$theuserid = $r_user ['id'];
							$website_username = $r_user ['website_username'];
							$website_password = $r_user ['website_password'];
						}
							
						$contentStr = '您用来登录利美网站的用户名：' . $website_username . '  密码：' . $website_password;
					}
				}
				else if ($theevent == 'CLICK') {
					$thebutton = $postObj->EventKey;
					$msgType = "text";
					$contentStr = "系统升级中...请稍后";
					if ($thebutton == "KEY_BUDGET") {
						$contentStr = '1. 输入您的预算金额，比如 "5000 欧元" "5000 美金" “50000 人民币” “5000 英镑”（有无空格均可） 我们推荐适合此预算的钻石。如果不输入货币单位，那么默认为欧元。 2. 您的预算金额，用货币英文的首字母也可以 "5000 e", "5000 d", "50000 y", "5000 p" 大小写无所谓，有无空格均可。 euro dollar yuan pound.';
					} else if ($thebutton == "KEY_STOCK_REF") {
						$contentStr = '输入您预先得知的库存编号，我们返回此编号钻石的价格和详细信息给您。比如 54183419 如何得知库存编号？ 在我们官网的精品钻石栏目里（http://www.lumiagem.com ）可以查看所有的库存钻石，每颗钻石都有相应编号。如果你想了解相应钻石的价格和详细信息，则需要用库存编号来这个微信里查询。';
					} else if ($thebutton == "KEY_4CS") {
						$contentStr = '
1. 输入您要查找的钻石参数， 格式为“0.75 f vvs1 ex ex ex” 我们返回“0.75克拉， f色，vvs1净度 切工excellent 打磨excellent 对称 excellent”的钻石报价给您。输入大小写都可以的。 颜色：D~K; 净度： fl, if, vvs1, vvs2, vs1, vs2, si1, si2; 切工打磨对称： ex vg gd； 2. 如果钻石某项参数您都可以接受，可以用-代替 比如钻石的打磨用-代替即可。“1.20 g si2 vg - vg” 3. 证书：GIA HRD IGI 需要查证书的话加在最后, 如 “0.75 f vvs1 ex ex ex gia”';
					} else if ($thebutton == "KEY_FANCYSHAPE") {
						$contentStr = '异形钻查询：输入您要查找的钻石参数， 格式为“gz 0.75 f vvs1 ex ex” 我们返回“公主方 0.75克拉， f色，vvs1净度 打磨excellent 对称 excellent”的钻石。 注意异形钻只有对称和打磨没有切工的参数。 两字母用首字母拼音：公主方钻石gz、祖母绿形（长方）钻石zm、水滴形（梨形）钻石sd、心形钻xx、椭圆钻ty、橄榄形钻石gl、雷蒂恩形ld、枕形钻石zx';
					} else if ($thebutton == "KEY_JEWLERY") {
						$contentStr = '<a href="https://drive.google.com/folderview?id=0B1PdwXeXM9pXfm5CVHJTeThMUDQ1MEh6QkQ1QzZvUS0xNW56dkpPSDZyUVc3WFU0RzVQWDg&usp=sharing">点击查看精美首饰款式 所有的戒托有现货或者可以订制</a>';
					} else if ($thebutton == "KEY_QRCODE") {
						$content = array ();
						$sql_check_user = 'SELECT id,qrcode FROM clients_list WHERE wechat_open_id = "' . $fromUsername . '"';
						foreach ( $conn->query ( $sql_check_user ) as $r_u ) {
							;
						}
						if ($r_u ['qrcode']) {
							$content [] = array (
									"Title" => "动态二维码",
									"Description" => "您在利美钻石的专属动态二维码，可以发给您的朋友共享",
									"PicUrl" => "http://www.lumiagem.com/_admin/qrcode/" . $r_u ['id'] . "_200x200.jpg",
									"Url" => "http://www.lumiagem.com/_admin/qrcode/" . $r_u ['qrcode'] 
							);
							$result = $this->transmitNews ( $postObj, $content );
							echo $result;
							exit ();
						} else {
							$contentStr = '您尚未被分配动态二维码，请联系我们的客服：limeikefu，申请专属二维码。';
						}
					} else if ($thebutton == "KEY_PASSWEBACCOUNT") {
						$contentStr = '系统尚未找到您的用户名和密码';
						$sql_check_user = 'SELECT id, website_username, website_password FROM clients_list WHERE wechat_open_id = "' . $fromUsername . '"';
						$stmt_user = $conn->query ( $sql_check_user );
						$found_user = $stmt_user->rowCount ();
						
						if ($found_user) {
							foreach ( $stmt_user as $r_user ) {
								$theuserid = $r_user ['id'];
								$website_username = $r_user ['website_username'];
								$website_password = $r_user ['website_password'];
							}
							
							$contentStr = '您用来登录利美网站的用户名：' . $website_username . '  密码：' . $website_password;
						}
					}
					
					$resultStr = sprintf ( $textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr );
					echo $resultStr;
					exit ();
				}
				// ####################################################################################
				// ####################################################################################
				// ####################################################################################END MENU EVENT
				// ####################################################################################
				
				require_once ('includes/connection.php');
				$conn = dbConnect ( 'write', 'pdo' );
				$conn->query ( "SET NAMES 'utf8'" );
				
				$sql_check_user = 'SELECT id, wechat_name FROM clients_list WHERE wechat_open_id = "' . $fromUsername . '"';
				$stmt_user = $conn->query ( $sql_check_user );
				$found_user = $stmt_user->rowCount ();
				
				if ($found_user) {
					$sql = 'UPDATE clients_list SET suscribe_status = ? WHERE wechat_open_id = ?';
					$stmt = $conn->prepare ( $sql );
					$stmt->execute ( array (
							$theevent,
							$fromUsername 
					) );
					$OK = $stmt->rowCount ();
				} else {
					if ($theevent == 'subscribe') {
						$referee = substr ( $postObj->EventKey, 8 );
						logger ( "referee" . $referee );
						
						$addwords = '';
						
						$name = '-';
						$address = '-';
						$wechat_name = '-';
						$sex = '-';
						$address = '-';
						$suscribe_status = $theevent;
						$usericon = '';
						
						// here we get all the infos of the user
						require_once ('getaccesstoken.php');
						// $theaccesstoken
						// Get cURL resource
						$curl_ci = curl_init (); // client info
						                         // Set some options - we are passing in a useragent too here
						curl_setopt_array ( $curl_ci, array (
								CURLOPT_RETURNTRANSFER => 1,
								CURLOPT_URL => 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $theaccesstoken . '&openid=' . $fromUsername . '&lang=zh_CN',
								CURLOPT_USERAGENT => 'Codular Sample cURL Request' 
						) );
						// Send the request & save response to $resp
						$resp_ci = curl_exec ( $curl_ci );
						logger ( $CURLOPT_URL );
						logger ( $resp_ci );
						// Close request to clear up some resources
						curl_close ( $curl_ci );
						
						$obj_ci = json_decode ( $resp_ci );
						$wechat_name = $obj_ci->{'nickname'}; // 12345
						$sex = $obj_ci->{'sex'};
						$address001 = $obj_ci->{'city'};
						$address002 = $obj_ci->{'province'};
						$address002 = $obj_ci->{'country'};
						
						$address = $address001 . ', ' . $address002 . ', ' . $address003;
						
						$usericon = $obj_ci->{'headimgurl'};
						
						// ±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±
						
						$reference = 'FINAL-WECHAT';
						
						$website_username = '-';
						$website_password = '-';
						$feedbackwebpass = '';
						
						$sql = 'INSERT INTO clients_list (wechat_open_id, wechat_name, website_username, website_password, name, sex, reference, address, subscribed_time, suscribe_status, icon,referee) VALUES(:wechat_open_id, :wechat_name, :website_username, :website_password, :name, :sex, :reference, :address, NOW(), :suscribe_status, :icon,:referee)';
						$stmt = $conn->prepare ( $sql );
						
						$stmt->bindParam ( ':wechat_open_id', $fromUsername, PDO::PARAM_STR );
						$stmt->bindParam ( ':wechat_name', $wechat_name, PDO::PARAM_STR );
						$stmt->bindParam ( ':website_username', $website_username, PDO::PARAM_STR );
						$stmt->bindParam ( ':website_password', $website_password, PDO::PARAM_STR );
						$stmt->bindParam ( ':name', $name, PDO::PARAM_STR );
						$stmt->bindParam ( ':sex', $sex, PDO::PARAM_STR );
						$stmt->bindParam ( ':reference', $reference, PDO::PARAM_STR );
						$stmt->bindParam ( ':address', $address, PDO::PARAM_STR );
						$stmt->bindParam ( ':suscribe_status', $suscribe_status, PDO::PARAM_STR );
						$stmt->bindParam ( ':icon', $usericon, PDO::PARAM_STR );
						$stmt->bindParam ( ':referee', $referee, PDO::PARAM_STR );
						
						$stmt->execute ();
						$OK = $stmt->rowCount ();
						logger ( "inert result:" . $OK );
						if ($OK) {
							$thelastinsertedid = $conn->lastInsertId ();
							$website_username = 'lm' . $thelastinsertedid;
							
							// generate a random string
							$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
							$charactersLength = strlen ( $characters );
							$randomString = '';
							for($i = 0; $i < 3; $i ++) {
								$randomString .= $characters [rand ( 0, $charactersLength - 1 )];
							}
							$website_password = $randomString . $thelastinsertedid;
							
							$sql_update_webpass = 'UPDATE clients_list SET website_username = "' . $website_username . '", website_password ="' . $website_password . '" WHERE wechat_open_id = "' . $fromUsername . '"';
							$stmt_sql_webpass = $conn->query ( $sql_update_webpass );
							if ($stmt_sql_webpass->rowCount ()) {
								$feedbackwebpass = ' 您用来登录利美网站的用户名：' . $website_username . '  密码：' . $website_password . ' 您可以登录以后自己进行修改。您也可以加我们的微信客服：limeikefu, 有客服随时解答您的问题。';
							}
						} else {
							logger ( $sql . "\n" . mysql_errno () . ": " . mysql_error () . "\n" );
						}
						
						$msgType = "text";
						$contentStr = "感谢您关注比利时利美珠宝首饰公司!" . $feedbackwebpass;
						if($referee=='1118')
							$contentStr = $contentStr." \n您已扫描成功，获得Lumia利美钻石提供的150欧电子优惠卷，本次电子优惠扫码活动有效期截止到2月1日。持有效电子优惠卷的朋友可在2017年7月28日前购买Lumia指定产品，0.7克拉到0.79克拉时出示此优惠卷，即可享受立减优惠。";
						$resultStr = sprintf ( $textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr );
						echo $resultStr;
					}
				}
				
				exit ();
			}
			// ################################################################################################################################################
			// ################################################################################################################################################
			// ############ END --- first of all, check if this is an event, if it's an subscription event, do the necessary here --- END #######################
			// ################################################################################################################################################
			// ################################################################################################################################################
			
			// ################################################################################################################################################
			// ################################################################################################################################################
			// ######################### second of all, if it's not an event, save the message to the database message table ##################################
			// ################################################################################################################################################
			// ################################################################################################################################################
			
			// #####################################################
			require_once ('includes/connection.php'); //
			$conn = dbConnect ( 'write', 'pdo' ); // database connected here
			$conn->query ( "SET NAMES 'utf8'" ); //
			                                     // #####################################################
			
			$keywordisTXT = false;
			if ($MsgType == 'text') {
				$keywordisTXT = true;
				$keyword = trim ( $postObj->Content );
			} else if ($MsgType == 'image') {
				$keyword = trim ( $postObj->PicUrl );
				$MediaId = $postObj->MediaId;
			} else if ($MsgType == 'voice') {
				$keyword = 'voice & video';
				$MediaId = $postObj->MediaId;
				$Format = $postObj->Format;
			} else if ($MsgType == 'video') {
				$keyword = 'voice & video';
				$MediaId = $postObj->MediaId;
				$Format = $postObj->Format;
				$ThumbMediaId = $postObj->ThumbMediaId;
			} else if ($MsgType == 'location') {
				$keyword = 'location';
				$Location_X = $postObj->Location_X;
				$Location_Y = $postObj->Location_Y;
				$Label = $postObj->Label;
			} else if ($MsgType == 'link') {
				$keyword = 'Url';
				$Title = $postObj->Title;
				$Description = $postObj->Description;
			}
			
			// #################################################################################
			// --------------------------------------------------------------------------------#
			// ----- 1 check if the user is already in the database, if not, put it in---------#
			// --------------------------------------------------------------------------------#
			// --------------------------------------------------------------------------------#
			// --------------------------------------------------------------------------------#
			// #################################################################################
			$sql_check_user = 'SELECT id, wechat_name FROM clients_list WHERE wechat_open_id = "' . $fromUsername . '"';
			$stmt_user = $conn->query ( $sql_check_user );
			$found_user = $stmt_user->rowCount ();
			
			if ($found_user) {
				foreach ( $stmt_user as $row_user ) {
					$clientID = $row_user ['id'];
					$wechat_name = $row_user ['wechat_name'];
				}
				// if($wechat_name=='-' || $wechat_name==''){
				$needtoUpdate = true;
				// }
			}
			/* */
			
			// --------------------------------------------------------------------------------#
			// ------ 1.1 now put the user who is not in the db but send message --------------#
			// --------------------------------------------------------------------------------#
			// -------- also update the subscribe/unsubscribe status -------------------------#
			// --------------------------------------------------------------------------------#
			if (! $found_user || (isset ( $needtoUpdate ) && $needtoUpdate == true)) {
				
				$name = '-';
				
				$address = '-';
				// $suscribe_status=$postObj->Event;
				$wechat_name = '-'; // 12345
				$sex = '-';
				$address = '-';
				if (isset ( $theevent )) {
					$suscribe_status = $theevent;
				} else {
					$suscribe_status = 'subscribe';
				}
				$usericon = '';
				
				// here we get all the infos of the user
				require_once ('getaccesstoken.php');
				// $theaccesstoken
				// Get cURL resource
				$curl_ci = curl_init (); // client info
				                         // Set some options - we are passing in a useragent too here
				curl_setopt_array ( $curl_ci, array (
						CURLOPT_RETURNTRANSFER => 1,
						CURLOPT_URL => 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $theaccesstoken . '&openid=' . $fromUsername . '&lang=zh_CN',
						CURLOPT_USERAGENT => 'Codular Sample cURL Request' 
				) );
				// Send the request & save response to $resp
				$resp_ci = curl_exec ( $curl_ci );
				logger ( "get wechat user info:" . $resp_ci );
				// Close request to clear up some resources
				curl_close ( $curl_ci );
				
				$obj_ci = json_decode ( $resp_ci );
				$wechat_name = $obj_ci->{'nickname'}; // 12345
				$sex = $obj_ci->{'sex'};
				$address001 = $obj_ci->{'city'};
				$address002 = $obj_ci->{'province'};
				$address002 = $obj_ci->{'country'};
				
				$address = $address001 . ', ' . $address002 . ', ' . $address003;
				
				$usericon = $obj_ci->{'headimgurl'};
				
				// ±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±±
				
				$reference = 'FINAL-WECHAT';
				if (! $found_user) {
					$sql = 'INSERT INTO clients_list (wechat_open_id, wechat_name, name, sex, reference, address, subscribed_time, suscribe_status, icon) VALUES(:wechat_open_id, :wechat_name, :name, :sex, :reference, :address, NOW(), :suscribe_status, :icon)';
					$stmt = $conn->prepare ( $sql );
					
					$stmt->bindParam ( ':wechat_open_id', $fromUsername, PDO::PARAM_STR );
					$stmt->bindParam ( ':wechat_name', $wechat_name, PDO::PARAM_STR );
					$stmt->bindParam ( ':name', $name, PDO::PARAM_STR );
					$stmt->bindParam ( ':sex', $sex, PDO::PARAM_STR );
					$stmt->bindParam ( ':reference', $reference, PDO::PARAM_STR );
					$stmt->bindParam ( ':address', $address, PDO::PARAM_STR );
					$stmt->bindParam ( ':suscribe_status', $suscribe_status, PDO::PARAM_STR );
					$stmt->bindParam ( ':icon', $usericon, PDO::PARAM_STR );
					
					$stmt->execute ();
					$OK = $stmt->rowCount ();
				} else {
					
					$sql = 'UPDATE clients_list SET wechat_name = ?, sex = ?, address = ?, icon = ? WHERE wechat_open_id = ?'; // $fromUsername
					logger ( " update wechat_name:" . $wechat_name );
					$stmt = $conn->prepare ( $sql );
					$stmt->execute ( array (
							$wechat_name,
							$sex,
							$address,
							$usericon,
							$fromUsername 
					) );
					$OK = $stmt->rowCount ();
				}
			}
			// #################################################################################
			// --------------------------------------------------------------------------------#
			// ----- 2 save the user message to the database ----------------------------------#
			// --------------------------------------------------------------------------------#
			// --------------------------------------------------------------------------------#
			// --------------------------------------------------------------------------------#
			// #################################################################################
			if (isset ( $keyword )) {
				$MsgId = $postObj->MsgId;
				if (! isset ( $MediaId )) {
					$MediaId = '-';
				}
				if (! isset ( $Format )) {
					$Format = '-';
				}
				if (! isset ( $ThumbMediaId )) {
					$ThumbMediaId = '-';
				}
				if (! isset ( $Location_X )) {
					$Location_X = '-';
				}
				if (! isset ( $Location_Y )) {
					$Location_Y = '-';
				}
				if (! isset ( $Label )) {
					$Label = '-';
				}
				if (! isset ( $Title )) {
					$Title = '-';
				}
				if (! isset ( $Description )) {
					$Description = '-';
				}
				
				$if_wechat = 'NEW';
				
				// #############################################################
				// #############################################################
				// ######### 第一次发信息将收到 利美客服消息
				// #############################################################
				// #############################################################
				/*
				 * $sql_check='SELECT * FROM wechat_record WHERE wechat_open_id = "'.$fromUsername.'"';
				 * $stmt_search=$conn->query($sql_check);
				 * $found_record=$stmt_search->rowCount();
				 * if(!$found_record){
				 * $msgType = "text";
				 * $contentStr = "感谢您关注比利时利美珠宝公司，利美钻石是我司专营比利时优质钻石的品牌。由于微信公众号现阶段只能在电脑上回复信息，没有移动回复功能。所以为了在第一时间回复您的信息，我们特意开通了手机客服微信号limeikefu，欢迎您加入。直接在添加朋友中输入limeikefu即可添加。";
				 * $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
				 * echo $resultStr;
				 * }
				 */
				// #############################################################
				// #############################################################
				// ######### END 第一次发信息将收到 利美客服消息 END
				// #############################################################
				// #############################################################
				
				if (! isset ( $clientID )) {
					$sql_id = 'SELECT id FROM clients_list WHERE wechat_open_id = "' . $fromUsername . '"';
					foreach ( $conn->query ( $sql_id ) as $row_id ) {
						$clientID = $row_id ['id'];
					}
				}
				
				$sql = 'INSERT INTO wechat_record (client_id, wechat_open_id, wechat_name, message, CreateTime, MsgType, MsgId, MediaId, Format, ThumbMediaId, Location_X, Location_Y, Label, Title, Description, if_wechat) VALUES(:client_id, :wechat_open_id, :wechat_name, :message, NOW(), :MsgType, :MsgId, :MediaId, :Format, :ThumbMediaId, :Location_X, :Location_Y, :Label, :Title, :Description, :if_wechat)';
				$stmt = $conn->prepare ( $sql );
				
				$stmt->bindParam ( ':client_id', $clientID, PDO::PARAM_STR );
				$stmt->bindParam ( ':wechat_open_id', $fromUsername, PDO::PARAM_STR );
				$stmt->bindParam ( ':wechat_name', $wechat_name, PDO::PARAM_STR );
				$stmt->bindParam ( ':message', $keyword, PDO::PARAM_STR );
				$stmt->bindParam ( ':MsgType', $MsgType, PDO::PARAM_STR );
				$stmt->bindParam ( ':MsgId', $MsgId, PDO::PARAM_STR );
				$stmt->bindParam ( ':MediaId', $MediaId, PDO::PARAM_STR );
				$stmt->bindParam ( ':Format', $Format, PDO::PARAM_STR );
				$stmt->bindParam ( ':ThumbMediaId', $ThumbMediaId, PDO::PARAM_STR );
				$stmt->bindParam ( ':Location_X', $Location_X, PDO::PARAM_STR );
				$stmt->bindParam ( ':Location_Y', $Location_Y, PDO::PARAM_STR );
				$stmt->bindParam ( ':Label', $Label, PDO::PARAM_STR );
				$stmt->bindParam ( ':Title', $Title, PDO::PARAM_STR );
				$stmt->bindParam ( ':Description', $Description, PDO::PARAM_STR );
				$stmt->bindParam ( ':if_wechat', $if_wechat, PDO::PARAM_STR );
				
				$stmt->execute ();
				$OK = $stmt->rowCount ();
			}
			
			/*
			 * $msgType = "text";
			 * $contentStr = "Welcome to wechat world! 123 - ".$keyword;
			 * $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
			 * echo $resultStr;
			 */
			// ################################################################################################################################################
			// ################################################################################################################################################
			// ################# END second of all, if it's not an event, save the message to the database message table END ##################################
			// ################################################################################################################################################
			// ################################################################################################################################################
			
			if ($keywordisTXT) {
				
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ############################################ important step!!! auto reply !!!!!!!!! #######################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ############################################ real actions starts here ######################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				
				$urltopost = 'http://happyeurope.eu/autoreply.php';
				
				// $messageToPost=iconv('UTF-16', 'UTF-8', $crr_message);
				// $trans_sentence = iconv('UTF-8', 'ASCII//TRANSLIT', $utf8_sentence);
				// $data = array("touser" => $wechatopenidofuser, "msgtype" => "text", "text" => array("content"=>$crr_message));
				$data = '{
							"user_open_id":"' . $fromUsername . '",

							"content":"' . $keyword . '"

								 }';
				
				// $data_string = json_encode($data);
				
				$ch = curl_init ( $urltopost );
				curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
				curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
				curl_setopt ( $ch, CURLOPT_POST, 1 );
				curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
				curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
				$msgType = "text";
				$result = curl_exec ( $ch );
				$resultStr = sprintf ( $textTpl, $fromUsername, $toUsername, $time, $msgType, $result );
				logger ( $resultStr );
				echo $resultStr;
				exit ();
				
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ########################################## that were the real actions ######################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
				// ###########################################################################################################################
			} else {
				echo "Input something...";
			}
		} else {
			echo "";
			exit ();
		}
	}
	private function checkSignature() {
		// you must define TOKEN by yourself
		if (! defined ( "TOKEN" )) {
			throw new Exception ( 'TOKEN is not defined!' );
		}
		
		$signature = $_GET ["signature"];
		$timestamp = $_GET ["timestamp"];
		$nonce = $_GET ["nonce"];
		
		$token = TOKEN;
		$tmpArr = array (
				$token,
				$timestamp,
				$nonce 
		);
		// use SORT_STRING rule
		sort ( $tmpArr, SORT_STRING );
		$tmpStr = implode ( $tmpArr );
		$tmpStr = sha1 ( $tmpStr );
		
		if ($tmpStr == $signature) {
			return true;
		} else {
			return false;
		}
	}
	// 回复图文消息
	private function transmitNews($object, $newsArray) {
		if (! is_array ( $newsArray )) {
			return "";
		}
		$itemTpl = "        <item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
        </item>
";
		$item_str = "";
		foreach ( $newsArray as $item ) {
			$item_str .= sprintf ( $itemTpl, $item ['Title'], $item ['Description'], $item ['PicUrl'], $item ['Url'] );
		}
		$xmlTpl = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[news]]></MsgType>
		<ArticleCount>%s</ArticleCount>
		<Articles>
		$item_str    </Articles>
		</xml>";
		
		$result = sprintf ( $xmlTpl, $object->FromUserName, $object->ToUserName, time (), count ( $newsArray ) );
		return $result;
	}
}

?>
