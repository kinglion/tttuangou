<?php
class LogWriter
{
    protected $iLogBuffer = '';
    
    private $datatime = null;

    public function __construct()
    {
        $this->datatime = new DateTime('now', new DateTimeZone('PRC'));
    }

    public function closeWriter($aLogFile)
    {
        fwrite($aLogFile,iconv("GB2312","UTF-8",$this->iLogBuffer));
        fclose($aLogFile);
        //$tLogFile = fopen($aLogFile, 'a');
        //fwrite($tLogFile, $this->iLogBuffer);
        //fclose($tLogFile);
         //fwrite($aLogFile,mb_convert_encoding($this->iLogBuffer, 'UTF-8'));
    }

    private function bufferAppend($s)
    {
        $this->iLogBuffer .= $s;
       // echo $s;   //for debug
    }

    public function logNewLine($aLogString)
    {
        //$this->datatime->setTimestamp(time());
        /*$tLogTime = $this->datatime->format('Y/m/d-H:i:s');
        $this->bufferAppend("\n$tLogTime ");
        $this->logs($aLogString);*/
    }

    public function logs($aLogString)
    {
        $aLogString = str_replace("\r", '', $aLogString);
        $aLogString = str_replace("\n", "\n                    ", $aLogString);
        $this->bufferAppend($aLogString);
    }

}

/*
$lw = new LogWriter();
$lw->logNewLine("가가가abc");
sleep(5);
$lw->logNewLine("가가가abcddddd");
$fout = fopen('d://stdout.txt', 'w');
$lw->closeWriter($fout);

/*
$handle=fopen('d://stdout.txt','a');
fwrite($handle,"<SettleFile>\n");
fwrite($handle,"jw");
fclose($handle);
*/

?>