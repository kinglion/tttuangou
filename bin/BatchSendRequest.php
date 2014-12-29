<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');
/**
 * �̻��˽ӿ������ҵ�����࣬�����̻��ύ����״̬��ѯ�Ĵ���
 */
class BatchSendRequest extends TrxRequest
{
	/** ������ˮ�� */
	private $iSerialNumber = '';
	
	/**
	 * ����BatchSendRequest����
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	/* (non-PHPdoc)
	 * @see TrxRequest::checkRequest()
	 * ������ѯ������Ϣ�Ƿ�Ϸ�
	 * @throws TrxException: ������ѯ���󲻺Ϸ�
	 */protected function checkRequest() 
	 {
		// TODO Auto-generated method stub
		if(!$this->iSerialNumber)
		{
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'δ�趨������ˮ�ţ�');
		}
		if(count(DataVerifier::stringToByteArray($this->iSerialNumber))>30)
		{
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'֧������ش���ַ���Ϸ���');
		}
	}
	
	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 * �ش����ױ��ġ�
	 * @return ���ױ�����Ϣ
	 */protected function getRequestMessage() 
	 {
		// TODO Auto-generated method stub
		$tMessage='<TrxRequest>'.
				  '<TrxType>'.RefundBatchSendReq.'</TrxType>'.
				  '<SerialNumber>'.$this->iSerialNumber.'</SerialNumber>'.
				  '</TrxRequest>';
		return $tMessage;
	}

	/* (non-PHPdoc)
	 * @see TrxRequest::constructResponse()
	 */protected function constructResponse($aResponseMessage) 
	 {
		$trxRes=new TrxResponse();
		$trxRes->initWithXML($aResponseMessage);
		return $trxRes;
	 }
	/**
	 * @return the $iSerialNumber
	 */
	public function getSerialNumber() {
		return $this->iSerialNumber;
	}

	/**
	 * @param string $iSerialNumber
	 */
	public function setSerialNumber($iSerialNumber) {
		$this->iSerialNumber = $iSerialNumber;
	}


	
}
?>