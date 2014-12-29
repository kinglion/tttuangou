<?php 
class OnlineRemitRequest extends TrxRequest
{
	/**
	 * �����ܱ���
	 */
	private $iTotalCount = 0;
	
	/**
	 * �����ܽ��
	 */
	private $iTotalAmount = 0;
	
	/**
	 * �����������κ�
	 */
	private $sSerialNumber = '';
	
	/**
	 *  ȷ����ʽ��Ŀǰ��ʱֻ֧��1,0�д�ҵ���������ٿ�����
	 */
	private $sCheckType = '1';
	
	/**
	 * ��ע
	 */
	private $sRemark = '';
	
	private $iRemitlist = array();
	
	/**
	 * ����OnlineRemitRequest����
	 *
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	*/
	protected function getRequestMessage() {
		// TODO Auto-generated method stub
		$str1='<TrxRequest>'.
			 '<TrxType>'.TrxType::TRX_TYPE_B2C_ONLINEREMIT_REQ.'</TrxType>'.
			 '<CheckType>'.$this->sCheckType.'</CheckType>'.
			 '<SerialNumber>'.$this->sCheckType.'</SerialNumber>'.
			 '<TotalCount>'.$this->iTotalCount.'</TotalCount>'.
			 '<TotalAmount>'.$this->iTotalAmount.'</TotalAmount>'.
			 '<Remark>'.$this->sRemark.'</Remark>'.
			 '<RemitData>';
		$str2='';
	
			for($j=0;$j<$this->iTotalCount;$j++)
			{
				$str2.='<RemitDetail>'.
				   '<NO>'.$this->iRemitlist[0][$j].'</NO>'.
				   '<CardNo>'.$this->iRemitlist[1][$j].'</CardNo>'.
				   '<CardName>'.$this->iRemitlist[2][$j].'</CardName>'.
				   '<RemitAmount>'.$this->iRemitlist[3][$j].'</RemitAmount>'.
				   '<Purpose>'.$this->iRemitlist[4][$j].'</Purpose>'.
				   '</RemitDetail>';	 
			}
		$str3='</RemitData>'.
			  '</TrxRequest>';
		return $str1.$str2.$str3;	 
	}
	/**
	 * ���ϸ���������Ϣ�Ƿ�Ϸ�
	 * @throws TrxException: ���ϸ������󲻺Ϸ�
	 */
	protected function checkRequest()
	{
		
		if($this->iTotalCount != count($this->iRemitlist[0]))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'�����ܱ�������ϸ������һ��!');
		if(strlen(trim($this->sSerialNumber)) == 0)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'������ˮ�Ų���Ϊ�գ�');
		if($this->iTotalCount <= 0)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'������ܱ�������С��1�ʣ�');
		if($this->iTotalCount >=100)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'������ܱ������ܴ���100�ʣ�');
		if($this->iTotalAmount <= 0 || (!DataVerifier::isValidAmount($this->iTotalAmount, 2)))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'������ܽ��Ϸ���');
			for($j=0; $j< $this->iTotalCount; $j++)
			{
			if(strlen($this->iRemitlist[0][$j]) > 5 || strlen($this->iRemitlist[0][$j]) < 1 )
				throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'�����������Ҫ��1��5λ֮��:'.$this->iRemitlist[0][$j]);
			if(strlen(trim($this->iRemitlist[1][$j])) < 1)
				throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'������ϸ���Ų���Ϊ��!'.$this->iRemitlist[1][$j]);
			if(strlen(trim($this->iRemitlist[2][$j])) < 1)
				throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'������ϸ�տ�����Ϣ����Ϊ��!'.$this->iRemitlist[2][$j]);
			$iRmtAmount = $this->iRemitlist[3][$j];
			if($iRmtAmount <= 0 || (!DataVerifier::isValidAmount($iRmtAmount, 2)))
				throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'������ܽ��Ϸ���'.$iRmtAmount);
			if(strlen(trim($this->iRemitlist[4][$j])) > 30)
				throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'��ϸ���ݲ��ܳ���30���֣�'.$this->iRemitlist[4][$j]);
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
	 * @return the $sSerialNumber
	 */
	public function getSerialNumber() {
		return $this->sSerialNumber;
	}

	/**
	 * @param string $sSerialNumber
	 */
	public function setSerialNumber($sSerialNumber) {
		$this->sSerialNumber = $sSerialNumber;
	}

	/**
	 * @return the $sCheckType
	 */
	public function getCheckType() {
		return $this->sCheckType;
	}

	/**
	 * @param string $sCheckType
	 */
	public function setCheckType($sCheckType) {
		$this->sCheckType = $sCheckType;
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
	 * @return the $iRemitlist
	 */
	public function getRemitlist() {
		return $this->iRemitlist;
	}

	/**
	 * @param multitype: $iRemitlist
	 */
	public function setRemitlist($iRemitlist) {
		$this->iRemitlist = $iRemitlist;
	}


	
}
?>