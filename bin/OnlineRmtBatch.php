<?php 
class OnlineRmtBatch 
{
	/**
	 * ��ѯ�����ϸ��ΪQueryResult�����ArrayList���ϡ�
	 */
	private $iQueryResults = array();
	

	/**
	 * ����OnlineRmtBatch����
	 */
	public function __construct()
	{
		
	}
	

	/**
	 * ��ʼ��OnlineRmtBatch����
	 */
	public function constructOnlinRmtBatch($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->iQueryResults=$xml->getValueArray('BatchItem');
	}
	
	public function  addQueryResult($aQueryResult)
	{
		$this->iQueryResults=array_push($this->iQueryResults, $aQueryResult);
	}
	/**
	 * @return the $iQueryResults
	 */
	public function getQueryResults() {
		return $this->iQueryResults;
	}

	/**
	 * @param multitype: $iQueryResults
	 */
	public function setQueryResults($iQueryResults) {
		$this->iQueryResults = $iQueryResults;
	}

	
}
$orb=new OnlineRmtBatch();

?>