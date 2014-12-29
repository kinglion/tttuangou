<?php 
class OnlineRemitRequest extends TrxRequest
{
	/**
	 * 付款总笔数
	 */
	private $iTotalCount = 0;
	
	/**
	 * 付款总金额
	 */
	private $iTotalAmount = 0;
	
	/**
	 * 付款批量批次号
	 */
	private $sSerialNumber = '';
	
	/**
	 *  确认形式（目前暂时只支持1,0有待业务提需求再开发）
	 */
	private $sCheckType = '1';
	
	/**
	 * 备注
	 */
	private $sRemark = '';
	
	private $iRemitlist = array();
	
	/**
	 * 构造OnlineRemitRequest对象
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
	 * 网上付款请求信息是否合法
	 * @throws TrxException: 网上付款请求不合法
	 */
	protected function checkRequest()
	{
		
		if($this->iTotalCount != count($this->iRemitlist[0]))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'付款总笔数与明细笔数不一致!');
		if(strlen(trim($this->sSerialNumber)) == 0)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'付款流水号不能为空！');
		if($this->iTotalCount <= 0)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'付款交易总笔数不能小于1笔！');
		if($this->iTotalCount >=100)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'付款交易总笔数不能大于100笔！');
		if($this->iTotalAmount <= 0 || (!DataVerifier::isValidAmount($this->iTotalAmount, 2)))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'付款交易总金额不合法！');
			for($j=0; $j< $this->iTotalCount; $j++)
			{
			if(strlen($this->iRemitlist[0][$j]) > 5 || strlen($this->iRemitlist[0][$j]) < 1 )
				throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'批次内序号需要在1至5位之间:'.$this->iRemitlist[0][$j]);
			if(strlen(trim($this->iRemitlist[1][$j])) < 1)
				throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'付款明细卡号不能为空!'.$this->iRemitlist[1][$j]);
			if(strlen(trim($this->iRemitlist[2][$j])) < 1)
				throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'付款明细收款人信息不能为空!'.$this->iRemitlist[2][$j]);
			$iRmtAmount = $this->iRemitlist[3][$j];
			if($iRmtAmount <= 0 || (!DataVerifier::isValidAmount($iRmtAmount, 2)))
				throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'付款交易总金额不合法！'.$iRmtAmount);
			if(strlen(trim($this->iRemitlist[4][$j])) > 30)
				throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'明细内容不能超过30个字：'.$this->iRemitlist[4][$j]);
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