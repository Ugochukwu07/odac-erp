
    <style type="text/css"> table td{ border:1px solid #CCC} table tbody tr td, table tr td {
    display: table-cell;
    font-size: 13px;
    line-height: 18px;
}</style>
    
    <section>
    <div class="container">
    <div class="row">
    <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12" >
		<div class="row">
<div class="col-lg-2 col-xs-12"></div>
<div class="col-lg-8 col-xs-12">
<h2 class="h2">
  <button onClick="printData()" class="btn-primary btn pull-right">Print Slip</button>
</h2>
<div class="bottom-bar spacer-10"><div class="bottom-bar-made bottom-bar-width"></div></div>
  
               <div  id="printTable" class="spacer-30">
       <?php  echo bookingslip($fetch,'print');  ?>  
<div class="clear"></div>
</div>
<div class="col-lg-2 col-xs-12"></div>
</div>
</div>
        <div class="spacer-20">&nbsp;</div>
    </div>
    </div>
    </div>
    </section> 
 
<script type="application/javascript">
    function printData()
    {
    var divToPrint=document.getElementById("printTable");
    newWin= window.open("");
    newWin.document.write(divToPrint.outerHTML);
    newWin.print();
    newWin.close();
    }
    
    $('#print_btn').on('click',function(){
    printData();
    });
      </script>	