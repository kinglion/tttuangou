<?php
class_exists('LogWriter') or require(dirname(__FILE__).'/LogWriter.php');
class_exists('MerchantConfig') or require(dirname(__FILE__).'/MerchantConfig.php');
interface_exists('ITagName') or require(dirname(__FILE__).'/ITagName.php');
//interface_exists('IChannelType') or require(dirname(__FILE__).'/IChannelType.php');
//interface_exists('IBusinessID') or require(dirname(__FILE__).'/IBusinessID.php');
//interface_exists('IFunctionID') or require(dirname(__FILE__).'/IFunctionID.php');
//interface_exists('ILength') or require(dirname(__FILE__).'/ILength.php');
//interface_exists('IMarketLength') or require(dirname(__FILE__).'/IMarketLength.php');
//interface_exists('IVersion') or require(dirname(__FILE__).'/IVersion.php');
class_exists('XMLDocument') or require(dirname(__FILE__).'/XMLDocument.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/DataVerifier.php');

abstract class TrxRequest
{
	//电子商务商户类型 - B2C商户
	const EC_MERCHANT_TYPE_B2C='B2C';
	
	//电子商务商户类型 - B2B商户
	const EC_MERCHANT_TYPE_B2B='B2B';
	
	//商户日志
    private $iLogWriter = null;
    
    //genSignature方法中的签名后的报文
    private $tRequestMesg='';
    
    //商户类型
    protected $iECMerchantType='';
    
    //商户备注信息，可选
    protected $iMerchantRemarks = '';
    
    public function getMerchantRemarks() {
    	return $this->iMerchantRemarks;
    }   
    public function setMerchantRemarks($iMerchantRemarks) {
    	$this->iMerchantRemarks = $iMerchantRemarks;
    }
    
	/**
     * Class TrxRequest 构造函数
	 * @param aECMerchantType 商户类型 值为$this->iBusinessID = IBusinessID::B2C子类中实现
     */
	public function  __construct($aECMerchantType)
	{
		$this->$iECMerchantType =$aECMerchantType;
	}
	

	
	
    public function postRequest()
    {
        return $this->extendPostRequest(1);
    }
    
