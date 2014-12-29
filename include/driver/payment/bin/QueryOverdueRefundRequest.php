<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');

class QueryOverdueRefundRequest extends TrxRequest
{
	/** ������ˮ�� */
	private $iSerialNumber = "";
	
	/**
	 * ����QueryOverdueRefundRequest����
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	/**
	 * �ش����ױ��ġ�
	 * @return ���ױ�����Ϣ
	 */
	protected function getRequestMessage() 
	{
		$str='<TrxRequest>'.
			 '<TrxType>'.TrxType::TRX_TYPE_QUERYOVERDUEREFUND.'</TrxType>'.
			 '<SerialNumber>'.$this->iSerialNumber.'</SerialNumber>'.
			 '</TrxRequest>';
		return $str;
	}

	/**
	 * ������ѯ������Ϣ�Ƿ�Ϸ�
	 * @throws TrxException: ������ѯ���󲻺Ϸ�
	 */
	protected function checkRequest() 
	{
		if(!$this->iSerialNumber)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'δ�趨������ˮ�ţ�');
		if(count(DataVerifier::stringToByteArray($this->iSerialNumber)) >30)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'������ˮ�Ų��Ϸ���');	
		/*��
		if (iSerialNumber.getBytes().length > 30)
			throw new TrxException(TrxException.TRX_EXC_CODE_1101, TrxException.TRX_EXC_MSG_1101, "֧������ش���ַ���Ϸ���");
			*/
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
	 * @return the $iSerialNumber
	 */
	public function getSerialNumber() {
		return $this->iSerialNumber;
	}

	/**
	 * @param string $iSerialNumber
	 */
	public function setSerialNumber($iSerialNumber) {
		$this->iSerialNumber = trim($iSerialNumber);
	}

}
/*
$tqorRequest=new QueryOverdueRefundRequest();
$tqorRequest->setSerialNumber('001');
echo $tqorRequest->getRequestMessage();
if(!$tqorRequest->checkRequest())
echo 'ok';
echo $tqorRequest->getSerialNumber();
*/
?>