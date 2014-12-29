<?php
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('XMLDocument') or require(dirname(__FILE__).'/core/XMLDocument.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');

class AgentBatch
{
	/**
	 *[核准状态]属性 批量待复核：STATUS_UNCHECK
	 */
	const STATUS_UNCHECK='0';

	/**
	 *[核准状态]属性 复核通过待发送：STATUS_CHECKSUCCESS
	 */
	const STATUS_CHECKSUCCESS='1';

	/**
	 *[核准状态]属性 复核驳回：STATUS_REJECT
	 */
	const STATUS_REJECT='2';

	/**
	 *[批量状态]属性 复核通过后已发送(等待处理)：STATUS_SEND
	 */
	const STATUS_SEND='3';
	/**
	 *[批量状态]属性 处理成功：STATUS_SUCCESS
	 */
	const STATUS_SUCCESS='4';
	/**
	 *[批量状态]属性 处理失败：STATUS_FAIL
	 */
	const STATUS_FAIL='5';

	// 以下三种状态仅针对处理完成的批量，通过查询批量内部各订单交易情况动态获得，仅用于页面显示，并不是批量状态的一种
	/**
	 *[批量状态]属性 批量内所有订单退款成功：STATUS_ALL_SUCCESS
	 */
	const STATUS_ALL_SUCCESS='6';

	/**
	 *[批量状态]属性 批量内所有订单退款失败：STATUS_ALL_FAIL
	 */
	const STATUS_ALL_FAIL='7';

	/**
	 *[批量状态]属性 批量内部分订单退款成功：STATUS_PART_SUCCESS
	 */
	const STATUS_PART_SUCCESS='8';

	/**
	 * 商户编号
	 */
	private $iMerchantNo='';

	/**
	 * 批量编号
	 */
	private $iBatchNo='';

	/**
	 * 批量日期
	 */
	private $iBatchDate='';
	/**
	 * 批量时间
	 */
	private $iBatchTime=0;

	/**
	 * 委托扣款总金额
	 */
	private $iAgentAmount=0;

	/**
	 * 委托扣款总笔数
	 */
	private $iAgentCount=0;

	/**
	 * 交易类型代码
	 */
	private $iTrnxTypeNo='';
	/**
	 * 批量状态
	 */
	private $iBatchStatus='';

	/** 委托扣款批量订单明细。为AgentBatchDetail对象的ArrayList集合。 */
	private $iAgentBatchDetail=array();

	/**
	 * 设定[商户编号]属性
	 * 
	 * @param aMerchantNo
	 *            商户编号
	 */
	public function setMerchantNo($aMerchantNo)
	{
		$this->iMerchantNo=trim($aMerchantNo);
	}

	/**
	 * 取得[商户编号]属性
	 */
	public function getMerchantNo()
	{
		return $this->iMerchantNo;
	}

	/**
	 * 设定[委托批量批次号]属性
	 * 
	 * @param aBatchNo
	 *            批量批次号
	 */
	public function setBatchNo($aBatchNo)
	{
		$this->iBatchNo=trim($aBatchNo);
	}

	/**
	 * 取得[委托批量批次号]属性
	 */
	public function getBatchNo()
	{
		return $this->iBatchNo;
	}

	/**
	 * 设定[委托批量批次日期]属性
	 * 
	 * @param aBatchDate
	 *            批次日期
	 */
	public function setBatchDate($aBatchDate)
	{
		$this->iBatchDate=trim($aBatchDate);
	}

	/**
	 * 取得[委托批量批次日期]属性
	 */
	public function getBatchDate()
	{
		return $this->iBatchDate;
	}

	/**
	 * 设定[委托批量批次时间]属性
	 * 
	 * @param aBatchTime
	 *            批次时间
	 */
	public function setBatchTime($aBatchTime)
	{
		$this->iBatchTime=$aBatchTime;
	}

	/**
	 * 取得[委托批量批次时间]属性
	 */
	public function getBatchTime()
	{
		return $this->iBatchTime;
	}

	/**
	 * 设定[委托批量批次状态]属性
	 * 
	 * @param aBatchStatus
	 *            批次状态
	 */
	public function setBatchStatus($aBatchStatus)
	{
		$this->iBatchStatus=trim($aBatchStatus);
	}

	/**
	 * 取得[委托批量批次状态]属性
	 */
	public function getBatchStatus()
	{
		return $this->iBatchStatus;
	}

	/**
	 * 设定[交易总金额]属性
	 * 
	 * @param aRefundAmount
	 *            交易总金额
	 */
	public function setAgentAmount($aAgentAmount)
	{
		$this->iAgentAmount=$aAgentAmount;
	}

	/**
	 * 取得[交易总金额]属性
	 */
	public function getAgentAmount()
	{
		return $this->iAgentAmount;
	}

	/**
	 * 设定[交易总笔数]属性
	 * 
	 * @param aRefundCount
	 *            交易总比数
	 */
	public function setAgentCount($aAgentCount)
	{
		$this->iAgentCount=$aAgentCount;
	}

	/**
	 * 取得[交易总笔数]属性
	 */
	public function getAgentCount()
	{
		return $this->iAgentCount;
	}

