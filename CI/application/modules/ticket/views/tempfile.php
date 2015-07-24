<?php
//echo "<pre>";
//print_r($filedet);
//echo "</pre>";
if(!empty($filedet))
{
?>
<ul>
  <?php
  foreach($filedet as $filedetlist)
  {
    $txt = "";
    if(!empty($filedetlist['scan']))
    {
      $txt = " <strong class='scanthreat'>[Virus detected!]<strong>";
    }
  ?>
  <li id="delfil<?php echo $filedetlist['id'];?>">
    <?php echo $filedetlist['filename'].$txt;?>
    <span onclick="delfile('<?php echo $filedetlist['id'];?>','<?php echo $filedetlist['filename'];?>')"><i class="fa fa-times-circle"></i></span>
    <?php if(empty($filedetlist['scan'])){ ?>
    <input type="hidden" name="files[]" readonly="true" value="<?php echo $filedetlist['filename'];?>" />
    <?php } ?>
  </li>
  <?php
  }
  ?>
</ul>
<?php
}
?>