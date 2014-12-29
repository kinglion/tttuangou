<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('LogWriter') or require(dirname(__FILE__).'/core/LogWriter.php');
/**
 * 商户端接口软件包实体类，代表商户下载的对账单。
 */
class CBPSettleFile
{
	/** 对账类型 - 交易对账 */
	const SETTLE_TYPE_TRX    = 'TRX';
	
	/** 对账类型 - 贷记卡交易对账 */
	const SETTLE_TYPE_CREDIT_TRX    = 'CREDIT_TRX';//add by wangchen 2009-06-08
	
	/** 对账类型 - 结算对账 */
	const SETTLE_TYPE_SETTLE = 'SETTLE';
	
	/** 对帐类型 - 交易按照指定时间段 */
	const SETTLE_TYPE_TRX_BYHOUR = 'TRXBYHOUR';
	
	/** 对账日期（YYYY/MM/DD）*/
	private $iSettleDate = '';
	
	/** 对账类型 */
	private $iSettleType = '';
	
	/** 对账单文件路径 */
	private $iFileName = '';
	
	/** 对账单文件内容 */
	private $iFileContent = '';
	
	/** 是否存在对账单文件 */
	private $iFlag = false;
	
	/**
	 * Class CBPSettleFile 构造函数。
	 */
	public function __construct()
	{
		
	}
	
	/**
	 * 初始CBPSettleFile 对象的属性
	 * @param aTrxResponse 初始对象的TrxResponse对象。
	 */
	public function constructCBPSettleFile($aTrxResponse,$aFileName)
	{
		$trxRes=new TrxResponse();
		$trxRes->initWithXML($aTrxResponse);
		$this->setFileName($aFileName);
		$this->setSettleDate($trxRes->getValue('SettleDate'));
		$this->setSettleType($trxRes->getValue('SettleType'));
		$this->setFileContent($trxRes->getValue('FileContent'));
		$this->save();
	}
	/**
	 * @return the $iSettleDate
	 */
	public function getSettleDate() {
		return $this->iSettleDate;
	}

	/**
	 * @param string $iSettleDate
	 */
	public function setSettleDate($iSettleDate) {
		$this->iSettleDate = $iSettleDate;
	}

	/**
	 * @return the $iSettleType
	 */
	public function getSettleType() {
		return $this->iSettleType;
	}

	/**
	 * @param string $iSettleType
	 */
	public function setSettleType($iSettleType) {
		$this->iSettleType = $iSettleType;
	}

	/**
	 * @return the $iFileName
	 */
	public function getFileName() {
		return $this->iFileName;
	}

	/**
	 * @param string $iFileName
	 */
	public function setFileName($iFileName) {
		$this->iFileName = $iFileName;
	}

	/**
	 * @return the $iFileContent
	 */
	public function getFileContent() {
		return $this->iFileContent;
	}

	/**
	 * @param string $iFileContent
	 */
	public function setFileContent($iFileContent) {
		$this->iFileContent = $iFileContent;
	}

	/**
	 * @return the $iFlag
	 */
	public function getFlag() {
		return $this->iFlag;
	}

	/**
	 * @param boolean $iFlag
	 */
	public function setFlag($iFlag) {
		$this->iFlag = $iFlag;
	}
	/**
	 * 保存交易记录至文件
	 * @param aFileName 文件名
	 * @return
	 */
	public function save()
	{
		$fileContent=$this->getFileContent();
		$tLogWriter=new LogWriter();
		if($fileContent!=null)
		{
			$this->setFlag(true);
			try {
			$content=base64_decode($fileContent);
			$handle=fopen($this->getFileName(), 'a');
			if($handle!=false)
			{
				fwrite($handle, $content);
				fclose($handle);
				$tLogWriter->logNewLine('保存文件成功,文件路径:'.$this->getFileName());
			}
			}
			catch (Exception $e)
			{
				$tLogWriter->logNewLine('保存文件异常:'.$e->getMessage());
				
			}
		}
		else {
			$this->setFlag(false);
		}
	}
}


/*
$tSettleFile=new CBPSettleFile();
$aFileContent=base64_encode('aa');
$content=base64_decode($aFileContent);
$tSettleFile->setFileContent($aFileContent);
$tSettleFile->setFileName('E:\\test1.zip');
$tSettleFile->save();
if($tSettleFile->getFlag())  echo 'success';
else echo 'fail';
 */
?>