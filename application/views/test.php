
                                    <form id="Login"  action="<?php echo base_url('Search_result/?')?>" method="GET">
                                       
                                       <!-- this is useed for store temp data start-->
                                        <input type="hidden"  id="geoselector" value="">
                                       <!-- this is useed for store temp data end  -->
                                       

                                       <input type="hidden" name="tabmenu" id="tabmenu" value="<?php echo $tabmenu ? $tabmenu : 'radio';?>">
                                       <input type="hidden" name="validcity" id="validcity" value="<?php echo $validcity ? $validcity : '';?>">
                                       <div class="form-group">
                                          <input type="text" name="source" class="form-control" id="Pickup_Point" placeholder="Enter Pickup Point" onclick="showgetplace('Pickup_Point');" value="<?= $source;?>" autocomplete="off" />
                                       </div>
                                       <div class="form-group" id="dropcitydiv">
                                          <input type="text" name="destination" class="form-control" id="Drop_Point" placeholder="Enter Drop Point"  onclick="showgetplace('Drop_Point');"  value="<?= $destination;?>" autocomplete="off" />
                                       </div>

                                       <div class="form-group" id="localpackagediv">
                                          <select name="package" class="form-control" id="package" ></select> 
                                       </div>


               <div class="form-group" id="multitrip">
               <select name="tripemode" class="form-control" id="multitriptype" onchange="multiip();">
               <option value="oneway">Oneway</option>
               <option value="roundtrip">Roundtrip</option>
               <option value="multicity">Multicity</option>
               </select>
               </div>


                                       <div class="form-group" id="nowdiv">
                                          <select name="when" class="form-control" id="when" onchange="fornow();">
                                             <option value="now">Now</option>
                                             <option value="later">Schedule for Later</option>
                                          </select>
                                       </div>


                                       <div class="row" id="datediv">
                                          <div class="col-xs-6 col-lg-6 pull-left">
                                            <select name="pickupdate" class="form-control" id="pickdate" onchange="settimee('pick');"> 
                                            </select> 
                                          </div>
                                         <div class="col-xs-6 col-lg-6 pull-left">
                                          <input type="text" name="pickuptime" class="form-control" id="picktime" placeholder="Enter Pickup Time" autocomplete="off">
                                             
                                          </div>
                                       </div>


            <div class="row" id="dropdatediv">
            <div class="col-xs-6 col-lg-6 pull-left mt-0 mt-2 mt-md-3 ">
              <select name="returndate" class="form-control" id="returndate" onchange="settimee();">
               <option value="">Return</option>
              </select> 
            </div>
           <div class="col-xs-6 col-lg-6 pull-left mt-0 mt-2 mt-md-3 ">
            <input type="text" name="returntime" class="form-control" id="returntime" placeholder="Enter Pickup Point">
           </div>
         </div>


   <input type="submit" class="btn w-100 form-button mt-2 text-white"  value="Search Cabs" >
   </form>