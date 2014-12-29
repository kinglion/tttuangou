<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('LogWriter') or require(dirname(__FILE__).'/core/LogWriter.php');
/**
 * �̻��˽ӿ������ʵ���࣬�����̻����صĶ��˵���
 */
class CBPSettleFile
{
	/** �������� - ���׶��� */
	const SETTLE_TYPE_TRX    = 'TRX';
	
	/** �������� - ���ǿ����׶��� */
	const SETTLE_TYPE_CREDIT_TRX    = 'CREDIT_TRX';//add by wangchen 2009-06-08
	
	/** �������� - ������� */
	const SETTLE_TYPE_SETTLE = 'SETTLE';
	
	/** �������� - ���װ���ָ��ʱ��� */
	const SETTLE_TYPE_TRX_BYHOUR = 'TRXBYHOUR';
	
	/** �������ڣ�YYYY/MM/DD��*/
	private $iSettleDate = '';
	
	/** �������� */
	private $iSettleType = '';
	
	/** ���˵��ļ�·�� */
	private $iFileName = '';
	
	/** ���˵��ļ����� */
	private $iFileContent = '';
	
	/** �Ƿ���ڶ��˵��ļ� */
	private $iFlag = false;
	
	/**
	 * Class CBPSettleFile ���캯����
	 */
	public function __construct()
	{
		
	}
	
	/**
	 * ��ʼCBPSettleFile ���������
	 * @param aTrxResponse ��ʼ�����TrxResponse����
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
	 * ���潻�׼�¼���ļ�
	 * @param aFileName �ļ���
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
				$tLogWriter->logNewLine('�����ļ��ɹ�,�ļ�·��:'.$this->getFileName());
			}
			}
			catch (Exception $e)
			{
				$tLogWriter->logNewLine('�����ļ��쳣:'.$e->getMessage());
				
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