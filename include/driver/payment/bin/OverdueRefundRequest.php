<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');


class OverdueRefundRequest extends TrxRequest
{
	/** �˿��ܱ��� */
	private $iTotalCount = 0;
	
	/** �˿��ܽ�� */
	private $iTotalAmount = 0;
	
	/** ��ע */
	private $sRemark = '';
	
	private $iOrderlist = array();
	
	/**
	 * ����OverdueRefundRequest����
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
		$str1='<TrxRequest>'.
			  '<TrxType>'.TrxType::TRX_TYPE_OVERDUEREFUND.'</TrxType>'.
			  '<TotalCount>'.$this->iTotalCount.'</TotalCount>'.
			  '<TotalAmount>'.$this->iTotalAmount.'</TotalAmount>'.
			  '<Remark>'.$this->sRemark.'</Remark>'.
			  '<OrderData>';
		$str2='';
		/*
		for($i=0;$i<$this->iTotalCount;$i++)
		{
			$str2.='<OrderNo>'.$this->iOrderlist[$i][1].'</OrderNo>'.
				   '<RefundAmount>'.$this->iOrderlist[$i][1].'</RefundAmount>';
			
		}*/
		$valueOrderNo='';
		$valueRefundAmount=0;
		foreach ($this->iOrderlist as $key=>$secarr)
		{
			foreach ($secarr as $seckey=>$value)
			{
				if($key == '0')
				{
					$str2.='<OrderNo>'.$value.'</OrderNo>';
				}
				else {
					$str2.='<RefundAmount>'.$value.'</RefundAmount>';
				}
				
			}
			//$str2.='<OrderNo>'.$this->iOrderlist[$key][$seckey].'</OrderNo>'.
			//		   '<RefundAmount>'.$this->iOrderlist[$key][$seckey].'</RefundAmount>';
		}
		$str3='</OrderData>'.
		      '</TrxRequest>';
		return $str1.$str2.$str3;
	 }
	 /**
	  * �����˿�������Ϣ�Ƿ�Ϸ�
	  * @throws TrxException: �����˿����󲻺Ϸ� 
	  */
	 protected function checkRequest()
	 {
	 	if($this->iTotalCount <= 0)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'�˿���ܱ�������С��1��');
	 	if($this->iTotalCount > 100)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'�˿���ܱ������ܴ���100��');
	 	if($this->iTotalAmount <= 0)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'�˿���ܽ��Ϸ���');
	 	if(!DataVerifier::isValidAmount($this->iTotalAmount, 2))
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'�˿���ܽ��Ϸ���'); 	
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
	 * @return the $iTotalCount
	 */
	public function getTotalCount() {
		return $this->iTotalCount;
	}

	/**
	 * @param number $iTotalCount
	 */
	public function setTotalCount($iTotalCount) {
		$this->iTotalCount = $iTotalCount;
	}

	/**
	 * @return the $iTotalAmount
	 */
	public function getTotalAmount() {
		return $this->iTotalAmount;
	}

	/**
	 * @param number $iTotalAmount
	 */
	public function setTotalAmount($iTotalAmount) {
		$this->iTotalAmount = $iTotalAmount;
	}

	/**
	 * @return the $sRemark
	 */
	public function getRemark() {
		return $this->sRemark;
	}

	/**
	 * @param string $sRemark
	 */
	public function setRemark($sRemark) {
		$this->sRemark = $sRemark;
	}

	/**
	 * @return the $iOrderlist
	 */
	//public function getOrderlist() {
	//	return $this->iOrderlist;
	//}

	/**
	 * @param multitype: $iOrderlist
	 */
	public function setOrderlist($iOrderlist) {
		$this->iOrderlist = $iOrderlist;
	}

	
}
/*
$orq=new OverdueRefundRequest();
$orq->setTotalCount(2);
$orq->setTotalAmount(2.15);
$orq->setRemark('test');
$tOrderList=array(
	'0' => array('1'=>'ON200905010001','2'=>'ON200905010002' ),
	'1' => array('1'=>1.11,'2'=>1.04)
);
$orq->setOrderlist($tOrderList);
echo $orq->getRequestMessage()."<br/>";
if(!$orq->checkRequest()) 
echo 'ok';
echo $orq->getRemark()."<br/>";
echo $orq->getTotalAmount()."<br/>";
echo $orq->getTotalCount()."<br/>";
*/
?>