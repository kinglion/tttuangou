</td> </tr> </table> <div class="footer">
<!--<div class="footer" style="background-image:none;"><br><center><p>Powered by <a href="javascript:void(0);" target="_blank" title="志扬互动">志扬互动</a> V4.0.3 © 2005 - 2014 <a href="http://www.cenwor.com" target="_blank">Cenwor Inc.</a></p></center><br></div>-->
</div> 
<? echo ui('loader')->js('#admin/js/'.$this->Module.'.'.$this->Code) ?>
 <?=ui('loader')->js('#admin/js/table.hover')?> <?=ui('loader')->js('#admin/js/footer')?> <?=ui('pingfore')->html()?>
<?=$GLOBALS['iframe']?>
</body> </html>
<? $this->MemberHandler->UpdateSessions(); ?>