    public function extendPostRequest($aMerchantNo)
    {
        $tTrxResponse = null;
        try
        {
            $this->iLogWriter = new LogWriter();
            $this->iLogWriter->logNewLine("TrustPay Client PHP 交易开始==========================");
            //0、检查传入参数是否合法
            $this->iLogWriter->logNewLine( '配置文件中商户数为'.MerchantConfig::getMerchantNum().'请求指定的商户配置编号为 '.$aMerchantNo);
            if(($aMerchantNo <= 0) || ($aMerchantNo > MerchantConfig::getMerchantNum()))
            {
                throw new TrxException(TrxException::TRX_EXC_CODE_1008, TrxException::TRX_EXC_MSG_1008, 
                    '配置文件中商户数为'.MerchantConfig::getMerchantNum().", 但是请求指定的商户配置编号为$aMerchantNo ！");
            }
            //1、检查交易请求是否合法
            $this->iLogWriter->logNewLine('检查交易请求是否合法：');
            $this->checkRequest();
            $this->iLogWriter->logs('正确');
            //2、取得交易报文
            $this->iLogWriter->LogNewLine('交易报文');
            $tRequestMessage = $this->getRequestMessage();

            //3、组成完整交易报文
			$this->iLogWriter->logNewLine('完整交易报文：');
			$tRequestMessage = $this->composeRequestMessage($aMerchantNo,$tRequestMessage);
			//$this->iLogWriter->logNewLine(trim($tRequestMessage));

            //4、对交易报文进行签名
            $this->iLogWriter->logNewLine('签名后的报文');
            $tRequestMessage = MerchantConfig::signMessage($aMerchantNo, $tRequestMessage);
            //5、发送交易报文至网上支付平台
            $tResponseMessage = $this->sendMessage($tRequestMessage);
			$this->iLogWriter->logNewLine('接收报文：');
			$this->iLogWriter->logNewLine($tResponseMessage);

            //6、验证网上支付平台响应报文的签名
            $this->iLogWriter->logNewLine('验证网上支付平台响应报文的签名：');
            $tResponseMessage = MerchantConfig::verifySign($tResponseMessage);
            $this->iLogWriter->logs('正确');
            //7、生成交易响应对象
            $this->iLogWriter->logNewLine('生成交易响应对象：');
            $tTrxResponse = $this->constructResponse($tResponseMessage);
           /*for debug
            echo "**".$tTrxResponse."**";
            $this->iLogWriter->logNewLine($tTrxResponse);
            $this->iLogWriter->logNewLine("交易结束==================================================\n\n\n\n");
            $this->iLogWriter->closeWriter(MerchantConfig::getTrxLogFile());
        	*/
            $this->iLogWriter->logNewLine('交易结果：['.$tTrxResponse->getReturnCode().']');
            $this->iLogWriter->logNewLine('错误信息：['.$tTrxResponse->getErrorMessage().']');

        }
        catch (TrxException $e)
        {
            $tTrxResponse = new TrxResponse();
            $tTrxResponse->initWithCodeMsg($e->getCode(), $e->getMessage()." - ".$e->getDetailMessage());
            if($this->iLogWriter != null)
            {
                $this->iLogWriter->logNewLine('错误代码：[' + $tTrxResponse->getReturnCode().']    错误信息：['.
                    $tTrxResponse->getErrorMessage().']');
            }
        }
        catch (Exception $e)
        {
            $tTrxResponse = new TrxResponse();
            $tTrxResponse->initWithCodeMsg(TrxException::TRX_EXC_CODE_1999, TrxException::TRX_EXC_MSG_1999.
                ' - '.$e->getMessage());
            if ($this->iLogWriter != null)
            {
                $this->iLogWriter->logNewLine('错误代码：['.$tTrxResponse->getReturnCode().']    错误信息：['.
                    $tTrxResponse->getErrorMessage().']');
            }
        }

        if ($this->iLogWriter != null)
        {
            $this->iLogWriter->logNewLine("交易结束==================================================\n\n\n\n");
            $this->iLogWriter->closeWriter(MerchantConfig::getTrxLogFile());
        }

        return $tTrxResponse;

    }

    /**
     * 组成完整交易报文
     * @param aMerchantNo 商户号
     * @param aMessage 交易报文
     * @return 完整交易报文
     */
    private function composeRequestMessage($aMerchantNo,$aMessage)
    {
    	$str='<Merchant>'.
    			'<ECMerchantType>'.$this->iECMerchantType.'</ECMerchantType>'.
    			'<MerchantID>'.MerchantConfig::getMerchantID($aMerchantNo).'</MerchantID>'.
    			'</Merchant>'.
    			trim($aMessage);
    	return $str;
    }

    /// 发送交易报文至网上支付平台
    private function sendMessage($aMessage)
    {
        //1、组成<MSG>段 
        $tMessage = '<MSG>'.$aMessage.'</MSG>';
       // $tMessage=$aMessage;
        $this->iLogWriter->logNewLine("提交网上支付平台的报文：\n$tMessage");
	    //2、取得报文长度
	    $tContentLength = count(DataVerifier::stringToByteArrayUTF8($tMessage));
	    $this->iLogWriter->LogNewLine('报文长度：'.$tContentLength."<br>");
	   // echo strlen($tMessage)."<br>";
	    if($tContentLength>8000)
	    {
	    	throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'报文长度超过8000Bytes');
	    }
        //3、生成URL连接网上支付平台
	    //生成url
        $tURL = MerchantConfig::getTrustPayConnectMethod().'://'.MerchantConfig::getTrustPayServerName();
        if((MerchantConfig::getTrustPayConnectMethod() == 'https' && (MerchantConfig::getTrustPayServerPort() != 443)) ||
           (MerchantConfig::getTrustPayConnectMethod() == 'http' && (MerchantConfig::getTrustPayServerPort() !=  80)))
        {
            $tURL .= ':'.strval(MerchantConfig::getTrustPayServerPort());
        }
        $tURL .= MerchantConfig::getTrustPayTrxURL();
        $this->iLogWriter->logNewLine("连线网上支付平台");
        $this->iLogWriter->logNewLine("网上支付平台URL：[$tURL] ");
        $this->iLogWriter->logNewLine("成功");
        //生成报文 没有base64加密
       // $tMessage = base64_encode(gzencode($tMessage));
       //提交交易报文
        $this->iLogWriter->logNewLine('提交交易报文：');
        $this->iLogWriter->logNewLine($tMessage);  
        $tResponseMessage='';
       
