<?php 
class_exists('XMLDocument') or require(dirname(__FILE__).'/core/XMLDocument.php');
class_exists('InsureOrderItem') or require(dirname(__FILE__).'/InsureOrderItem.php');
class InsureOrder
{
	/** 保单明细*/
	private $insureOrderItems = array();
	
	/**
	 * @return the $insureOrderItems
	 */
	public function getInsureOrderItems() {
		return $this->insureOrderItems;
	}

	/**
	 * @param multitype: $insureOrderItems
	 */
	public function setInsureOrderItems($insureOrderItems) {
		$this->insureOrderItems =$this->insureOrderItems+ $insureOrderItems;
	}
	/**
	 * 构造InsureOrder对象
	 */
	public function __construct()
	{
		
	}
	
	/**
	 * 使用XML文件初始对象InsureOrder的属性。
	 * @param aXML 初始对象的XML文件。
	 * */
	public function constructInsureOrder($aXMLString)
	{
		$xml=new XMLDocument($aXMLString);		
		$this->insureOrderItems=$xml->getDocuments('InsureOrderItem');
	}
	/**
	 * 新增保单明细
	 * @param aOrderItem 保单明细（OrderItem）对象
	 * @return 对象本身
	 */
	public function addOrderItem($ansureOrderItem)
	{
		if(!$this->insureOrderItems)
		{
			$this->insureOrderItems=array();
			$this->insureOrderItems[0]=$ansureOrderItem;
		}
		else 
		{
			array_push($this->insureOrderItems, $ansureOrderItem);
		}	
	}
	/**
	 * 清除保单明细
	 * @return 对象本身
	 */
	public function clearOrderItems()
	{
		$this->insureOrderItems=array();
	}
	/**
	 * 基本数据校验，保单信息是否合法
	 * @return 保单信息是否合法
	 */
	public function isValid()
	{
		for($i=0;$i<count($this->insureOrderItems);$i++)
		{
			$tIoi=new InsureOrderItem();
			$tIoi->constructInsureOrderItem($this->insureOrderItems[$i]);
			$tError=$tIoi->isValid();
			if(strlen($tError)>0)
				return $tError;	
		}
		return '';
	}	
	/**
	 * 取得对象的XML文件
	 * @return XML文件
	 */
	public function getXMLDocument()
	{
		$tXml='';
		for($i=0;$i<count($this->insureOrderItems);$i++)
		{
			$insureOrderItem=new InsureOrderItem();
			$insureOrderItem->constructInsureOrderItem($this->insureOrderItems[$i]);
			$tXml.=$insureOrderItem->getXMLDocument();
		}
		return $tXml;
		
	}
	
}
/*
$io=new InsureOrder();
$xml='<Orders>
	 <InsureOrderItem>
	 <Amount>308.02</Amount><Name>cxl</Name><Code>nice</Code><Category>wow</Category><Mode>aha</Mode>
	 </InsureOrderItem>
	 <InsureOrderItem>
	 <Amount>333.02</Amount><Name>jw</Name><Code>great</Code><Category>mom</Category><Mode>xixi</Mode>
	 </InsureOrderItem>
	 </Orders>';
 $io->constructInsureOrder($xml);
 echo $io->getXMLDocument()."<br/>";
 echo count($io->getInsureOrderItems())."<br>";
 if(!$io->isValid()) echo 'hah';
*/

?>