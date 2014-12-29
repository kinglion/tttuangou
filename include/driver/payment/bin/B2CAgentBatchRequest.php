<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');
/**
 * 商户端接口软件包业务处理类，负责委托扣款批量的处理。
 */
class B2CAgentBatchRequest extends TrxRequest
{
   	const  MAXSUMCOUNT = 100;
   	
   	/** 批量明细累计笔数 */
    private $iSumCount = 0;
   	
   	/** 批量明细累计金额 */
   	private $iSumAmount = 0;
   	
   	/** 批次对象,必须 */
   	private $iAgentBatch = '';
   	
   	/** 批次明细对象,必须 */
   	private $iAgentBatchDetail = '';
   	
   	/** 批次明细对象，必须，要求校验批内明细合计笔数和合计金额是否和批次信息的总笔数和总金额一致 */
   	private $iAgentBatchDetailList = array();
   	
   	/**
   	 * 构造FundAgentPaymentRequest对象
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
   		// 累计笔数
   		$this->iSumCount=$this->iSumCount+1;
   		// 累计金额
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
    		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'批次信息不允许为空');
    	if($ab->getAgentCount() != $this->iSumCount )
    		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'批内明细合计笔数('.$ab->getAgentCount().')与批次的总笔数('.$this->iSumCount.')不符');
    	if($this->iSumCount > self::MAXSUMCOUNT)
    		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'批次的总笔数('.$this->iSumCount.')超过最大限制('.self::MAXSUMCOUNT.')');
    	if($ab->getAgentAmount() != $this->iSumAmount)
    		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'批内明细合计金额('.$ab->getAgentAmount().')与批次的总金额('.$this->iSumAmount.')不符');
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
   	 * 回传交易响应对象。
   	 * @return 交易报文信息
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
 * getRequest方法中batchtime 现在时间
 * java System.currentTimeMillis()的时间戳有13位，到微秒
echo time("now")."<br>";
echo time()."<br>";//只有10位
echo microtime()."<br>";
echo strtotime(microtime())."???<br>";//返回微秒数和时间戳
echo strtotime("now");
*/
?>