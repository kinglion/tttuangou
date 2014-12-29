<?php 
class RefundBatchDetail
{
	/**
	 *[״̬]����
	 *δ����STATUS_UNDONE
	 */
	const STATUS_UNDONE = "X";
	
	/**
	 *[״̬]����
	 *�ɹ���STATUS_SUCCESS
	 */
	const STATUS_SUCCESS = "0";
	
	/**
	 *[״̬]����
	 *ʧ�ܣ�STATUS_FAIL
	 */
	const STATUS_FAIL = "1";
	
	/**
	 *[״̬]����
	 *�޻�Ӧ��STATUS_FAIL
	 */
	const STATUS_NORESPONSE = "2";
	
	/** ���������󳤶� */
	const ORDER_NO_LEN = 50;
	/**
	 * �̻����
	 */
	private $iMerchantNo = '';
	/**
	 * ���α��
	 */
	private $iBatchNo = '';
	
	/**
	 * ��������
	 */
	private $iBatchDate = '';
	
	/**
	 * �˵����
	 */
	private $iOrderNo = '';
	
	/**
	 * �˵����
	 */
	private $iNewOrderNo = '';
	
	/**
	 * �˵����
	 */
	private $iOrderAmount = 0;
	
	/**
	 * ����״̬
	 */
	private $iOrderStatus = '';
	
	/**
	 * �˵�����
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
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'�����Ų��Ϸ�');
		if(!DataVerifier::isValidString($this->iNewOrderNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'�¶����Ų��Ϸ�');
		if(!DataVerifier::isValidAmount($this->iOrderAmount, 2))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'�˵����Ϸ�');
	}
	/**
	 * �趨����״̬
	 *
	 * @param aOrderStatus
	 *            ����״̬<br>
	 *            Order.ORDER_STATUS_CANCEL : ����ȡ��<br>
	 *            Order.ORDER_STATUS_NEW : �����������ȴ�֧��<br>
	 *            Order.ORDER_STATUS_WAIT : ��������֧�����ȴ�֧�����<br>
	 *            Order.ORDER_STATUS_PAY : ������֧��<br>
	 *            Order.ORDER_STATUS_SETTLED: �����ѽ���<br>
	 *            Order.ORDER_STATUS_REFUND : �������˿�<br>
	 *            Order.ORDER_STATUS_ISSUE : ����������<br>
	 * @return ������
	 */
	public function getStatusChinese($aStatus)
	{
		/*
		 * ���������ڶ���״̬���룬�ش�״̬������˵��
		 */
		$tStatusChinese='';
		if($aStatus==self::STATUS_UNDONE)
			$tStatusChinese='δ����';
		elseif ($aStatus==self::STATUS_NORESPONSE)
			$tStatusChinese='�޻�Ӧ';
		elseif ($aStatus==self::STATUS_SUCCESS)
			$tStatusChinese='����ɹ�';
		elseif ($aStatus==self::STATUS_FAIL)
			$tStatusChinese='����ʧ��';
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