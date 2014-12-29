<?php 
class B2CAgentBatchQueryRequest extends TrxRequest
{
	/**批次号，必须*/
	private $iBatchNo = '';
	
	/**请求日期，必须，日期格式要求为YYYYMMDD*/
	private $iBatchDate = '';
	
	/**
	 * 构造B2CAgentBatchQueryRequest对象
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 * 回传交易报文。
     * @return 交易报文信息
	 */
	protected function getRequestMessage()
	{
		// TODO Auto-generated method stub
		$str='<TrxRequest>'.
			 '<TrxType>'.TrxType::TRX_TYPE_B2C_AGENTBATCHQUERY_RESULT.'</TrxType>'.
			 '<BatchNo>'.$this->iBatchNo.'</BatchNo>'.
			 '<BatchDate>'.$this->iBatchDate.'</BatchDate>'.
			 '</TrxRequest>';
		return $str;
	}
	
	protected function checkRequest()
	{
		//1.校验批次号最大长度
		if(!DataVerifier::isValidStringLen($this->iBatchNo, 30))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'批次号长度超过限制或为空');
		//2.校验批次日期合法性
		if(!DataVerifier::isValidDate8($this->iBatchDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'批次日期格式不正确');
	}
	/**
	 * 回传交易响应对象。
	 * @return 交易报文信息
	 */
	protected function constructResponse($aResponseMessage)
	{
		$trxRes=new TrxResponse();
		$trxRes->initWithXML($aResponseMessage);
		return $trxRes;
	}
	/**
	 * @return the $iBatchNo
	 */
	public function getBatchNo() {
		return $this->iBatchNo;
	}

	/**
	 * @param string $iBatchNo
	 */
	public function setBatchNo($iBatchNo) {
		$this->iBatchNo = $iBatchNo;
	}

	/**
	 * @return the $iBatchDate
	 */
	public function getBatchDate() {
		return $this->iBatchDate;
	}

	/**
	 * @param string $iBatchDate
	 */
	public function setBatchDate($iBatchDate) {
		$this->iBatchDate = $iBatchDate;
	}

	

	
}
?>