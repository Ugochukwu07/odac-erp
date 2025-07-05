    <script type="text/javascript">
       $(document).ready(function(){
      var i=1;
     $("#add_row").click(function(){
      $('#addr'+i).html("</td><td><input name='name"+i+"' type='text' placeholder='Hotel City Name' class='form-control input-md'  /> </td><td><input  name='mail"+i+"' type='text' placeholder='Hotel Name'  class='form-control input-md'></td><td><input  name='mobile"+i+"' type='text' placeholder='Star'  class='form-control input-md'></td>");

      $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
      i++; 
  });
     $("#delete_row").click(function(){
       if(i>1){
     $("#addr"+(i-1)).html('');
     i--;
     }
   });

});
</script>



 <script type="text/javascript">
       $(document).ready(function(){
      var a=1;
     $("#add_row1").click(function(){
      $('#tb'+a).html("</td><td><input name='name"+a+"' type='text' placeholder='Adult' class='form-control input-md'  /> </td><td><input  name='mail"+a+"' type='text' placeholder='Above 12 Years'  class='form-control input-md'></td><td><input  name='mobile"+a+"' type='text' placeholder='Price'  class='form-control input-md'></td>");

      $('#tab_logic1').append('<tr id="tb'+(a+1)+'"></tr>');
      a++; 
  });
     $("#delete_row1").click(function(){
       if(a>1){
     $("#tb"+(a-1)).html('');
     a--;
     }
   });

});
</script>