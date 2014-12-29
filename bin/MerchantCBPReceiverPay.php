<?php 
/**
 * 商户端接口软件包实体类，代表网上支付平台对商户提交交易的响应。
 */
class MerchantCBPReceiverPay 
{
	/**
	 * 商户日志
	 */
	private $iLogWriter = null;
	protected $tMerchantConfig = null;
	
	/** 商品种类 */
	private $iCBPOrderNo     = '';
	
	/** 通知商户类型 */
	private $iClientIP      = '';
	private $iIsSuppCredit      = '';
	
	private $iOrderDate  = '';
	/** 支付类型 */
	private $iResultURL     = '';
	/** 订单金额 */
	private $iOrderAmt = 0;
	
	private $iReturnCode='';
	private $iErrorMsg='';
	
	/**
	 * 构造PaymentResult对象，并使用网上支付平台的支付结果的信息初始对象的属性。
	 * @param aMessage 网上支付平台的支付结果的信息
	 * @throws TrxException 无法辨识网上支付平台的支付结果的信息。
	 */
	public function __construct()
	{
		
	}
	public function constructMerchantCBPReceiverPay($aMessage)
	{	
		try {
			$tLogWriter=new LogWriter();
			$tLogWriter->logNewLine('CBPTrustPayClient PHP验证农行支付平台支付请求开始==========================');
			$tLogWriter->logNewLine('CBP接收到的农行支付平台支付请求：\n['.$aMessage.']');
			//1、还原经过base64编码的信息
			$tMessage=base64_decode($aMessage);
			$tLogWriter->logNewLine('经过Base64解码后的支付请求：\n['.$tMessage.']');
			//2、取得经过签名验证的报文
			$tLogWriter->logNewLine('验证支付请求的签名：');
			$tResult=MerchantConfig::verifySign($tMessage);
			$tLogWriter->logNewLine('验证通过！\n 经过验证的支付请求：\n['.$tResult.']');
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
			//finally
			if($tLogWriter!=null)
			{
				$tLogWriter->logNewLine('交易结束==================================================');
				$tLogWriter->closeWriter(MerchantConfig::getTrxLogFile('CBPRefundLog'));
			}
		}
	}
	protected function initCBP($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		
		$tOrdId=$xml->getValue('OrdId');
		if($tOrdId == null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1303, TrxException::TRX_EXC_MSG_1303,'无法取得[OrdId]!');
		$this->setOrdId($tOrdId);
		
		$tTransAmount=$xml->getValue('TransAmt');
		if($tTransAmount== null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1303, TrxException::TRX_EXC_MSG_1303,'无法取得[TransAmt]!');
		$this->setTransAmt($tTransAmount);
		
		$tOrderDate=$xml->getValue('OrderDate');
		if($tOrderDate == null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1303, TrxException::TRX_EXC_MSG_1303,'无法取得[OrderDate]!');
		$this->setOrderDate($tOrderDate);
		
		$tClientIP=$xml->getValue('ClientIP');
		if($tClientIP == null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1303, TrxException::TRX_EXC_MSG_1303,'无法取得[tClientIP]!');
		$this->setClientIP($tClientIP);
		
		$IsSuppCredit=$xml->getValue('IsSuppCredit');		
		if($IsSuppCredit==null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1303, TrxException::TRX_EXC_MSG_1303,'无法取得[IsSuppCredit]!');
		$this->setIsSuppCredit($IsSuppCredit);
		$tResultURL=$xml->getValue('ResultURL');
		if($tResultURL == null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1303, TrxException::TRX_EXC_MSG_1303,'无法取得[ResultURL]!');
		$this->setResultURL($tResultURL);
	}
	/**
	 * @return the $iCBPOrderNo
	 */
	public function getCBPOrderNo() {
		return $this->iCBPOrderNo;
	}

	/**
	 * @param string $iCBPOrderNo
	 */
	public function setCBPOrderNo($iCBPOrderNo) {
		$this->iCBPOrderNo = $iCBPOrderNo;
	}

	/**
	 * @return the $iClientIP
	 */
	public function getClientIP() {
		return $this->iClientIP;
	}

	/**
	 * @param string $iClientIP
	 */
	public function setClientIP($iClientIP) {
		$this->iClientIP = $iClientIP;
	}

	/**
	 * @return the $iIsSuppCredit
	 */
	public function getIsSuppCredit() {
		return $this->iIsSuppCredit;
	}

	/**
	 * @param string $iIsSuppCredit
	 */
	public function setIsSuppCredit($iIsSuppCredit) {
		$this->iIsSuppCredit = $iIsSuppCredit;
	}

	/**
	 * @return the $iOrderDate
	 */
	public function getOrderDate() {
		return $this->iOrderDate;
	}

	/**
	 * @param string $iOrderDate
	 */
	public function setOrderDate($iOrderDate) {
		$this->iOrderDate = $iOrderDate;
	}

	/**
	 * @return the $iResultURL
	 */
	public function getResultURL() {
		return $this->iResultURL;
	}

	/**
	 * @param string $iResultURL
	 */
	public function setResultURL($iResultURL) {
		$this->iResultURL = $iResultURL;
	}

	/**
	 * @return the $iOrderAmt
	 */
	public function getOrderAmt() {
		return $this->iOrderAmt;
	}

	/**
	 * @param number $iOrderAmt
	 */
	public function setOrderAmt($iOrderAmt) {
		$this->iOrderAmt = $iOrderAmt;
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