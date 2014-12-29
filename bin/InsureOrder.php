<?php 
class_exists('XMLDocument') or require(dirname(__FILE__).'/core/XMLDocument.php');
class_exists('InsureOrderItem') or require(dirname(__FILE__).'/InsureOrderItem.php');
class InsureOrder
{
	/** ������ϸ*/
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
	 * ����InsureOrder����
	 */
	public function __construct()
	{
		
	}
	
	/**
	 * ʹ��XML�ļ���ʼ����InsureOrder�����ԡ�
	 * @param aXML ��ʼ�����XML�ļ���
	 * */
	public function constructInsureOrder($aXMLString)
	{
		$xml=new XMLDocument($aXMLString);		
		$this->insureOrderItems=$xml->getDocuments('InsureOrderItem');
	}
	/**
	 * ����������ϸ
	 * @param aOrderItem ������ϸ��OrderItem������
	 * @return ������
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
	 * ���������ϸ
	 * @return ������
	 */
	public function clearOrderItems()
	{
		$this->insureOrderItems=array();
	}
	/**
	 * ��������У�飬������Ϣ�Ƿ�Ϸ�
	 * @return ������Ϣ�Ƿ�Ϸ�
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
	 * ȡ�ö����XML�ļ�
	 * @return XML�ļ�
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