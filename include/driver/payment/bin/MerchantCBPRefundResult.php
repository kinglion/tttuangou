<?php 
class MerchantCBPRefundResult
{
	/** 商品种类 */
	private $iOrdId = '';
	
	/** 通知商户类型 */
	private $iRefOrdId = '';
	
	/** 支付类型 */
	private $iTransType = '';
	/** 订单金额 */
	private $iTransAmt = 0;
	private $iReturnCode='';
	private $iErrorMsg='';
	
	public function __construct()
	{
		
	}
	public function constructMerchantCBPRefundResult($aMessage)
	{
		try
		{
			$tLogWriter=new LogWriter();
			$tLogWriter->logNewLine('CBPTrustPayClient PHP验证农行支付平台退款请求开始==========================');
			$tLogWriter->logNewLine('CBP接收到的农行支付平台退款请求：\n['.$aMessage.']');
			//1、还原经过base64编码的信息
			$tMessage=base64_decode($aMessage);
			$tLogWriter->logNewLine('经过Base64解码后的退款请求：\n['.$tMessage.']');
			//2、取得经过签名验证的报文
			$tLogWriter->logNewLine('验证退款请求的签名：');
			$tResult=MerchantConfig::verifySign($tMessage);
			$tLogWriter->logNewLine('验证通过！\n 经过验证的退款请求：\n['.$tResult.']');
			//3、使用经过签名验证的报文初始对象本身
			$this->initCBP($tResult);
			$this->setReturnCode('0000');
			$this->setErrorMsg('交易成功');
			
			if($tLogWriter != null)
				$tLogWriter->logNewLine('交易结束==================================================');
				$tLogWriter->closeWriter(MerchantConfig::getTrxLogFile('CBPRefundLog'));
				
			
		}
		catch (TrxException $e){
			$tLogWriter->logs('验证失败！\n');
			$this->setReturnCode($e->getCode());
			$this->setErrorMsg($e->getMessage().'-'.$e->getDetailMessage());
			//finally
			if($tLogWriter != null)
				$tLogWriter->logNewLine('交易结束==================================================');
				$tLogWriter->closeWriter(MerchantConfig::getTrxLogFile('CBPRefundLog'));
			
		}
		
	}
	public function initCBP($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		
		$tOrdId=$xml->getValue('OrdId');
		if($tOrdId == null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1303, TrxException::TRX_EXC_MSG_1303,'无法取得[OrdId]!');
		$this->setOrdId($tOrdId);
		
		$tRefOrdId=$xml->getValue('RefOrdId');
		if($tRefOrdId == null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1303, TrxException::TRX_EXC_MSG_1303,'无法取得[RefOrdId]!');
		$this->setRefOrdId($tRefOrdId);
		
		$tTransType=$xml->getValue('TransType');
		if($tTransType == null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1303, TrxException::TRX_EXC_MSG_1303,'无法取得[TransType]!');
		$this->setTransType($tTransType);
		
		$tTransAmount=$xml->getValue('TransAmt');
		if($tTransAmount== null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1303, TrxException::TRX_EXC_MSG_1303,'无法取得[TransAmt]!');
		$this->setTransAmt($tTransAmount);
	}
	public function genSignature($i,$RequestMessage)
	{
		$tResponseMesg='';
		try{
			$iLogWriter=new LogWriter();
			$iLogWriter->logNewLine('CBP第三方支付平台响应农行退款请求交易开始==========================');
			//2、取得交易报文
			$iLogWriter->logNewLine('第三方支付平台退款响应报文');
			$iLogWriter->logNewLine($RequestMessage);
			//3、组成完整交易报文
			$iLogWriter->logNewLine('完整退款响应报文：');
			$tRequestMessage=new XMLDocument($RequestMessage);
			//4、对交易报文进行签名
			$iLogWriter->logNewLine('响应签名后的报文：');
			$tRequestMessage=MerchantConfig::signMessage($i, $tRequestMessage);
			$tTempStringBuffer='<MSG>'.$tRequestMessage.'</MSG>';
			$tResponseMesg=$tTempStringBuffer;
			$iLogWriter->logNewLine('返回给农行支付平台的退款报文：\n'.$tResponseMesg);
			$tResponseMesg=base64_encode(DataVerifier::stringToByteArrayGB2312($tResponseMesg));
			$iLogWriter->logNewLine('返回给农行支付平台经过Base64加密的退款报文：\n'.$tResponseMesg);
			//finally
			if($iLogWriter!=null)
			{
				$iLogWriter->logNewLine('交易结束==================================================');
				$iLogWriter->closeWriter(MerchantConfig::getTrxLogFile('CBPRefundLog'));
			}
		}
		catch (TrxException $e)
		{
			if($iLogWriter != null)
				$iLogWriter->logNewLine('错误代码：['.$e->getCode().']    错误信息：['.$e->getMessage().'-'.$e->getDetailMessage().']');
			throw new TrxException($e->getCode(), $e->getMessage().'-'.$e->getDetailMessage());			
		//finally
			  $iLogWriter->logNewLine('交易结束==================================================');
			  $iLogWriter->closeWriter(MerchantConfig::getTrxLogFile('CBPRefundLog'));
			  
		}
		catch (Exception $e)
		{
			if($iLogWriter != null)
				$iLogWriter->logNewLine('错误代码：['.TrxException::TRX_EXC_CODE_1999.']    错误信息：['.TrxException::TRX_EXC_MSG_1999.'-'.$e->getMessage().']');
			throw new TrxException(TrxException::TRX_EXC_CODE_1999, TrxException::TRX_EXC_MSG_1999.'-'.$e->getMessage());			
			//finally
			$iLogWriter->logNewLine('交易结束==================================================');
			$iLogWriter->closeWriter(MerchantConfig::getTrxLogFile('CBPRefundLog'));
		}
		
        return $tResponseMesg;
	}
	/**
	 * @return the $iOrdId
	 */
	public function getOrdId() {
		return $this->iOrdId;
	}

	/**
	 * @param string $iOrdId
	 */
	public function setOrdId($iOrdId) {
		$this->iOrdId = $iOrdId;
	}

	/**
	 * @return the $iRefOrdId
	 */
	public function getRefOrdId() {
		return $this->iRefOrdId;
	}

	/**
	 * @param string $iRefOrdId
	 */
	public function setRefOrdId($iRefOrdId) {
		$this->iRefOrdId = $iRefOrdId;
	}

	/**
	 * @return the $iTransType
	 */
	public function getTransType() {
		return $this->iTransType;
	}

	/**
	 * @param string $iTransType
	 */
	public function setTransType($iTransType) {
		$this->iTransType = $iTransType;
	}

	/**
	 * @return the $iTransAmt
	 */
	public function getTransAmt() {
		return $this->iTransAmt;
	}

	/**
	 * @param number $iTransAmt
	 */
	public function setTransAmt($iTransAmt) {
		$this->iTransAmt = $iTransAmt;
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