<?php 
class RefundBatchDetail
{
	/**
	 *[状态]属性
	 *未处理：STATUS_UNDONE
	 */
	const STATUS_UNDONE = "X";
	
	/**
	 *[状态]属性
	 *成功：STATUS_SUCCESS
	 */
	const STATUS_SUCCESS = "0";
	
	/**
	 *[状态]属性
	 *失败：STATUS_FAIL
	 */
	const STATUS_FAIL = "1";
	
	/**
	 *[状态]属性
	 *无回应：STATUS_FAIL
	 */
	const STATUS_NORESPONSE = "2";
	
	/** 订单编号最大长度 */
	const ORDER_NO_LEN = 50;
	/**
	 * 商户编号
	 */
	private $iMerchantNo = '';
	/**
	 * 批次编号
	 */
	private $iBatchNo = '';
	
	/**
	 * 批次日期
	 */
	private $iBatchDate = '';
	
	/**
	 * 账单编号
	 */
	private $iOrderNo = '';
	
	/**
	 * 账单编号
	 */
	private $iNewOrderNo = '';
	
	/**
	 * 账单金额
	 */
	private $iOrderAmount = 0;
	
	/**
	 * 订单状态
	 */
	private $iOrderStatus = '';
	
	/**
	 * 账单币种
	 */
	private $iCurrency = '';
	
	public function __construct()
	{
		
	}
	
	public function constructRefundBatchDetail($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setOrderNo($xml->getValueNoNull('OrderNo'));
		$this->setNewOrderNo($xml->getValueNoNull('NewOrderNo'));
		$this->setOrderAmount($xml->getValueNoNull('OrderAmount'));
		$this->setOrderNo($xml->getValueNoNull('OrderStatus'));
	}
	
	public function checkRequest()
	{
		if(!DataVerifier::isValidString($this->iOrderNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'订单号不合法');
		if(!DataVerifier::isValidString($this->iNewOrderNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'新订单号不合法');
		if(!DataVerifier::isValidAmount($this->iOrderAmount, 2))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'账单金额不合法');
	}
	/**
	 * 设定订单状态
	 *
	 * @param aOrderStatus
	 *            订单状态<br>
	 *            Order.ORDER_STATUS_CANCEL : 订单取消<br>
	 *            Order.ORDER_STATUS_NEW : 订单建立，等待支付<br>
	 *            Order.ORDER_STATUS_WAIT : 消费者已支付，等待支付结果<br>
	 *            Order.ORDER_STATUS_PAY : 订单已支付<br>
	 *            Order.ORDER_STATUS_SETTLED: 订单已结算<br>
	 *            Order.ORDER_STATUS_REFUND : 订单已退款<br>
	 *            Order.ORDER_STATUS_ISSUE : 订单有争议<br>
	 * @return 对象本身
	 */
	public function getStatusChinese($aStatus)
	{
		/*
		 * 传入批量内订单状态代码，回传状态的中文说明
		 */
		$tStatusChinese='';
		if($aStatus==self::STATUS_UNDONE)
			$tStatusChinese='未处理';
		elseif ($aStatus==self::STATUS_NORESPONSE)
			$tStatusChinese='无回应';
		elseif ($aStatus==self::STATUS_SUCCESS)
			$tStatusChinese='处理成功';
		elseif ($aStatus==self::STATUS_FAIL)
			$tStatusChinese='处理失败';
		return $tStatusChinese;
		
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
	 * @return the $iOrderNo
	 */
	public function getOrderNo() {
		return $this->iOrderNo;
	}

	/**
	 * @param string $iOrderNo
	 */
	public function setOrderNo($iOrderNo) {
		$this->iOrderNo = $iOrderNo;
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
		$this->iNewOrderNo = $iNewOrderNo;
	}

	/**
	 * @return the $iOrderAmount
	 */
	public function getOrderAmount() {
		return $this->iOrderAmount;
	}

	/**
	 * @param number $iOrderAmount
	 */
	public function setOrderAmount($iOrderAmount) {
		$this->iOrderAmount = $iOrderAmount;
	}

	/**
	 * @return the $iOrderStatus
	 */
	public function getOrderStatus() {
		return $this->iOrderStatus;
	}

	/**
	 * @param string $iOrderStatus
	 */
	public function setOrderStatus($iOrderStatus) {
		$this->iOrderStatus = $iOrderStatus;
	}

	/**
	 * @return the $iCurrency
	 */
	public function getCurrency() {
		return $this->iCurrency;
	}

	/**
	 * @param string $iCurrency
	 */
	public function setCurrency($iCurrency) {
		$this->iCurrency = $iCurrency;
	}

	
	
}
?>