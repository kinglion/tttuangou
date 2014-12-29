<?php 
class CardBalanceRequest extends TrxRequest
{
	/**���ܱ���*/
	private $iMsg    = null;
	
	/**
	 * ����CardBalanceRequest����
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	/* (non-PHPdoc)
	 * @see TrxRequest::checkRequest()
	 * ��Ϣ�Ƿ�Ϸ�
     * @throws TrxException: ���󲻺Ϸ�
	 */
	protected function checkRequest() 
	{
		// TODO Auto-generated method stub
	}

	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 * �ش����ױ��ġ�
     * @return ���ױ�����Ϣ
	 */
	 protected function getRequestMessage() 
	 {
	 	$tMessage='<TrxRequest>'.
	 	 	 '<TrxType>'.TrxType::TRX_TYPE_CRADBALANCE_REQ.'</TrxType>'.
	 	 	 '<Msg>'.$this->iMsg.'</Msg>'.
	 	 	 '</TrxRequest>';
	 	return $tMessage;
	 }

	/* (non-PHPdoc)
	 * @see TrxRequest::constructResponse()
	 * �ش�������Ӧ����
     * @throws TrxException����ɽ��ױ��ĵĹ����з������ݲ��Ϸ�
     * @return ���ױ�����Ϣ
	 */
	 protected function constructResponse($aResponseMessage) 
	 {
		 $trxRes=new TrxResponse();
		$trxRes->initWithXML($aResponseMessage);
		return $trxRes;
	 }
	/**
	 * @return the $iMsg
	 */
	public function getMsg() {
		return $this->iMsg;
	}

	/**
	 * @param NULL $iMsg
	 */
	public function setMsg($iMsg) {
		$this->iMsg = $iMsg;
	}


	
}
?>