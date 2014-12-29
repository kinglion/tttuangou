<?php 
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');
class_exists('SettleFile') or require(dirname(__FILE__).'/SettleFile.php');
/**
 * 商户端接口软件包业务处理类，负责商户对账单下载的处理。
 */
class CBPSettleRequest extends TrxRequest
{
	/** 对账日期 */
	private $iSettleDate = '';
	
	/** 对账类型 */
	private $iSettleType = '';
	
	/**
	 * Class CBPSettleRequest 默认构造函数
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	/* (non-PHPdoc)
	 * @see TrxRequest::checkRequest()
	 * 对账单下载请求信息是否合法
     * @throws TrxException: 对账单下载请求不合法
	 */
	protected function checkRequest() 
	{
		if(!DataVerifier::isValidDate($this->iSettleDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'对账日期不合法！');
		if(($this->iSettleType != SettleFile::SETTLE_TYPE_CREDIT_TRX) && ($this->iSettleType != SettleFile::SETTLE_TYPE_SETTLE) && ($this->iSettleType != SettleFile::SETTLE_TYPE_TRX) && ($this->iSettleType != SettleFile::SETTLE_TYPE_TRX_BYHOUR))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'对账类型不合法！');
	}

	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 * 回传交易报文。
     * @throws 500001：组成交易报文的过程中发现内容不合法
     * @return 交易报文信息
	 */
	 protected function getRequestMessage() 
	 {
	 	$tMessage='<TrxRequest>'.
	 	 		  '<TrxType>'.TrxType::TRX_TYPE_CBPSETTLE.'</TrxType>'.
	 	 		  '<SettleDate>'.$this->iSettleDate.'</SettleDate>'.
	 	 		  '<SettleType>'.$this->iSettleType.'</SettleType>'.
	 	 		  '</TrxRequest>';
	 	return $tMessage;
	 }

	/* (non-PHPdoc)
	 * @see TrxRequest::constructResponse()
	 * 回传交易响应对象。
     * @throws 500001：组成交易报文的过程中发现内容不合法
     * @return 交易报文信息
	 */
	 protected function constructResponse($aResponseMessage) 
	 {
		return new TrxResponse($aResponseMessage);
	 }
	/**
	 * @return the $iSettleDate
	 */
	public function getSettleDate() {
		return $this->iSettleDate;
	}

	/**
	 * @param string $iSettleDate
	 */
	public function setSettleDate($iSettleDate) {
		$this->iSettleDate = $iSettleDate;
	}

	/**
	 * @return the $iSettleType
	 */
	public function getSettleType() {
		return $this->iSettleType;
	}

	/**
	 * @param string $iSettleType
	 */
	public function setSettleType($iSettleType) {
		$this->iSettleType = $iSettleType;
	}


	
}
?>