<?php
class XMLDocument
{
    private $iXMLString = '';


    public function getFirstTagName()
    {
        $tTagName = null;
        $tStartIndex = strpos($this->iXMLString, '<');
        $tEndIndex = strpos($this->iXMLString, '>');
        if ($tEndIndex > $tStartIndex)
        {
            $tTagName = substr($this->iXMLString, $tStartIndex + 1, $tEndIndex - ($tStartIndex + 1));
        }

        return $tTagName;
    }

    public function __construct($aXMLString='')
    {
        $this->init($aXMLString);
    }

    public function init($aXMLString)
    {
        $this->iXMLString = $aXMLString;
        return $this;
    }

    public function __toString()
    {
        return trim($this->iXMLString);
    }

    public function getValue($aTag)
    {
        $tXMLDocument = null;
        $tStartIndex = strpos($this->iXMLString, '<'.trim($aTag).'>');
        $tEndIndex = strpos($this->iXMLString, '</'.trim($aTag).'>');
        if (($tStartIndex !== FALSE) && ($tEndIndex !== FALSE) && ($tStartIndex < $tEndIndex))
        {
            $tXMLDocument = new XMLDocument(substr($this->iXMLString, $tStartIndex + strlen($aTag) + 2, $tEndIndex - ($tStartIndex + strlen($aTag) + 2)));
        }
        return $tXMLDocument;
    }
    
    public function getValueNoNull($aTag)
    {
        $tValue = "";
        $tXML = $this->getValue($aTag);
        if ($tXML !== null)
        {
            $tValue = $tXML->__toString();
        }
        return $tValue;
    }

    public function getValueArray($aTag)
    {
        $tValues = array();
        $offset = 0;
        while(TRUE)
        {
            $tStartIndex = strpos($this->iXMLString, '<'.trim($aTag).'>', $offset);
            $tEndIndex = strpos($this->iXMLString, '</'.trim($aTag).'>', $offset);
            if (($tStartIndex === FALSE) || ($tEndIndex === FALSE) || ($tStartIndex > $tEndIndex))
            {
                break;
            }
            array_push($tValues, new XMLDocument(substr($this->iXMLString, $tStartIndex + strlen($aTag) + 2, $tEndIndex - ($tStartIndex + strlen($aTag) + 2))));
            $offset = $tEndIndex + 1;
        }
        return $tValues;
    }

    public function getValueArrayList($aTag)
    {
        return $this-> getValueArray($aTag);
    }

    public function getDocuments($aTag)
    {
        return $this-> getValueArray($aTag);
    }
    
    public function getFormatDocument($aSpace)
    {
        return $this->getFormatDocumentLevel(0, $aSpace);
    }


    private function getFormatDocumentLevel($aLevel, $aSpace)
    {
        $tSpace1 = str_repeat($aSpace, $aLevel + 1);
        $tTagName = $this->getFirstTagName();
        if ($tTagName === null)
        {
            return $this;
        }
        $tXMLString = "\n";
        $tXMLDocument = new XMLDocument($this->iXMLString);
        while (($tTagName = $tXMLDocument->getFirstTagName()) !== null)
        {
            $tTemp = $tXMLDocument->getValue($tTagName);
            $tSpace = "";
            
            if ($tTemp->getFirstTagName() !== null)
            {
                $tSpace = $tSpace1;
            }
            $tXMLString = "$tXMLString$tSpace1<$tTagName>".$tTemp->getFormatDocumentLevel($aLevel + 1, $aSpace)."$tSpace</$tTagName>\n";
            $tXMLDocument = $tXMLDocument->deleteFirstTagDocument();
                       
        }
        return new XMLDocument($tXMLString);
    }

    public function deleteFirstTagDocument()
    {
        $tTagName = $this->getFirstTagName();
        $tStartIndex = strpos($this->iXMLString, "<$tTagName>");
        $tEndIndex = strpos($this->iXMLString, "</$tTagName>");
        if ($tEndIndex > $tStartIndex)
        {
            $this->iXMLString = substr($this->iXMLString, $tEndIndex + strlen($tTagName) + 3);
            if ($this->iXMLString === FALSE)
            {
                $this->iXMLString = "";
            }
        }
        return $this;
    }

}
/*
$xml = new XMLDocument('<?xml version="1.0" ?><root><tag1>1111</tag1><tag1>111221</tag1><tag2>22222</tag2><aaa><bbb>bbb</bbb></aaa></root>');
var_dump($xml);

$str2 = <<<XML

XML;
$str='<?xml version="1.0" encoding="utf-8" ?>
<root>
<tag1>1111</tag1>
<tag1>111221</tag1>
<tag2>22222</tag2>
<aaa>
<bbb>bbb</bbb>
</aaa>
</root>';
$str='';
$xml=simplexml_load_string($str);
var_dump($xml);
echo $xml;
*/
//->__toString();
//echo $xml->getFormatDocument('    ');
//
//echo $xml->getValueNoNull('tag2');
//echo "\n";
//echo $xml->getValue('tag1');

//var_dump($xml->getValueArray('tag1'));
//echo "**************";
//var_dump($xml2=$xml->deleteFirstTagDocument());



?>
