<?php 
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('XMLDocument') or require(dirname(__FILE__).'/core/XMLDocument.php');

class OnlineRmtCardVerifyRequest extends TrxRequest
{
	/**
	 * 银行卡号
	 */
	private $iBankCardNo = '';
	
	/**
	 * 证件类型
	 */
	private $iAccountName = '';

	/**
	 * 构造OnlineRmtCardVerifyRequest对象
	 *
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	/**
	 * 初始OnlineRmtCardVerifyRequest对象
	 *
	 */
	public function constructOnlineRmtCardVerifyRequest($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->iBankCardNo=$xml->getValueNoNull('BankCardNo');
		$this->iAccountName=$xml->getValueNoNull('AccountName');
	}
	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 */
	protected function getRequestMessage() 
	{
		// TODO Auto-generated method stub
		$str='<TrxRequest>'.
			 '<TrxType>'.TrxType::TRX_TYPE_B2C_ONLINEREMIT_CARDQUERYREQ.'</TrxType>'.
			 '<BankCardNo>'.$this->iBankCardNo.'</BankCardNo>'.
			 '<AccountName>'.$this->iAccountName.'</AccountName>'.
			 '</TrxRequest>';
		return $str;
	}
	protected  function checkRequest()
	{
		//验证是否为空
		if(!DataVerifier::isValidString($this->iAccountName))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'持卡人姓名不合法');
		// 1.检验卡号合法性
		if(!DataVerifier::isValidBankCardNo($this->iBankCardNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_CODE_1101,'银行卡号不合法');
	}
	/* (non-PHPdoc)
	 * @see TrxRequest::constructResponse()
	 */
	 protected function constructResponse($aResponseMessage) 
	 {
		$trxRes=new TrxResponse();
		$trxRes->initWithXML($aResponseMessage);
		return $trxRes;
	 }
	public function getAccountName()
	{
		return $this->iAccountName;
	}
	
	public function setAccountName($tAccountName)
	{
		$this->iAccountName=$tAccountName;
	}
	
	public function getBankCardNo()
	{
		return $this->iBankCardNo;
	}
	
	public function setBankCardNo($tBankCardNo)
	{
		$this->iBankCardNo=$tBankCardNo;
	}
}
?>