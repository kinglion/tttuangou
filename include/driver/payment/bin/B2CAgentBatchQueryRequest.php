<?php 
class B2CAgentBatchQueryRequest extends TrxRequest
{
	/**���κţ�����*/
	private $iBatchNo = '';
	
	/**�������ڣ����룬���ڸ�ʽҪ��ΪYYYYMMDD*/
	private $iBatchDate = '';
	
	/**
	 * ����B2CAgentBatchQueryRequest����
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 * �ش����ױ��ġ�
     * @return ���ױ�����Ϣ
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
		//1.У�����κ���󳤶�
		if(!DataVerifier::isValidStringLen($this->iBatchNo, 30))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'���κų��ȳ������ƻ�Ϊ��');
		//2.У���������ںϷ���
		if(!DataVerifier::isValidDate8($this->iBatchDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'�������ڸ�ʽ����ȷ');
	}
	/**
	 * �ش�������Ӧ����
	 * @return ���ױ�����Ϣ
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