        if(MerchantConfig::getTrustPayConnectMethod() == 'https')
        {
        //组织http头和报文,添加HTTP/1.1
        $jwstr = 'POST '.MerchantConfig::getTrustPayTrxURL().' HTTP/1.1'.MerchantConfig::getTrustPayNewLine()
        		.'User-Agent: trustpayclientPHP'.MerchantConfig::getTrustPayNewLine()
        		.'Host: '.MerchantConfig::getTrustPayServerName().MerchantConfig::getTrustPayNewLine()
        		.'Accept: text/html, image/gif, image/jpeg, *; q=.2, * /*; q=.2'.MerchantConfig::getTrustPayNewLine()
        		.'Connection: keep-alive'.MerchantConfig::getTrustPayNewLine()
        		.'Content-Type: application/x-www-form-urlencoded'.MerchantConfig::getTrustPayNewLine()
        		.'Content-Length: '.$tContentLength.MerchantConfig::getTrustPayNewLine()
        		.MerchantConfig::getTrustPayNewLine()
        		.$tMessage; 
        //socket
	         try {
		         	$fsocket=fsockopen('tls://'.MerchantConfig::getTrustPayServerName(),MerchantConfig::getTrustPayServerPort());
				    fwrite($fsocket, iconv("GB2312","UTF-8",$jwstr));	
		        	//$tResponseMessage=fread($fsocket, 8192);
			    	$tLine=null;
			    	while (($tLine=fgets($fsocket))!=null)
			    	{
			    		$tResponseMessage.=$tLine;
			    		if(strpos($tLine, '</MSG>')!=false)
			    			break;
			    		if($tLine==null)
			    		break;
			    	}
				    fclose($fsocket); 
	        }
	        catch (Exception $e)
	        {
	        	throw new TrxException(TrxException::TRX_EXC_CODE_1202, TrxException::TRX_EXC_MSG_1202,'提交交易时发生网络错误');
	        	fclose($fsocket); 
	        }
			 
        }
        elseif (MerchantConfig::getTrustPayConnectMethod() == 'http')
        {
        	//构造context
	        $ctx = array('http' =>
					        		array(
					                'method' => 'POST ',
					                'header'  => "User-agent: TrustPayClient PHP"."\r\n".
					        					 "Host: ".MerchantConfig::getTrustPayServerName()."\r\n".
					        					 "Accept: text/html, image/gif, image/jpeg, *; q=.2, * /*; q=.2 "."\r\n".
					        					 "Connection: keep-alive\r\n".
					               				 "Content-Type: application/x-www-form-urlencoded"."\r\n",	
					                'content' => iconv("GB2312","UTF-8",$tMessage)
					        		)	
	        );
	        if(MerchantConfig::getParameterByName("ProxyIP", FALSE))
	        {
	            $ctx['https']['proxy'] = 'http://'.MerchantConfig::getParameterByName('ProxyIP').
	                ':'.strval(MerchantConfig::getParameterByName('ProxyPort'));
	        }
	        //提交报文，获取响应
	        $tResponseMessage = file_get_contents($tURL, FALSE, stream_context_create($ctx));
        }
        if(!$tResponseMessage)
        {
            throw new TrxException(TrxException::TRX_EXC_CODE_1202, TrxException::TRX_EXC_MSG_1202);
        }
        $this->iLogWriter->logNewLine("成功");
        //$this->iLogWriter->logNewLine('返回报文：');
        //$this->iLogWriter->logs("\n$tResponseMessage");
        //$tResponseMessage = gzdecode(base64_decode($tResponseMessage));
        $this->iLogWriter->logNewLine('接受到的响应报文：');
        $this->iLogWriter->logs("\n$tResponseMessage");
        $doc = new XMLDocument($tResponseMessage);
        $tTrxResponse = $doc->getValue("MSG");
        if(!$tTrxResponse)
        {
            throw new TrxException(TrxException::TRX_EXC_CODE_1205, TrxException::TRX_EXC_MSG_1205, '无[MSG]段！');
        }
        return $tTrxResponse;

    }
    
    /**
     * 产生带签名的报文函数，商户通过页面传参数访问农行b2c服务时调用该函数。
     * @return 签名后的报文
     */
    public function genSignature($i)
    {
    	
    	$this->iLogWriter=new LogWriter();
    	$this->iLogWriter->logNewLine('TrustPay Client PHP 交易开始==========================');
    	
    	//1、检查交易请求是否合法
    	$this->iLogWriter->logNewLine('检查交易请求是否合法：');
    	$this->checkRequest();
    	$this->iLogWriter->logNewLine('正确');
    	//2、取得交易报文
    	$this->iLogWriter->logNewLine('交易报文：');
    	$tRequestMessage=$this->getRequestMessage();
    	$this->iLogWriter->logNewLine($tRequestMessage);
    	//3、组成完整交易报文
    	$this->iLogWriter->logNewLine('完整交易报文：');
    	$tRequestMessage=$this->composeRequestMessage($i, $tRequestMessage);
    	$this->iLogWriter->logNewLine($tRequestMessage);
    	//4、对交易报文进行签名
    	$this->iLogWriter->logNewLine('签名后的报文：');
    	$tRequestMessage=MerchantConfig::signMessage($i, $tRequestMessage);
    	$tRequestMessage='<MSG>'.
      					 $tRequestMessage.
      					 '</MSG>';
    	$tRequestMesg=$tRequestMessage;
    	$this->iLogWriter->logNewLine('提交网上支付平台的报文：'.$tRequestMessage);
    	if ($this->iLogWriter != null)
        {
            $this->iLogWriter->logNewLine("交易结束==================================================\n\n\n\n");
            $this->iLogWriter->closeWriter(MerchantConfig::getTrxLogFile());
        }
    	return $tRequestMesg;
    }
    /**
     * 发送交易至网上支付平台，并接收网上支付平台的交易回应。
     * @return 交易结果对象
     */
    public function extendPostCBPRequest($i,$TrustPayCBPTrxURL)
    {
    	try 
    	{
    	$this->iLogWriter=new LogWriter();
    	$this->iLogWriter->logNewLine('TrustPay Client PHP 交易开始==========================');
    	//1、检查交易请求是否合法
    	$this->iLogWriter->logNewLine('CBP检查交易请求是否合法：');
    	$this->checkRequest();
    	$this->iLogWriter->logNewLine('正确');
    	//2、取得交易报文
    	$this->iLogWriter->logNewLine('CBP交易报文：');
    	$tRequestMessage=$this->getRequestMessage();
    	//3、组成完整交易报文
    	$this->iLogWriter->logNewLine('CBP完整交易报文：');
    	$tRequestMessage=$this->composeRequestMessage($i, $tRequestMessage);
    	//4、对交易报文进行签名
    	$this->iLogWriter->logNewLine('CBP签名后的报文：');
    	$tRequestMessage=MerchantConfig::signMessage($i, $tRequestMessage);
    	//5、发送交易报文至网上支付平台
    	$this->iLogWriter->logNewLine('CBP发送交易报文至网上支付平台：');
    	$tResponseMessage=$this->sendMessage($tRequestMessage,$TrustPayCBPTrxURL);
    	/*
    	 //6、验证网上支付平台响应报文的签名
            iLogWriter.logNewLine("验证网上支付平台响应报文的签名：");
            tResponseMessage = tMerchantConfig.verifySign(tResponseMessage);
            iLogWriter.log("正确");
    	 */
    	//$tResponseMessage=MerchantConfig::verifySign($tResponseMessage);
    	$this->iLogWriter->logNewLine('接收报文：');
    	$this->iLogWriter->logNewLine($tResponseMessage);
    	$this->iLogWriter->logNewLine('生成交易响应对象：');
        $tTrxResponse=new TrxResponse();
        $tTrxResponse=$this->constructResponse($tRequestMessage);
        $this->iLogWriter->logNewLine('交易结果：['.$tTrxResponse->getReturnCode().']');
        $this->iLogWriter->logNewLine('错误信息：['.$tTrxResponse->getErrorMessage().']');
    	}
    	catch (TrxException $e)
    	{
    		$tTrxResponse = new TrxResponse();
    		$tTrxResponse->initWithCodeMsg($e->getCode(), $e->getMessage().'-'.$e->getDetailMessage());
    		if($this->iLogWriter != null)
    		{
    			$this->iLogWriter->logNewLine('错误代码：['.$tTrxResponse->getReturnCode().']    错误信息：['.$tTrxResponse->getErrorMessage().']');
    		}
    	}
    	catch (Exception $e)
    	{
    		/*
    		  $tTrxResponse = new TrxResponse();
            $tTrxResponse->initWithCodeMsg(TrxException::TRX_EXC_CODE_1999, TrxException::TRX_EXC_MSG_1999.
                ' - '.$e->getMessage());
            if ($this->iLogWriter != null)
            {
                $this->iLogWriter->logNewLine('错误代码：['.$tTrxResponse->getReturnCode().']    错误信息：['.
                    $tTrxResponse->getErrorMessage().']');
            }
    		 */
    		$tTrxResponse=new TrxResponse(TrxException::TRX_EXC_CODE_1999,TrxException::TRX_EXC_MSG_1999.'-'.$e->getMessage());
    		
    	}
    	/*
          catch(Exception e) {
              tTrxResponse = new TrxResponse(TrxException.TRX_EXC_CODE_1999, TrxException.TRX_EXC_MSG_1999 + " - " + e.getMessage());
              e.printStackTrace(System.err);
              if (iLogWriter != null)
                  iLogWriter.logNewLine("CBP错误代码：[" + tTrxResponse.getReturnCode() + "]    错误信息：[" + tTrxResponse.getErrorMessage() + "]");
          }
          finally {
              if (iLogWriter != null) {
                  iLogWriter.logNewLine("CBP交易结束==================================================");
                  try { iLogWriter.closeWriter(MerchantConfig.getTrxLogFile()); } catch (Exception e) { }
              }
          }

          return tTrxResponse;
    	 */
    	
  
    
    }
    /**
     * 检查交易报文是否合法。
     * @throws TrxException：交易报文不合法。
     */
    protected abstract function checkRequest();
    /**
     * 回传交易报文。
     * @return 交易报文信息
     */
    protected abstract function getRequestMessage();
    /**
     * 回传交易响应对象。
     * @throws TrxException：组成交易报文的过程中发现内容不合法
     * @return 交易报文信息
     */
    protected abstract function constructResponse($aResponseMessage);
    
	  public function sendSocketMsg($host,$port,$str,$back=0)
	  {
		    $socket = socket_create(AF_INET,SOCK_STREAM,6);
		    if ($socket < 0) return false;
		    $result = @socket_connect($socket,$host,$port);
		    if ($result == false)return false;
		    socket_write($socket,$str,strlen($str));
		    
		    if($back!=0){
		        $input = socket_read($socket,1024);
		        socket_close ($socket);    
		        return $input;
		    }else{
		        socket_close ($socket);    
		        return true;    
		    }    
		}
    
}
/*
 protected function getRequestMessage()
 {
return new XMLDocument(
		'<'.ITagName::MSG_MESSAGE.'>'.
		$this->constructControlMessage().
		$this->constructParametersMessage().
		$this->constructResultsetslMessage().
		'</'.ITagName::MSG_MESSAGE.'>');
}
组织报文的Control字段
protected function constructControlMessage()
{
return '<'.ITagName::MSG_MESSAGE_CONTROL.'>'.
'<MerchantTrxNo>'.$this->iRequestID.'</MerchantTrxNo>'.
'<Version>'.IVersion::VERSION.'</Version>'.
'<ChannelType>'.$this->iChannelType.'</ChannelType>'.
'<BusinessID>'.$this->iBusinessID.'</BusinessID>'.
'<FunctionID>'.$this->iFunctionID.'</FunctionID>'.
'<MerchantID>'.$this->iMerchantID.'</MerchantID>'.
'</'.ITagName::MSG_MESSAGE_CONTROL.'>';
}

protected abstract function constructParametersMessage();

/*组织报文的Resultsets字段
protected function constructResultsetslMessage()
{
return '<'.ITagName::MSG_MESSAGE_RESULTSETS.'>'.
'</'.ITagName::MSG_MESSAGE_RESULTSETS.'>';
}*/

