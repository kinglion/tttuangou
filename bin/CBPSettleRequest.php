<?php 
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');
class_exists('SettleFile') or require(dirname(__FILE__).'/SettleFile.php');
/**
 * �̻��˽ӿ������ҵ�����࣬�����̻����˵����صĴ���
 */
class CBPSettleRequest extends TrxRequest
{
	/** �������� */
	private $iSettleDate = '';
	
	/** �������� */
	private $iSettleType = '';
	
	/**
	 * Class CBPSettleRequest Ĭ�Ϲ��캯��
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	/* (non-PHPdoc)
	 * @see TrxRequest::checkRequest()
	 * ���˵�����������Ϣ�Ƿ�Ϸ�
     * @throws TrxException: ���˵��������󲻺Ϸ�
	 */
	protected function checkRequest() 
	{
		if(!DataVerifier::isValidDate($this->iSettleDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'�������ڲ��Ϸ���');
		if(($this->iSettleType != SettleFile::SETTLE_TYPE_CREDIT_TRX) && ($this->iSettleType != SettleFile::SETTLE_TYPE_SETTLE) && ($this->iSettleType != SettleFile::SETTLE_TYPE_TRX) && ($this->iSettleType != SettleFile::SETTLE_TYPE_TRX_BYHOUR))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'�������Ͳ��Ϸ���');
	}

	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 * �ش����ױ��ġ�
     * @throws 500001����ɽ��ױ��ĵĹ����з������ݲ��Ϸ�
     * @return ���ױ�����Ϣ
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
	 * �ش�������Ӧ����
     * @throws 500001����ɽ��ױ��ĵĹ����з������ݲ��Ϸ�
     * @return ���ױ�����Ϣ
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