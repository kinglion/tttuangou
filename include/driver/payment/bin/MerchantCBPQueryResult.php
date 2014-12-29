<?php 
/**
 * 商户端接口软件包实体类，代表网上支付平台对商户提交交易的响应。
 */
class MerchantCBPQueryResult
{
	/**
	 * 商户日志
	 */
	private $iLogWriter=null;
	protected $tMerchantConfig = null;
	
	/** 响应码*/
	private $iReturnCode='';
	
	/** 错误信息*/
	private $iErrorMsg='';
	
	/** 为Items对象的ArrayList集合。*/
	private $iItems = array();
	
	/**
	 * 构造MerchantCBPQueryResult对象，并使用网上支付平台的支付查询结果的信息初始对象的属性。
	 * @param aMessage 网上支付平台的支付结果的信息
	 * @throws TrxException 无法辨识网上支付平台的支付结果的信息。
	 */
	public function __construct($aMessage)
	{
		try {
		$tLogWriter=new LogWriter();
		$tLogWriter->logNewLine('CBPTrustPayClient Java V2.0接收农行支付平台查询账单请求开始==========================');
		$tLogWriter->logNewLine('CBP接收到的农行支付平台查询账单请求：\n['.$aMessage.']');
		//1、还原经过base64编码的信息
		$tMessage=base64_decode($aMessage);
		//$tMessage=iconv('gb2312', 'gb2312', $tMessage);
		$tLogWriter->logNewLine('经过Base64解码后的查询账单请求：\n['.$tMessage.']');
		//2、取得经过签名验证的报文
		$tLogWriter->logNewLine('验证查询账单请求的签名：');
		$tResult=MerchantConfig::verifySign($tMessage);
		$tLogWriter->logNewLine('验证通过！\n 经过验证的查询账单请求：\n['.$tResult.']');
		//3、使用经过签名验证的报文初始对象本身
		$this->initCBP($tResult);
		$this->setReturnCode('0000');
		$this->setErrorMsg('交易成功');
		//finally
		if($tLogWriter!=null)
		{
			$tLogWriter->logNewLine('交易结束==================================================');
			$tLogWriter->closeWriter(MerchantConfig::getTrxLogFile('CBPRefundLog'));
		}
		}
		catch (TrxException $e)
		{
			$tLogWriter->logs('验证失败！\n');
			$this->setReturnCode($e->getCode());
			$this->setErrorMsg($e->getMessage().'-'.$e->getDetailMessage());
			if($tLogWriter!=null)
			{
				$tLogWriter->logNewLine('交易结束==================================================');
				$tLogWriter->closeWriter(MerchantConfig::getTrxLogFile('CBPRefundLog'));	
			}
		}
	}
	public function initCBP($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->iItems=array();
		$this->iItems=$xml->getValueArray('Item');
	}
	/**
	 * 产生带签名的报文函数，商户通过页面传参数访问农行b2c服务时调用该函数。
	 * @return 签名后的报文
	 */
	public  function genSignature($i,$RequestMessage)
	{
		
		try {
		$tResponseMesg='';
		$iLogWriter=new LogWriter();	
		$iLogWriter->logNewLine('CBP第三方支付平台响应农行查询结果请求交易开始==========================');
		//2、取得交易报文
		$iLogWriter->logNewLine('第三方支付平台查询结果响应报文：');
		$iLogWriter->logNewLine($RequestMessage);
		//3、组成完整交易报文
		$iLogWriter->logNewLine('完整第三方支付平台查询结果响应报文：');
		$tRequestMessage=new XMLDocument($RequestMessage);
		//4、对交易报文进行签名
		$iLogWriter->logNewLine('响应签名后的报文：');
		$tRequestMessage=MerchantConfig::signMessage($i, $tRequestMessage);
		$tTempStringBuffer='<MSG>'.$tRequestMessage.'</MSG>';
		$tResponseMesg=$tTempStringBuffer;
		$iLogWriter->logNewLine('返回给农行支付平台的查询结果报文：\n').$tResponseMesg;
		$tResponseMesg=base64_encode(DataVerifier::stringToByteArrayGB2312($tResponseMesg));
		$iLogWriter->logNewLine('返回给农行支付平台经过Base64加密的查询结果报文：\n'.$tResponseMesg);
		//finally
		if($iLogWriter!=null)
		{
			$iLogWriter->logNewLine('"交易结束==================================================');
			$iLogWriter->closeWriter(MerchantConfig::getTrxLogFile('CBPRefundLog'));
		}
		}
		catch (TrxException $e){
			if($iLogWriter!=null)
				$iLogWriter->logNewLine('错误代码：['.$e->getCode().']    错误信息：['.$e->getMessage().'-'.$e->getDetailMessage().']');
			throw new TrxException($e->getCode(), $e->getMessage().'-'.$e->getDetailMessage());
		}
		catch (Exception $e){
			if($iLogWriter!=null)
				$iLogWriter->logNewLine('错误代码：['.TrxException::TRX_EXC_CODE_1999).']     错误信息：['.TrxException::TRX_EXC_MSG_1999.'-'.$e->getMessage().']';
			throw new TrxException(TrxException::TRX_EXC_CODE_1999, TrxException::TRX_EXC_MSG_1999.'-'.$e->getMessage());
		}
		return $tResponseMesg;
	}
	public function  getXMLDocument()
	{
		$str1='<Items>';
		$str2='';
	  	for($i=0;$i<count($this->iItems);$i++)
		{
			$item=new Items();		
			$tOrderItem=$this->iItems[i];
			$item->constructItems($tOrderItem);
			$str2 .= $item->getXMLDocument();		
		}
		$str3='</Items>';
		return $str1.$str2.$str3;
	}
	public function addItem($aItem)
	{
		if(!$this->iItems)
		{
			$this->iItems=array();
			$this->iItems[0]=$aItem;
		}
		else 
		{
			//array_push($this->iItems, $aItem);
			$num=count($this->iItems);
			$this->iItems[num]=$aItem;
		}
	}
	/**
	 * @return the $iItems
	 */
	public function getItems()
	{
		return $this->iItems;
	}
	/**
	 * @return the $iReturnCode
	 */
	public function getReturnCode() {
		return $this->iReturnCode;
	}

	/**
	 * @param string $iReturnCode
	 */
	public function setReturnCode($iReturnCode) {
		$this->iReturnCode = $iReturnCode;
	}

	/**
	 * @return the $iErrorMsg
	 */
	public function getErrorMsg() {
		return $this->iErrorMsg;
	}

	/**
	 * @param string $iErrorMsg
	 */
	public function setErrorMsg($iErrorMsg) {
		$this->iErrorMsg = $iErrorMsg;
	}

}
?>