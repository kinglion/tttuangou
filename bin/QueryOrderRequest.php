<?php
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');
class_exists('Order') or require(dirname(__FILE__).'/Order.php');


class QueryOrderRequest extends TrxRequest
{
	/** ������ */
	private $iOrderNo='';
	/** �Ƿ��ѯ��ϸ��Ϣ */
	private $iEnableDetailQuery=false;

	 /**
     * �趨������
     * @param aOrderNo ������
     * @return ������
     */
	public function setOrderNo($aOrderNo)
	{
		$this->iOrderNo=trim($aOrderNo);
	}
    /**
     * �ش�������
     * @return ������
     */
    public function getOrderNo()
	{
		return $this->iOrderNo;
	}
    /**
     * �趨�Ƿ��ѯ������ϸ��Ϣ
     * @param aEnableDetailQuery �Ƿ��ѯ������ϸ��Ϣ
     * @return ������
     */
	public function enableDetailQuery($aEnableDetailQuery)
	{
		$this->iEnableDetailQuery=$aEnableDetailQuery;
	}
	 /**
     * ����QueryOrderRequest����
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
		$qorMes='';
		if($this->iEnableDetailQuery==true)
		{
			$qorMes= '<TrxRequest>'.
			    '<TrxType>'.TrxType::TRX_TYPE_QUERY.'</TrxType>'.
				'<OrderNo>'.$this->iOrderNo.'</OrderNo>'.
				'<QueryDetail>'.'true'.'</QueryDetail>'.
			    '</TrxRequest>';
		}
		else 
		{
			$qorMes='<TrxRequest>'.
			    '<TrxType>'.TrxType::TRX_TYPE_QUERY.'</TrxType>'.
				'<OrderNo>'.$this->iOrderNo.'</OrderNo>'.
				'<QueryDetail>0</QueryDetail>'.
			    '</TrxRequest>';
		}
		return $qorMes;
	}
	/**
	*��дTrxRequest�еĳ��󷽷�
	
	protected function constructParametersMessage()
	{
		getRequestMessage();
	}
	*/
	 /**
     * ������ѯ������Ϣ�Ƿ�Ϸ�
     * @throws TrxException: ������ѯ���󲻺Ϸ�
     */
	protected function checkRequest()
	{
		if(!$this->iOrderNo) 
			throw new TrxException(TrxException::TRX_EXC_CODE_1100,TrxException::TRX_EXC_MSG_1100,'δ�趨�����ţ�');
		//ԭ��java�и�getBytes()����  if (iOrderNo.getBytes().length > Order.ORDER_NO_LEN)
		if(strlen(trim($this->iOrderNo))>Order::ORDER_NO_LEN)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101,TrxException::TRX_EXC_MSG_1101,'�����Ų��Ϸ���');

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
$qor= new QueryOrderRequest();
$orderno='ON200306300001';
$qor->setOrderNo($orderno);
$qor->enableDetailQuery(false);
$tTrxResponse=new TrxResponse();
$tTrxResponse=$qor->postRequest();
if($tTrxResponse->isSuccess())
echo "success";
else 
	echo 'aaa';
*/

?>