	/**
	 * 设定[交易类型代码]属性
	 * 
	 * @param aTrnxTypeNo
	 *            交易类型代码
	 */
	public function setTrnxTypeNo($aTrnxTypeNo)
	{
		$this->iTrnxTypeNo=trim($aTrnxTypeNo);
	}

	/**
	 * 取得[交易类型代码]属性
	 */
	public function getTrnxTypeNo()
	{
		return $this->iTrnxTypeNo;
	}

	/**
	 * 批量委托明细
	 * 
	 * @return AgentBatch对象的AgentBatchDetail数组。
	 */
	public function getAgentBatchDetail()
	{
		return $this->iAgentBatchDetail;
	}

	/**
	 * 新增批量委托明细
	 * 
	 * @param aAgentBatchDetail
	 *            批量委托明细（AgentBatchDetail）对象
	 */
	public function addAgentBatchDetail($aAgentBatchDetail)
	{
		$this->iAgentBatchDetail = array_push($this->iAgentBatchDetail,$aAgentBatchDetail);
	}
	
	/**
	 * 构造AgentBatch对象
	 */
	public function __construct()
	{
	}
	/**
	*初始化AgentBatch对象
	*
	*/
	public function constructAgentBatch($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setMerchantNo($xml->getValueNoNull('MerchantNo'));
		$this->setBatchNo($xml->getValueNoNull('BatchNo'));
		$this->setBatchDate($xml->getValueNoNull('BatchDate'));
		$this->setBatchTime($xml->getValueNoNull('BatchTime'));
		$this->setBatchStatus($xml->getValueNoNull('BatchStatus'));
		$this->setAgentAmount($xml->getValueNoNull('AgentAmount'));
		$this->setAgentCount($xml->getValueNoNull('AgentCount'));
		$this->iAgentBatchDetail=$xml->getDocuments('AgentBatchDetail');
	}
	public function checkRequest()
	{
		if(!DataVerifier::isValidStringLen($this->iBatchNo,30))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101,TrxException::TRX_EXC_MSG_1101,'批次号长度超过限制或为空');
		if(!DataVerifier::isValidDate8($this->iBatchDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101,TrxException::TRX_EXC_MSG_1101,'批次日期格式不正确');
		if(!DataVerifier::isValidAmount($this->iAgentAmount,2))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101,TrxException::TRX_EXC_MSG_1101,'委托扣款总金额不正确');
	}

	/**
	 * 取得核准状态的中文说明。
	 * 
	 * @param aStatus
	 *            批量状态代码
	 * @return tStatusChinese 批量状态的中文说明。
	 */
	public function getBatchSatusChinese($aStatus)
	{
		$tStatusChinese='';
		if($aStatus==self::STATUS_UNCHECK)
		{
			$tStatusChinese='批量待复核';
		}
		else if($aStatus==self::STATUS_CHECKSUCCESS)
		{
			$tStatusChinese='批量复核通过待发送';
		}
		else if($aStatus==self::STATUS_REJECT)
		{
			$tStatusChinese='批量复核被驳回';
		}
		else if($aStatus==self::STATUS_SEND)
		{
			$tStatusChinese='批量等待处理';
		}
		else if($aStatus==self::STATUS_SUCCESS)
		{
			$tStatusChinese='批量提交成功';
		}
		else if($aStatus==self::STATUS_FAIL)
		{
			$tStatusChinese='批量提交失败';
		}
		else
		{
			$tStatusChinese='未知状态';
		}
		return $tStatusChinese;
	}
}
/*
$ab=new AgentBatch();
$xml='<MerchantNo>555555555555</MerchantNo><BatchNo>1</BatchNo><BatchDate>20090527</BatchDate>
	  <BatchTime>12:08:09</BatchTime><BatchStatus>0</BatchStatus><AgentAmount>10.00</AgentAmount>
	  <AgentCount>10</AgentCount>
	  <AgentBatchDetail>
	  <OrderNo>3333</OrderNo><OrderAmount>5.00</OrderAmount><CertificateNo>123456789012345</CertificateNo>
	  <ContractID>44444</ContractID><ProductID>ppppp</ProductID><ProductName>name</ProductName><ProductNum>2</ProductNum>
	  <OrderStatus>0</OrderStatus>
	  <OrderNo>2222</OrderNo><OrderAmount>2.00</OrderAmount><CertificateNo>123456789012435</CertificateNo>
	  <ContractID>44445</ContractID><ProductID>pppqqq</ProductID><ProductName>name2</ProductName><ProductNum>4</ProductNum>
	  <OrderStatus>0</OrderStatus>
	  </AgentBatchDetail>';
$ab->constructAgentBatch($xml);
var_dump($ab->getAgentBatchDetail());
echo "<br>";
echo $ab->getAgentAmount()."<br>";
echo $ab->getBatchSatusChinese($ab->getBatchStatus())."<br>";
echo $ab->getAgentCount()."<br>";
echo $ab->getBatchDate()."<br>";
echo $ab->getBatchNo()."<br>";
echo $ab->getBatchTime()."<br>";
echo $ab->getMerchantNo()."<br>";
echo $ab->getTrnxTypeNo()."<br>";//为空，xml中没有给trnxtypeno赋值
if($ab->checkRequest()) echo 'nan '; else echo 'ok ';
*/
?>