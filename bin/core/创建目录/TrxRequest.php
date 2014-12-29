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
	//���������̻����� - B2C�̻�
	const EC_MERCHANT_TYPE_B2C='B2C';
	
	//���������̻����� - B2B�̻�
	const EC_MERCHANT_TYPE_B2B='B2B';
	
	//�̻���־
    private $iLogWriter = null;
    
    //genSignature�����е�ǩ����ı���
    private $tRequestMesg='';
    
    //�̻�����
    protected $iECMerchantType='';
    
    //�̻���ע��Ϣ����ѡ
    protected $iMerchantRemarks = '';
    
    public function getMerchantRemarks() {
    	return $this->iMerchantRemarks;
    }   
    public function setMerchantRemarks($iMerchantRemarks) {
    	$this->iMerchantRemarks = $iMerchantRemarks;
    }
    
	/**
     * Class TrxRequest ���캯��
	 * @param aECMerchantType �̻����� ֵΪ$this->iBusinessID = IBusinessID::B2C������ʵ��
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
            $this->iLogWriter->logNewLine("TrustPay Client PHP ���׿�ʼ==========================");
            //0����鴫������Ƿ�Ϸ�
            $this->iLogWriter->logNewLine( '�����ļ����̻���Ϊ'.MerchantConfig::getMerchantNum().'����ָ�����̻����ñ��Ϊ '.$aMerchantNo);
            if(($aMerchantNo <= 0) || ($aMerchantNo > MerchantConfig::getMerchantNum()))
            {
                throw new TrxException(TrxException::TRX_EXC_CODE_1008, TrxException::TRX_EXC_MSG_1008, 
                    '�����ļ����̻���Ϊ'.MerchantConfig::getMerchantNum().", ��������ָ�����̻����ñ��Ϊ$aMerchantNo ��");
            }
            //1����齻�������Ƿ�Ϸ�
            $this->iLogWriter->logNewLine('��齻�������Ƿ�Ϸ���');
            $this->checkRequest();
            $this->iLogWriter->logs('��ȷ');
            //2��ȡ�ý��ױ���
            $this->iLogWriter->LogNewLine('���ױ���');
            $tRequestMessage = $this->getRequestMessage();

            //3������������ױ���
			$this->iLogWriter->logNewLine('�������ױ��ģ�');
			$tRequestMessage = $this->composeRequestMessage($aMerchantNo,$tRequestMessage);
			//$this->iLogWriter->logNewLine(trim($tRequestMessage));

            //4���Խ��ױ��Ľ���ǩ��
            $this->iLogWriter->logNewLine('ǩ����ı���');
            $tRequestMessage = MerchantConfig::signMessage($aMerchantNo, $tRequestMessage);
            //5�����ͽ��ױ���������֧��ƽ̨
            $tResponseMessage = $this->sendMessage($tRequestMessage);
			$this->iLogWriter->logNewLine('���ձ��ģ�');
			$this->iLogWriter->logNewLine($tResponseMessage);

            //6����֤����֧��ƽ̨��Ӧ���ĵ�ǩ��
            $this->iLogWriter->logNewLine('��֤����֧��ƽ̨��Ӧ���ĵ�ǩ����');
            $tResponseMessage = MerchantConfig::verifySign($tResponseMessage);
            $this->iLogWriter->logs('��ȷ');
            //7�����ɽ�����Ӧ����
            $this->iLogWriter->logNewLine('���ɽ�����Ӧ����');
            $tTrxResponse = $this->constructResponse($tResponseMessage);
           /*for debug
            echo "**".$tTrxResponse."**";
            $this->iLogWriter->logNewLine($tTrxResponse);
            $this->iLogWriter->logNewLine("���׽���==================================================\n\n\n\n");
            $this->iLogWriter->closeWriter(MerchantConfig::getTrxLogFile());
        	*/
            $this->iLogWriter->logNewLine('���׽����['.$tTrxResponse->getReturnCode().']');
            $this->iLogWriter->logNewLine('������Ϣ��['.$tTrxResponse->getErrorMessage().']');

        }
        catch (TrxException $e)
        {
            $tTrxResponse = new TrxResponse();
            $tTrxResponse->initWithCodeMsg($e->getCode(), $e->getMessage()." - ".$e->getDetailMessage());
            if($this->iLogWriter != null)
            {
                $this->iLogWriter->logNewLine('������룺[' + $tTrxResponse->getReturnCode().']    ������Ϣ��['.
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
                $this->iLogWriter->logNewLine('������룺['.$tTrxResponse->getReturnCode().']    ������Ϣ��['.
                    $tTrxResponse->getErrorMessage().']');
            }
        }

        if ($this->iLogWriter != null)
        {
            $this->iLogWriter->logNewLine("���׽���==================================================\n\n\n\n");
            $this->iLogWriter->closeWriter(MerchantConfig::getTrxLogFile());
        }

        return $tTrxResponse;

    }

    /**
     * ����������ױ���
     * @param aMerchantNo �̻���
     * @param aMessage ���ױ���
     * @return �������ױ���
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

    /// ���ͽ��ױ���������֧��ƽ̨
    private function sendMessage($aMessage)
    {
        //1�����<MSG>�� 
        $tMessage = '<MSG>'.$aMessage.'</MSG>';
       // $tMessage=$aMessage;
        $this->iLogWriter->logNewLine("�ύ����֧��ƽ̨�ı��ģ�\n$tMessage");
	    //2��ȡ�ñ��ĳ���
	    $tContentLength = count(DataVerifier::stringToByteArrayUTF8($tMessage));
	    $this->iLogWriter->LogNewLine('���ĳ��ȣ�'.$tContentLength."<br>");
	   // echo strlen($tMessage)."<br>";
	    if($tContentLength>8000)
	    {
	    	throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'���ĳ��ȳ���8000Bytes');
	    }
        //3������URL��������֧��ƽ̨
	    //����url
        $tURL = MerchantConfig::getTrustPayConnectMethod().'://'.MerchantConfig::getTrustPayServerName();
        if((MerchantConfig::getTrustPayConnectMethod() == 'https' && (MerchantConfig::getTrustPayServerPort() != 443)) ||
           (MerchantConfig::getTrustPayConnectMethod() == 'http' && (MerchantConfig::getTrustPayServerPort() !=  80)))
        {
            $tURL .= ':'.strval(MerchantConfig::getTrustPayServerPort());
        }
        $tURL .= MerchantConfig::getTrustPayTrxURL();
        $this->iLogWriter->logNewLine("��������֧��ƽ̨");
        $this->iLogWriter->logNewLine("����֧��ƽ̨URL��[$tURL] ");
        $this->iLogWriter->logNewLine("�ɹ�");
        //���ɱ��� û��base64����
       // $tMessage = base64_encode(gzencode($tMessage));
       //�ύ���ױ���
        $this->iLogWriter->logNewLine('�ύ���ױ��ģ�');
        $this->iLogWriter->logNewLine($tMessage);  
        $tResponseMessage='';
       
        if(MerchantConfig::getTrustPayConnectMethod() == 'https')
        {
        //��֯httpͷ�ͱ���,���HTTP/1.1
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
	        	throw new TrxException(TrxException::TRX_EXC_CODE_1202, TrxException::TRX_EXC_MSG_1202,'�ύ����ʱ�����������');
	        	fclose($fsocket); 
	        }
			 
        }
        elseif (MerchantConfig::getTrustPayConnectMethod() == 'http')
        {
        	//����context
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
	        //�ύ���ģ���ȡ��Ӧ
	        $tResponseMessage = file_get_contents($tURL, FALSE, stream_context_create($ctx));
        }
        if(!$tResponseMessage)
        {
            throw new TrxException(TrxException::TRX_EXC_CODE_1202, TrxException::TRX_EXC_MSG_1202);
        }
        $this->iLogWriter->logNewLine("�ɹ�");
        //$this->iLogWriter->logNewLine('���ر��ģ�');
        //$this->iLogWriter->logs("\n$tResponseMessage");
        //$tResponseMessage = gzdecode(base64_decode($tResponseMessage));
        $this->iLogWriter->logNewLine('���ܵ�����Ӧ���ģ�');
        $this->iLogWriter->logs("\n$tResponseMessage");
        $doc = new XMLDocument($tResponseMessage);
        $tTrxResponse = $doc->getValue("MSG");
        if(!$tTrxResponse)
        {
            throw new TrxException(TrxException::TRX_EXC_CODE_1205, TrxException::TRX_EXC_MSG_1205, '��[MSG]�Σ�');
        }
        return $tTrxResponse;

    }
    
    /**
     * ������ǩ���ı��ĺ������̻�ͨ��ҳ�洫��������ũ��b2c����ʱ���øú�����
     * @return ǩ����ı���
     */
    public function genSignature($i)
    {
    	
    	$this->iLogWriter=new LogWriter();
    	$this->iLogWriter->logNewLine('TrustPay Client PHP ���׿�ʼ==========================');
    	
    	//1����齻�������Ƿ�Ϸ�
    	$this->iLogWriter->logNewLine('��齻�������Ƿ�Ϸ���');
    	$this->checkRequest();
    	$this->iLogWriter->logNewLine('��ȷ');
    	//2��ȡ�ý��ױ���
    	$this->iLogWriter->logNewLine('���ױ��ģ�');
    	$tRequestMessage=$this->getRequestMessage();
    	$this->iLogWriter->logNewLine($tRequestMessage);
    	//3������������ױ���
    	$this->iLogWriter->logNewLine('�������ױ��ģ�');
    	$tRequestMessage=$this->composeRequestMessage($i, $tRequestMessage);
    	$this->iLogWriter->logNewLine($tRequestMessage);
    	//4���Խ��ױ��Ľ���ǩ��
    	$this->iLogWriter->logNewLine('ǩ����ı��ģ�');
    	$tRequestMessage=MerchantConfig::signMessage($i, $tRequestMessage);
    	$tRequestMessage='<MSG>'.
      					 $tRequestMessage.
      					 '</MSG>';
    	$tRequestMesg=$tRequestMessage;
    	$this->iLogWriter->logNewLine('�ύ����֧��ƽ̨�ı��ģ�'.$tRequestMessage);
    	if ($this->iLogWriter != null)
        {
            $this->iLogWriter->logNewLine("���׽���==================================================\n\n\n\n");
            $this->iLogWriter->closeWriter(MerchantConfig::getTrxLogFile());
        }
    	return $tRequestMesg;
    }
    /**
     * ���ͽ���������֧��ƽ̨������������֧��ƽ̨�Ľ��׻�Ӧ��
     * @return ���׽������
     */
    public function extendPostCBPRequest($i,$TrustPayCBPTrxURL)
    {
    	try 
    	{
    	$this->iLogWriter=new LogWriter();
    	$this->iLogWriter->logNewLine('TrustPay Client PHP ���׿�ʼ==========================');
    	//1����齻�������Ƿ�Ϸ�
    	$this->iLogWriter->logNewLine('CBP��齻�������Ƿ�Ϸ���');
    	$this->checkRequest();
    	$this->iLogWriter->logNewLine('��ȷ');
    	//2��ȡ�ý��ױ���
    	$this->iLogWriter->logNewLine('CBP���ױ��ģ�');
    	$tRequestMessage=$this->getRequestMessage();
    	//3������������ױ���
    	$this->iLogWriter->logNewLine('CBP�������ױ��ģ�');
    	$tRequestMessage=$this->composeRequestMessage($i, $tRequestMessage);
    	//4���Խ��ױ��Ľ���ǩ��
    	$this->iLogWriter->logNewLine('CBPǩ����ı��ģ�');
    	$tRequestMessage=MerchantConfig::signMessage($i, $tRequestMessage);
    	//5�����ͽ��ױ���������֧��ƽ̨
    	$this->iLogWriter->logNewLine('CBP���ͽ��ױ���������֧��ƽ̨��');
    	$tResponseMessage=$this->sendMessage($tRequestMessage,$TrustPayCBPTrxURL);
    	/*
    	 //6����֤����֧��ƽ̨��Ӧ���ĵ�ǩ��
            iLogWriter.logNewLine("��֤����֧��ƽ̨��Ӧ���ĵ�ǩ����");
            tResponseMessage = tMerchantConfig.verifySign(tResponseMessage);
            iLogWriter.log("��ȷ");
    	 */
    	//$tResponseMessage=MerchantConfig::verifySign($tResponseMessage);
    	$this->iLogWriter->logNewLine('���ձ��ģ�');
    	$this->iLogWriter->logNewLine($tResponseMessage);
    	$this->iLogWriter->logNewLine('���ɽ�����Ӧ����');
        $tTrxResponse=new TrxResponse();
        $tTrxResponse=$this->constructResponse($tRequestMessage);
        $this->iLogWriter->logNewLine('���׽����['.$tTrxResponse->getReturnCode().']');
        $this->iLogWriter->logNewLine('������Ϣ��['.$tTrxResponse->getErrorMessage().']');
    	}
    	catch (TrxException $e)
    	{
    		$tTrxResponse = new TrxResponse();
    		$tTrxResponse->initWithCodeMsg($e->getCode(), $e->getMessage().'-'.$e->getDetailMessage());
    		if($this->iLogWriter != null)
    		{
    			$this->iLogWriter->logNewLine('������룺['.$tTrxResponse->getReturnCode().']    ������Ϣ��['.$tTrxResponse->getErrorMessage().']');
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
                $this->iLogWriter->logNewLine('������룺['.$tTrxResponse->getReturnCode().']    ������Ϣ��['.
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
                  iLogWriter.logNewLine("CBP������룺[" + tTrxResponse.getReturnCode() + "]    ������Ϣ��[" + tTrxResponse.getErrorMessage() + "]");
          }
          finally {
              if (iLogWriter != null) {
                  iLogWriter.logNewLine("CBP���׽���==================================================");
                  try { iLogWriter.closeWriter(MerchantConfig.getTrxLogFile()); } catch (Exception e) { }
              }
          }

          return tTrxResponse;
    	 */
    	
  
    
    }
    /**
     * ��齻�ױ����Ƿ�Ϸ���
     * @throws TrxException�����ױ��Ĳ��Ϸ���
     */
    protected abstract function checkRequest();
    /**
     * �ش����ױ��ġ�
     * @return ���ױ�����Ϣ
     */
    protected abstract function getRequestMessage();
    /**
     * �ش�������Ӧ����
     * @throws TrxException����ɽ��ױ��ĵĹ����з������ݲ��Ϸ�
     * @return ���ױ�����Ϣ
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
��֯���ĵ�Control�ֶ�
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

/*��֯���ĵ�Resultsets�ֶ�
protected function constructResultsetslMessage()
{
return '<'.ITagName::MSG_MESSAGE_RESULTSETS.'>'.
'</'.ITagName::MSG_MESSAGE_RESULTSETS.'>';
}*/

/*
 /// ��齻�ױ����Ƿ�Ϸ���
protected function checkRequest()
{
//�̻���ţ�����
if (!$this->iMerchantID || strlen($this->iMerchantID) > ILength::MERCHANTID_LEN)
{
throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1100,
		'�̻�Id['.$this->iMerchantID.']����ȷ');
}

//*�����벻��Ϊ�գ�����
if (!$this->iFunctionID)
{
throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1100,
		'������FunctionID['.$this->iFunctionID.']����Ϊ��');
}

//** �̻���ע
if (strlen($this->iMerchantRemarks) > ILength::MERCHANT_REMARKS_LEN)
{
throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1100,
		'�̻���ע['.$this->iMerchantRemarks.']������������');
}

//*�̻�������ˮ��
if (!$this->iRequestID || strlen($this->iRequestID) > IMarketLength::REQUESTID_LEN)
{
throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1100,
		'�̻�������ˮ��['.$this->iRequestID.']����ȷ');
}

}
*/
/// �ش�������Ӧ����
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
//û��д���췽����û�е�3��composeRequestMessage
//�ֶ�^_^
/*
 //��������,����
protected $iFunctionID = '';

//ҵ�����ͣ�����
protected $iBusinessID = '';

//�������ͣ�����
protected $iChannelType = '';

//�̻�Id,����
protected $iMerchantID = '';

//�̻���ע��Ϣ����ѡ

protected $iMerchantRemarks = '';

//�̻�������ˮ��
protected $iRequestID = '';

//�ͻ���
protected $iCustomer = '';

*/
//����
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