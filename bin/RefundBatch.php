<?php 
class RefundBatch
{
	/**
	 *[��׼״̬]���� ���������ˣ�STATUS_UNCHECK
	 */
	const STATUS_UNCHECK = "0";
	
	/**
	 *[��׼״̬]���� ����ͨ�������ͣ�STATUS_CHECKSUCCESS
	 */
	const STATUS_CHECKSUCCESS = "1";
	
	/**
	 *[��׼״̬]���� ���˲��أ�STATUS_REJECT
	 */
	const STATUS_REJECT = "2";
	
	/**
	 *[����״̬]���� ����ͨ�����ѷ���(�ȴ�����)��STATUS_SEND
	 */
	const STATUS_SEND = "3";
	/**
	 *[����״̬]���� ����ɹ���STATUS_SUCCESS
	 */
	const STATUS_SUCCESS = "4";
	/**
	 *[����״̬]���� ����ʧ�ܣ�STATUS_FAIL
	 */
	const STATUS_FAIL = "5";
	
	// ��������״̬����Դ�����ɵ�������ͨ����ѯ�����ڲ����������������̬��ã�������ҳ����ʾ������������״̬��һ��
	/**
	 *[����״̬]���� ���������ж����˿�ɹ���STATUS_ALL_SUCCESS
	 */
	const STATUS_ALL_SUCCESS = "6";
	
	/**
	 *[����״̬]���� ���������ж����˿�ʧ�ܣ�STATUS_ALL_FAIL
	 */
	const STATUS_ALL_FAIL = "7";
	
	/**
	 *[����״̬]���� �����ڲ��ֶ����˿�ɹ���STATUS_PART_SUCCESS
	 */
	const STATUS_PART_SUCCESS = "8";
	
	/**
	 * �̻����
	 */
	private $iMerchantNo = '';
	
	/**
	 * �������
	 */
	private $iBatchNo = '';
	
	/**
	 * ��������
	 */
	private $iBatchDate = '';
	/**
	 * ����ʱ��
	 */
	private $iBatchTime = 0;
	
	/**
	 * �����˿��ܽ��
	 */
	private $iRefundAmount = 0;
	
	/**
	 * �����˿��ܱ���
	 */
	private $iRefundCount = 0;
	
	/**
	 * �������ʹ���
	 */
	private $iTrnxTypeNo = '';
	/**
	 * ����״̬
	 */
	private $iBatchStatus = '';
	
	/** ί�пۿ�����������ϸ��ΪAgentBatchDetail��������顣 */
	private $iAgentBatchDetail = array();
	
	/**
	 * ����RefundBatch����
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
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'���κų��ȳ������ƻ�Ϊ��');
		if(!DataVerifier::isValidDate8($this->iBatchDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'�������ڸ�ʽ����ȷ');
		if(!DataVerifier::isValidAmount($this->iRefundAmount, 2))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'�����˿��ܽ���ȷ');
	}
	
	/**
	 * ȡ�ú�׼״̬������˵����
	 *
	 * @param aStatus
	 *            ����״̬����
	 * @return tStatusChinese ����״̬������˵����
	 */
	public function getBatchSatusChinese($aStatus)
	{
		$tStatusChinese='';
		if($aStatus==self::STATUS_UNCHECK){
			$tStatusChinese='����������';
		}elseif ($aStatus==self::STATUS_CHECKSUCCESS){
			$tStatusChinese='��������ͨ��������';
		}elseif ($aStatus==self::STATUS_REJECT){
			$tStatusChinese='�������˱�����';
		}elseif ($aStatus==self::STATUS_SEND){
			$tStatusChinese='�����ȴ�����';
		}elseif ($aStatus==self::STATUS_SUCCESS){
			$tStatusChinese='�����ύ�ɹ�';
		}elseif ($aStatus==self::STATUS_FAIL){
			$tStatusChinese='�����ύʧ��';
		}else {
			$tStatusChinese='δ֪״̬';
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