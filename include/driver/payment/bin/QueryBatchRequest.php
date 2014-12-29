<?php 

/**
 * �̻��˽ӿ������ҵ�����࣬�����̻��ύ����״̬��ѯ�Ĵ���
 */
class QueryBatchRequest extends TrxRequest
{
	/** ������ˮ�� */
	private $iSerialNumber = '';
	
	/**
	 * ����QueryOrderRequest����
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	/* (non-PHPdoc)
	 * @see TrxRequest::checkRequest()
	 * ������ѯ������Ϣ�Ƿ�Ϸ�
	 * @throws TrxException: ������ѯ���󲻺Ϸ�
	 */
	protected function checkRequest() 
	{
		if($this->iSerialNumber == null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'δ�趨������ˮ�ţ�');
		if(strlen(DataVerifier::stringToByteArray($this->iSerialNumber)) > 30)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'֧������ش���ַ���Ϸ���');
	}

	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 * �ش����ױ��ġ�
	 * @return ���ױ�����Ϣ
	 */
	 protected function getRequestMessage() 
	 {
	 	$tMessage='<TrxRequest>'.
	 			  '<TrxType>'.QueryBatchReq.'</TrxType>'.
	 			  '<SerialNumber>'.$this->iSerialNumber.'</SerialNumber>'.
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
	 	return new TrxResponse($aResponseMessage);
	 }

	
}
?>