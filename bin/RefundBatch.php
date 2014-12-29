<?php 
class RefundBatch
{
	/**
	 *[核准状态]属性 批量待复核：STATUS_UNCHECK
	 */
	const STATUS_UNCHECK = "0";
	
	/**
	 *[核准状态]属性 复核通过待发送：STATUS_CHECKSUCCESS
	 */
	const STATUS_CHECKSUCCESS = "1";
	
	/**
	 *[核准状态]属性 复核驳回：STATUS_REJECT
	 */
	const STATUS_REJECT = "2";
	
	/**
	 *[批量状态]属性 复核通过后已发送(等待处理)：STATUS_SEND
	 */
	const STATUS_SEND = "3";
	/**
	 *[批量状态]属性 处理成功：STATUS_SUCCESS
	 */
	const STATUS_SUCCESS = "4";
	/**
	 *[批量状态]属性 处理失败：STATUS_FAIL
	 */
	const STATUS_FAIL = "5";
	
	// 以下三种状态仅针对处理完成的批量，通过查询批量内部各订单交易情况动态获得，仅用于页面显示，并不是批量状态的一种
	/**
	 *[批量状态]属性 批量内所有订单退款成功：STATUS_ALL_SUCCESS
	 */
	const STATUS_ALL_SUCCESS = "6";
	
	/**
	 *[批量状态]属性 批量内所有订单退款失败：STATUS_ALL_FAIL
	 */
	const STATUS_ALL_FAIL = "7";
	
	/**
	 *[批量状态]属性 批量内部分订单退款成功：STATUS_PART_SUCCESS
	 */
	const STATUS_PART_SUCCESS = "8";
	
	/**
	 * 商户编号
	 */
	private $iMerchantNo = '';
	
	/**
	 * 批量编号
	 */
	private $iBatchNo = '';
	
	/**
	 * 批量日期
	 */
	private $iBatchDate = '';
	/**
	 * 批量时间
	 */
	private $iBatchTime = 0;
	
	/**
	 * 批量退款总金额
	 */
	private $iRefundAmount = 0;
	
	/**
	 * 批量退款总笔数
	 */
	private $iRefundCount = 0;
	
	/**
	 * 交易类型代码
	 */
	private $iTrnxTypeNo = '';
	/**
	 * 批量状态
	 */
	private $iBatchStatus = '';
	
	/** 委托扣款批量订单明细。为AgentBatchDetail对象的数组。 */
	private $iAgentBatchDetail = array();
	
	/**
	 * 构造RefundBatch对象
	 */
	public function __construct()
	{
		$this->iAgentBatchDetail=array();
	}
	
	public function constructRefundBatch($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->iAgentBatchDetail=array();
		$this->setMerchantNo($xml->getValueNoNull('MerchantNo'));
		$this->setBatchNo($xml->getValueNoNull('BatchNo'));
		$this->setBatchDate($xml->getValueNoNull('BatchDate'));
		$this->setBatchTime($xml->getValueNoNull('BatchTime'));
		$this->setBatchStatus($xml->getValueNoNull('BatchStatus'));
		$this->setRefundAmount($xml->getValueNoNull('AgentAmount'));
		$this->setRefundCount($xml->getValueNoNull('AgentCount'));
		$this->iAgentBatchDetail=$xml->getValueArray('AgentBatchDetail');
	}
	
	public function checkRequest()
	{
		if(!DataVerifier::isValidStringLen($this->iBatchNo,30))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'批次号长度超过限制或为空');
		if(!DataVerifier::isValidDate8($this->iBatchDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'批次日期格式不正确');
		if(!DataVerifier::isValidAmount($this->iRefundAmount, 2))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'批量退款总金额不正确');
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
		if($aStatus==self::STATUS_UNCHECK){
			$tStatusChinese='批量待复核';
		}elseif ($aStatus==self::STATUS_CHECKSUCCESS){
			$tStatusChinese='批量复核通过待发送';
		}elseif ($aStatus==self::STATUS_REJECT){
			$tStatusChinese='批量复核被驳回';
		}elseif ($aStatus==self::STATUS_SEND){
			$tStatusChinese='批量等待处理';
		}elseif ($aStatus==self::STATUS_SUCCESS){
			$tStatusChinese='批量提交成功';
		}elseif ($aStatus==self::STATUS_FAIL){
			$tStatusChinese='批量提交失败';
		}else {
			$tStatusChinese='未知状态';
		}
		return $tStatusChinese;
	}
	
	public function addAgentBatchDetail($aAgentBatchDetail)
	{
		if(!$this->iAgentBatchDetail)
		{
			$this->iAgentBatchDetail=array();
			$this->iAgentBatchDetail[0]=$aAgentBatchDetail;
		}
		else 
		{
			$num=count($this->iAgentBatchDetail);
			$this->iAgentBatchDetail[num]=$aAgentBatchDetail;
		}
	}
	/**
	 * @return the $iMerchantNo
	 */
	public function getMerchantNo() {
		return $this->iMerchantNo;
	}

	/**
	 * @param string $iMerchantNo
	 */
	public function setMerchantNo($iMerchantNo) {
		$this->iMerchantNo = $iMerchantNo;
	}

	/**
	 * @return the $iBatchNo
	 */
	public function getBatchNo() {
		return $this->iBatchNo;
	}

	/**
	 * @param string $iBatchNo
	 */
	public function setBatchNo($iBatchNo) {
		$this->iBatchNo = $iBatchNo;
	}

	/**
	 * @return the $iBatchDate
	 */
	public function getBatchDate() {
		return $this->iBatchDate;
	}

	/**
	 * @param string $iBatchDate
	 */
	public function setBatchDate($iBatchDate) {
		$this->iBatchDate = $iBatchDate;
	}

	/**
	 * @return the $iBatchTime
	 */
	public function getBatchTime() {
		return $this->iBatchTime;
	}

	/**
	 * @param number $iBatchTime
	 */
	public function setBatchTime($iBatchTime) {
		$this->iBatchTime = $iBatchTime;
	}

	/**
	 * @return the $iRefundAmount
	 */
	public function getRefundAmount() {
		return $this->iRefundAmount;
	}

	/**
	 * @param number $iRefundAmount
	 */
	public function setRefundAmount($iRefundAmount) {
		$this->iRefundAmount = $iRefundAmount;
	}

	/**
	 * @return the $iRefundCount
	 */
	public function getRefundCount() {
		return $this->iRefundCount;
	}

	/**
	 * @param number $iRefundCount
	 */
	public function setRefundCount($iRefundCount) {
		$this->iRefundCount = $iRefundCount;
	}

	/**
	 * @return the $iTrnxTypeNo
	 */
	public function getTrnxTypeNo() {
		return $this->iTrnxTypeNo;
	}

	/**
	 * @param string $iTrnxTypeNo
	 */
	public function setTrnxTypeNo($iTrnxTypeNo) {
		$this->iTrnxTypeNo = $iTrnxTypeNo;
	}

	/**
	 * @return the $iBatchStatus
	 */
	public function getBatchStatus() {
		return $this->iBatchStatus;
	}

	/**
	 * @param string $iBatchStatus
	 */
	public function setBatchStatus($iBatchStatus) {
		$this->iBatchStatus = $iBatchStatus;
	}

	/**
	 * @return the $iAgentBatchDetail
	 */
	public function getAgentBatchDetail() {
		return $this->iAgentBatchDetail;
	}

	
	
}
?>