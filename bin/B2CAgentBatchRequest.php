<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');
/**
 * �̻��˽ӿ������ҵ�����࣬����ί�пۿ������Ĵ���
 */
class B2CAgentBatchRequest extends TrxRequest
{
   	const  MAXSUMCOUNT = 100;
   	
   	/** ������ϸ�ۼƱ��� */
    private $iSumCount = 0;
   	
   	/** ������ϸ�ۼƽ�� */
   	private $iSumAmount = 0;
   	
   	/** ���ζ���,���� */
   	private $iAgentBatch = '';
   	
   	/** ������ϸ����,���� */
   	private $iAgentBatchDetail = '';
   	
   	/** ������ϸ���󣬱��룬Ҫ��У��������ϸ�ϼƱ����ͺϼƽ���Ƿ��������Ϣ���ܱ������ܽ��һ�� */
   	private $iAgentBatchDetailList = array();
   	
   	/**
   	 * ����FundAgentPaymentRequest����
   	 */
   	public function __construct()
   	{
   		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
   	}
   	
   	public function addAgentBatchDetail($iAgentBatchDetail) 
   	{
   		if(!$this->iAgentBatchDetailList)
   		{
   			$this->iAgentBatchDetailList = array();
   			$this->iAgentBatchDetailList[0] = $iAgentBatchDetail;
   		}
   		else {
   			array_push($this->iAgentBatchDetailList, $iAgentBatchDetail);
   		}
   		// �ۼƱ���
   		$this->iSumCount=$this->iSumCount+1;
   		// �ۼƽ��
   	    //$abd=new AgentBatchDetail();
   	    
   	    //$abd->constructAgentBatchDetail($iAgentBatchDetail);
   		$this->iSumAmount = $this->iSumAmount + $iAgentBatchDetail->getOrderAmount();
   	}
   	protected function checkRequest()
    {
    	 $ab=new AgentBatch();
    	//$ab->constructAgentBatch($this->iAgentBatch);
    	$ab=$this->iAgentBatch;
    	if(!$this->iAgentBatch)
    		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'������Ϣ������Ϊ��');
    	if($ab->getAgentCount() != $this->iSumCount )
    		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'������ϸ�ϼƱ���('.$ab->getAgentCount().')�����ε��ܱ���('.$this->iSumCount.')����');
    	if($this->iSumCount > self::MAXSUMCOUNT)
    		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'���ε��ܱ���('.$this->iSumCount.')�����������('.self::MAXSUMCOUNT.')');
    	if($ab->getAgentAmount() != $this->iSumAmount)
    		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'������ϸ�ϼƽ��('.$ab->getAgentAmount().')�����ε��ܽ��('.$this->iSumAmount.')����');
    	$ab->checkRequest();
    	for ($i=0; $i<count($this->iAgentBatchDetailList);$i++)
    	{
    		$abd=new AgentBatchDetail();
    		//$abd->constructAgentBatchDetail($this->iAgentBatchDetailList[$i]);
    		$abd=$this->iAgentBatchDetailList[$i];
    		$abd->checkRequest();
    	}
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
	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 */
	protected function getRequestMessage() 
	{
		// TODO Auto-generated method stub
		$ab=new AgentBatch();
		//$ab->constructAgentBatch($this->iAgentBatch);
		$ab=$this->iAgentBatch;
		   $str='<TrxRequest>'.
				'<TrxType>'.TrxType::TRX_TYPE_B2C_AGENTBATCH_REQ.'</TrxType>'.
				'<AgentBatch>'.
				'<BatchNo>'.$ab->getBatchNo().'</BatchNo>'.
				'<BatchDate>'.$ab->getBatchDate().'</BatchDate>'.
				'<BatchTime>'.time().'</BatchTime>'.
				'<AgentAmount>'.$ab->getAgentAmount().'</AgentAmount>'.
				'<AgentCount>'.$ab->getAgentCount().'</AgentCount>'.
				'</AgentBatch>'.$this->getAgentBatchDetailMessage().
				'</TrxRequest>';		
		return $str;
	}
	protected function  getAgentBatchDetailMessage() 
	{
		
		$strDetailMes='<Details>';
		$abd=new AgentBatchDetail();
		for($i=0; $i<count($this->iAgentBatchDetailList);$i++)
		{
			//$abd->constructAgentBatchDetail($this->iAgentBatchDetailList[i]);
			$abd=$this->iAgentBatchDetailList[$i];
			$strDetailMes.='<Detail>'.
					  	   '<ON>'.$abd->getOrderNo().'</ON>'.
			               '<OA>'.$abd->getOrderAmount().'</OA>'.
			               '<CertNo>'.$abd->getCertificateNo().'</CertNo>'.
			               '<CID>'.$abd->getContractID().'</CID>'.
			               '<PID>'.$abd->getProductID().'</PID>'.
			               '<PName>'.$abd->getProductName().'</PName>'.
			               '<PNum>'.$abd->getProductNum().'</PNum>'.
			               '<ExpiredDate>'.$abd->getExpiredDate().'</ExpiredDate>'.
			               '</Detail>';              
		}
		$strDetailMes.='</Details>';
		return $strDetailMes;
	}
	/**
	 * @return the $iAgentBatch
	 */
	public function getAgentBatch() {
		return $this->iAgentBatch;
	}

	/**
	 * @param string $iAgentBatch
	 */
	public function setAgentBatch($iAgentBatch) {
		$this->iAgentBatch = $iAgentBatch;
	}
	/**
	 * @return the $iAgentBatchDetailList
	 */
	public function getAgentBatchDetailList() {
		return $this->iAgentBatchDetailList;
	}
	/**
	 * @return the $iAgentBatchDetailList
	 */
	public function getBatchItems() {
		return $this->iAgentBatchDetailList;
	}	
}
/*
 * getRequest������batchtime ����ʱ��
 * java System.currentTimeMillis()��ʱ�����13λ����΢��
echo time("now")."<br>";
echo time()."<br>";//ֻ��10λ
echo microtime()."<br>";
echo strtotime(microtime())."???<br>";//����΢������ʱ���
echo strtotime("now");
*/
?>