/*
 /// 检查交易报文是否合法。
protected function checkRequest()
{
//商户编号，必须
if (!$this->iMerchantID || strlen($this->iMerchantID) > ILength::MERCHANTID_LEN)
{
throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1100,
		'商户Id['.$this->iMerchantID.']不正确');
}

//*交易码不能为空，必须
if (!$this->iFunctionID)
{
throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1100,
		'交易码FunctionID['.$this->iFunctionID.']不能为空');
}

//** 商户备注
if (strlen($this->iMerchantRemarks) > ILength::MERCHANT_REMARKS_LEN)
{
throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1100,
		'商户备注['.$this->iMerchantRemarks.']超过长度限制');
}

//*商户请求流水号
if (!$this->iRequestID || strlen($this->iRequestID) > IMarketLength::REQUESTID_LEN)
{
throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1100,
		'商户请求流水号['.$this->iRequestID.']不正确');
}

}
*/
/// 回传交易响应对象。
/*
 protected function constructResponse($aResponseMessage)
 {
$resp = new TrxResponse();
$resp->initWithXML($aResponseMessage);
return $resp;
}
*/
/*
 if (!function_exists('gzdecode'))
 {
function gzdecode($data)
{
$flags = ord(substr($data, 3, 1));
$headerlen = 10;
$extralen = 0;
$filenamelen = 0;
if ($flags & 4) {
$extralen = unpack('v' ,substr($data, 10, 2));
$extralen = $extralen[1];
$headerlen += 2 + $extralen;
}
if ($flags & 8) // Filename
$headerlen = strpos($data, chr(0), $headerlen) + 1;
if ($flags & 16) // Comment
$headerlen = strpos($data, chr(0), $headerlen) + 1;
if ($flags & 2) // CRC at end of file
$headerlen += 2;
$unpacked = @gzinflate(substr($data, $headerlen));
if ($unpacked === FALSE)
	$unpacked = $data;
return $unpacked;
}
}
*/
//没有写构造方法；没有第3步composeRequestMessage
//字段^_^
/*
 //交易类型,必须
protected $iFunctionID = '';

//业务类型，必须
protected $iBusinessID = '';

//渠道类型，必须
protected $iChannelType = '';

//商户Id,必须
protected $iMerchantID = '';

//商户备注信息，可选

protected $iMerchantRemarks = '';

//商户请求流水号
protected $iRequestID = '';

//客户号
protected $iCustomer = '';

*/
//属性
/*
 public function getMerchantRemarks() {
return $this->iMerchantRemarks;
}


public function setMerchantRemarks($iMerchantRemarks) {
$this->iMerchantRemarks = $iMerchantRemarks;
}



public function getFunctionID()
{
return $this->iFunctionID;
}
public function setFunctionID($functionID)
{
$this->iFunctionID = trim($functionID);
}

public function getBusinessID()
{
return $this->iBusinessID;
}
public function setBusinessID($businessID)
{
$this->iBusinessID = trim($businessID);
}

public function getChannelType()
{
return $this->iChannelType;
}
public function setChannelType($channelType)
{
$this->iChannelType = trim($channelType);
}

public function getMerchantID()
{
return $this->iMerchantID;
}
public function setMerchantID($merchantID)
{
$this->iMerchantID = trim($merchantID);
}

public function getRequestID()
{
return $this->iRequestID;
}
public function setRequestID($requestID)
{
$this->iRequestID = trim($requestID);
}

public function getCustomer()
{
return $this->iCustomer;
}
public function setCustomer($customer)
{
$this->iCustomer = trim($customer);
}
*/
?>