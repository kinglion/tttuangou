<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');
class_exists('Order') or require(dirname(__FILE__).'/Order.php');

class RefundRequest extends TrxRequest
{

	/** ������ */
	private $iOrderNo = '';
	
	/** �˿���� */
	private $iNewOrderNo = '';
	
	/** ���׽�� */
	private $iTrxAmount = 0;
	
	/**
	 * @return the $iOrderNo
	 */
	public function getOrderNo() {
		return $this->iOrderNo;
	}

	/**
	 * @param string $iOrderNo
	 */
	public function setOrderNo($iOrderNo) {
		$this->iOrderNo = trim($iOrderNo);
	}

	/**
	 * @return the $iNewOrderNo
	 */
	public function getNewOrderNo() {
		return $this->iNewOrderNo;
	}

	/**
	 * @param string $iNewOrderNo
	 */
	public function setNewOrderNo($iNewOrderNo) {
		$this->iNewOrderNo = trim($iNewOrderNo);
	}

	/**
	 * @return the $iTrxAmount
	 */
	public function getTrxAmount() {
		return $this->iTrxAmount;
	}

	/**
	 * @param number $iTrxAmount
	 */
	public function setTrxAmount($iTrxAmount) {
		$this->iTrxAmount = $iTrxAmount;
	}

	/**
	 * ����RefundRequest����
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
			 '<TrxType>'.TrxType::TRX_TYPE_REFUND.'</TrxType>'.
			 '<OrderNo>'.$this->iOrderNo.'</OrderNo>'.
			 '<NewOrderNo>'.$this->iNewOrderNo.'</NewOrderNo>'.
			 '<TrxAmount>'.$this->iTrxAmount.'</TrxAmount>'.
			 '</TrxRequest>';
		return $str;
	}
	/**
	 * �˻�������Ϣ�Ƿ�Ϸ�
	 * @throws TrxException: �˻����󲻺Ϸ� 
	 */
	protected function checkRequest()
	{
		if(strlen(trim($this->iOrderNo))==0)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'δ�趨�����ţ�');
		//getBytes
		if(strlen(trim($this->iOrderNo))>Order::ORDER_NO_LEN)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'�����Ų��Ϸ���');
		if($this->iTrxAmount<=0)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'���׽��Ϸ���');
		if(!DataVerifier::isValidAmount($this->iTrxAmount, 2))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'���׽��Ϸ���');		
	}
	/**
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
}
/*
$rr=new RefundRequest();
$rr->setOrderNo('ON200306300001');
$rr->setNewOrderNo('ON200306300002');
$rr->setTrxAmount(23.56);
echo $rr->getRequestMessage()."**<br/>";
if(!$rr->checkRequest())
echo 'ok';
echo $rr->getNewOrderNo();
echo $rr->getOrderNo();
echo $rr->getTrxAmount();
*/
?>