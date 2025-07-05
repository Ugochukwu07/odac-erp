 <section class="termsbg" style="
  background: #e5e5e5 !important;
  background-image: url(../assets/images/location_ranatravels.png) !important;
  background-size: 60% 70% !important; 
  background-position: right center !important;
  background-repeat: no-repeat !important;
">
    <div class="container">
    <div class="row">
    <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12" >
    <h2 class="title fonthesd contactUsBg"  >Our <br/>Locations</h2>
    </div>
    </div>
    </div>
    </section>
    
   
    
    <section>
    <div class="container">
        
        <div class="row">
                <!--/start left part--------->
                <div class="col-lg-6 col-xs-12 col-md-6 col-sm-12 mapmrgin" style="" >
                     <div class="map_column-inner">
                    <?=$s_map_script?>
                </div>
                </div>
                <!--/end left part--------->
                
                <!--/start right part--------->
                <div class="col-lg-6 col-xs-12 col-md-6 col-sm-12" >
                    <h2 style="text-align: center" class="Contacts-main-heading"><?=$office_type_heading?></h2>
                    
                     	  
                    <ul class="mega-info-list " style="list-style-type: none; height: 100%;">
                    <div class="vc_info_list_outer">
                    		    	
                    <li class="vc_info_list" style="padding-bottom: 15px; border-left: 1px solid #000; display: table;margin-left: 5px; float: none; margin-bottom: 2px;">
                      	<div class="media">
                    	  <div class="media-left info-list-img" style="margin-left: -31px; padding-right: 20px; float: left;">
                    	    <div style="border: 0px solid ; border-radius: 50%; background: #efefef;">
                    	        <span style="display:table; width: 60px; height: 60px; border-radius: 50%; text-align: center;">
                    		    	<span style="display: table-cell !important;vertical-align: middle !important;"> 
                    		        	<i class="fa fa-map-marker icons_fontr" aria-hidden="true" ></i> 
                    	       	 	</span>
                    		  	</span>
                    		</div>
                    	  </div>
                      	  <div class="media-body">
                        	<h2 style="font-size: 18px; color: #000000; font-style: default; font-weight: 800;">Address</h2>
                        		<p><?=$s_address?></p>
                      		</div>
                    	</div>
                    </li>
                    
                    
                    </div>
                    
                    <div class="vc_info_list_outer"> 
                    <li class="vc_info_list" style="padding-bottom: 15px; border-left: 1px solid #000; display: table;margin-left: 5px; float: none; margin-bottom: 2px;">
                      	<div class="media">
                    	  <div class="media-left info-list-img" style="margin-left: -31px; padding-right: 20px; float: left;">
                    	    				        				        <div style="border: 0px solid ; border-radius: 50%; background: #efefef;">
                    	        <span style="display:table; width: 60px; height: 60px; border-radius: 50%; text-align: center;">
                    		    	<span style="display: table-cell !important;vertical-align: middle !important;">
                    		        
                    		        	<i class="fa fa-phone icons_fontr" aria-hidden="true"  ></i>
                    	       	 	
                    	       	 	</span>
                    		  	</span>
                    		</div>
                    							  </div>
                      	  <div class="media-body">
                        	<h2 style="font-size: 18px; color: #000000; font-style: default; font-weight: 800;">
                        		Phone				    	</h2>
                        		<p> <?php if(!empty($s_phone_list)){ foreach( $s_phone_list as $key=>$row){?>
                        		    <a href="tel:+91<?=$row?>"  class="blcklr">+91-<?=$row?></a>
                        		    <?php }} ?>
                        		    </p>
                      		</div>
                    	</div>
                    </li>
                    
                    
                    </div>
                    
                    <div class="vc_info_list_outer">
                    		    	
                    <li class="vc_info_list" style="padding-bottom: 15px; border-left: 1px solid #000; display: table;margin-left: 5px; float: none; margin-bottom: 2px;">
                      	<div class="media">
                    	  <div class="media-left info-list-img" style="margin-left: -31px; padding-right: 20px; float: left;">
                    	    				        				        <div style="border: 0px solid ; border-radius: 50%; background: #efefef;">
                    	        <span style="display:table; width: 60px; height: 60px; border-radius: 50%; text-align: center;">
                    		    	<span style="display: table-cell !important;vertical-align: middle !important;"> 
                    		        	<i class="fa fa-whatsapp icons_fontr" aria-hidden="true" ></i> 
                    	       	 	</span>
                    		  	</span>
                    		</div>
                    	  </div>
                      	  <div class="media-body">
                        	<h2 style="font-size: 18px; color: #000000; font-style: default; font-weight: 800;">
                        		Whatsapp				    	</h2>
                        		<p> <?php if(!empty($s_whatsapp_list)){ foreach( $s_whatsapp_list as $key=>$row){?>
                        		<a href="http://wa.me/91<?=$row?>"  class="blcklr">+91-<?=$row?></a>
                        		<?php }} ?>
                        		</p>
                      		</div>
                    	</div>
                    </li> 
                    </div>
                    
                    <div class="vc_info_list_outer">
                    		    	
                    <li class="vc_info_list" style="padding-bottom: 15px; border-left: 1px solid #000; display: table;margin-left: 5px; float: none; margin-bottom: 2px;">
                      	<div class="media">
                    	  <div class="media-left info-list-img" style="margin-left: -31px; padding-right: 20px; float: left;">
                    	    				        				        <div style="border: 0px solid ; border-radius: 50%; background: #efefef;">
                    	        <span style="display:table; width: 60px; height: 60px; border-radius: 50%; text-align: center;">
                    		    	<span style="display: table-cell !important;vertical-align: middle !important;"> 
                    		        	<i class="fa fa-clock-o icons_fontr" aria-hidden="true" ></i> 
                    	       	 	</span>
                    		  	</span>
                    		</div>
                    	  </div>
                      	  <div class="media-body">
                        	<h2 style="font-size: 18px; color: #000000; font-style: default; font-weight: 800;">
                        		Working:	 <?=$working_days?>		    	</h2>
                        		<p>
                        		<a href="javascript:void(0)" class="blcklr"> <?=$working_hours?></a> 
                        		</p>
                      		</div>
                    	</div>
                    </li> 
                    </div>
                    
                    <div class="vc_info_list_outer"> 
                    <li class="vc_info_list" style="padding-bottom: 15px; border-left: 0px solid #000; display: table;margin-left: 5px; float: none; margin-bottom: 2px;">
                      	<div class="media">
                    	  <div class="media-left info-list-img" style="margin-left: -31px; padding-right: 20px; float: left;">
                    	    <div style="border: 0px solid ; border-radius: 50%; background: #efefef;">
                    	        <span style="display:table; width: 60px; height: 60px; border-radius: 50%; text-align: center;">
                    		    	<span style="display: table-cell !important;vertical-align: middle !important;">
                    		        	<i class="fa fa-envelope icons_fontr" aria-hidden="true"  ></i>
                    	       	 	</span>
                    		  	</span>
                    		</div>
                    	  </div>
                      	  <div class="media-body">
                        	<h2 style="font-size: 18px; color: #000000; font-style: default; font-weight: 800;">
                        		Email				    	</h2>
                        		<p><a href="mailto:<?=$s_email;?>"  class="blcklr"><?=$s_email;?></a></p>
                      		</div>
                    	</div>
                    </li>
			
				
        		</div>
        		</ul> 
		
                </div>
                <!--/end right part--------->
                    
        </div>        
                     
		 
		
           <div class="spacer20"></div>
                <div class="row">  
                <?php if(!empty($list)){  $i=1; foreach($list as $key=>$value){?>  
                <div class="col-lg-4 col-xs-12 col-md-4 col-sm-12" >
                    <div class="ct_column-inner">
                <h2> <?=$value['city_name']?>  </h2> 
                <p style="line-height: 20px; font-size: 16px;"><span><i class="fa fa-map-marker"></i> </span> <?=$value['address_name']?></p> 
                
                <p style="line-height: 20px; font-size: 16px;"><span><i class="fa fa-phone"></i> </span>
                <?php if(!empty($value['mobile_numbers'])){ $mobile_numbers = explode(',', $value['mobile_numbers'] ); foreach( $mobile_numbers as $rowvs ){?>
                <a href="tel:+91<?=$rowvs?>" class="blcklr">+91-<?=$rowvs?></a>
                <?php }} ?>
                </p> 
                <p style="line-height: 20px; font-size: 16px;"><span><i class="fa fa-whatsapp"></i> </span>
                <?php if(!empty($value['whats_app'])){ $whats_app = explode(',', $value['whats_app'] ); foreach( $whats_app as $rows ){?>
                <a href="http://wa.me/91<?=$rows?>"  class="blcklr" >+91-<?=$rows?></a>
                <?php }} ?> 
                </p> 
                <p style="line-height: 20px; font-size: 16px;"><span><i class="fa fa-envelope"></i> </span><?=$value['email_address']?></p> 
                <p style="line-height: 20px; font-size: 16px;"><span><i class="fa fa-clock-o"></i> </span><?=$value['working_days']?> : <?=$value['working_hours']?></p> 
                <a class="readMore" href="<?=base_url('contact-us.php?addressid='. $value['id'])?>" title="">Read More</a>
                </div>   
                </div>
                <?php $i++; }}?> 
                
            </div> 
            
            
            
    </div>
    </div>
    <br/><br/><br/>
    </section>