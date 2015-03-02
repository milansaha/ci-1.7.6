<?php
$type_options_product_code = "";
$type_options_product_code['1'] = 'Yes';
$type_options_product_code['0'] = 'No';

$type_options_product_name = "";
$type_options_product_name['1'] = 'Yes';
$type_options_product_name['0'] = 'No';

$type_options_loan_fund = "";
$type_options_loan_fund['1'] = 'Yes';
$type_options_loan_fund['0'] = 'No';

$type_options_cycle = "";
$type_options_cycle[''] = '---Select---';
$type_options_cycle['1'] = '1';

?>
<script type="text/javascript">
    $(document).ready(function()
    {		
        // Start Branch
        $("#txt_is_branch_code_need").change(function()
        {
            $("#display_branch_sample_code").html("");
            $('#branch_code_length').attr('disabled','');
            if($("#txt_is_branch_code_need").is(':checked')){
                $('#branch_code_length').attr('disabled','');
                for(var i = 0; i < $('#branch_code_length').val() - 1; i++)
                {
                    $('#display_branch_sample_code').append("0");
                }
                if($('#branch_code_length').val() > 0){
                    $('#display_branch_sample_code').append("1");
                }
            }
        });
        $("#branch_code_length").click(function()
        {
            $("#display_branch_sample_code").html("");
            $('#branch_code_length').attr('disabled','');
            if($("#txt_is_branch_code_need").is(':checked')){
                $('#branch_code_length').attr('disabled','');
                for(var i = 0; i < $('#branch_code_length').val() - 1; i++)
                {
                    $('#display_branch_sample_code').append("0");
                }
                if($('#branch_code_length').val() > 0){
                    $('#display_branch_sample_code').append("1");
                }
            }
        });
        // End Branch
        // Start Samity
        $("#txt_is_samity_code_need").change(function()
        {
            $("#display_samity_sample_code").html("");
            $('#samity_code_length').attr('disabled','');
            $('#txt_is_include_branch_code_for_samity').attr('disabled','');
            $('#samity_code_separator').attr('disabled','');
			
            if($("#txt_is_samity_code_need").is(':checked')){
                $('#samity_code_length').attr('disabled','');
                $('#txt_is_include_branch_code_for_samity').attr('disabled','');
                $('#samity_code_separator').attr('disabled','');
				
                var separator = "";				
				
                if($("#txt_is_include_branch_code_for_samity").is(':checked')) {
                    separator = $('#samity_code_separator').val();
					productcode = $('#product_code_for_samity').val();
					if(productcode=='1'){
							productcode = '102';
						}else{
							productcode='';
							}
					fund = $('#samity_product_fund_name').val();		
					if(fund=='1'){
							fundname = 'PKSF';
						}else{
							fundname='';
							}
					 
                    for(var i = 0; i < $('#branch_code_length').val() - 1; i++)
                    {
                        $('#display_samity_sample_code').append("0");
                    }
                    if($('#branch_code_length').val() > 0){
                        $('#display_samity_sample_code').append("1");
                        $('#display_samity_sample_code').append("" + separator);
                        $('#display_samity_sample_code').append(productcode);
                        if(productcode!=''){
							$('#display_samity_sample_code').append(separator);
						}
                    }
                }
				 $('#display_samity_sample_code').append(fundname);
				 if(fundname!=''){
							$('#display_samity_sample_code').append(separator);
						}
								
                for(var i = 0; i < $('#samity_code_length').val() - 1; i++)
                {
                    $('#display_samity_sample_code').append("0");
                }
                if($('#samity_code_length').val() > 0){
                    $('#display_samity_sample_code').append("1");
                }
            }
        });
        
        
        $("#samity_code_length").click(function()
        {
            $("#display_samity_sample_code").html("");
            $('#samity_code_length').attr('disabled','');
            $('#txt_is_include_branch_code_for_samity').attr('disabled','');
            $('#samity_code_separator').attr('disabled','');
			
            if($("#txt_is_samity_code_need").is(':checked')){
                $('#samity_code_length').attr('disabled','');
                $('#txt_is_include_branch_code_for_samity').attr('disabled','');
                $('#samity_code_separator').attr('disabled','');
				
                var separator = "";				
				
                if($("#txt_is_include_branch_code_for_samity").is(':checked')) {
                    separator = $('#samity_code_separator').val();
					productcode = $('#product_code_for_samity').val();
					if(productcode=='1'){
							productcode = '102';
						}else{
							productcode='';
							}
					fund = $('#samity_product_fund_name').val();		
					if(fund=='1'){
							fundname = 'PKSF';
						}else{
							fundname='';
							}
					 
                    for(var i = 0; i < $('#branch_code_length').val() - 1; i++)
                    {
                        $('#display_samity_sample_code').append("0");
                    }
                    if($('#branch_code_length').val() > 0){
                        $('#display_samity_sample_code').append("1");
                        $('#display_samity_sample_code').append("" + separator);
                        $('#display_samity_sample_code').append(productcode);
                        if(productcode!=''){
							$('#display_samity_sample_code').append(separator);
						}
                    }
                }
				 $('#display_samity_sample_code').append(fundname);
				 if(fundname!=''){
							$('#display_samity_sample_code').append(separator);
						}
								
                for(var i = 0; i < $('#samity_code_length').val() - 1; i++)
                {
                    $('#display_samity_sample_code').append("0");
                }
                if($('#samity_code_length').val() > 0){
                    $('#display_samity_sample_code').append("1");
                }
            }
        });
        //is include samity
        $("#txt_is_include_branch_code_for_samity").change(function()
        {
           $("#display_samity_sample_code").html("");
            $('#samity_code_length').attr('disabled','');
            $('#txt_is_include_branch_code_for_samity').attr('disabled','');
            $('#samity_code_separator').attr('disabled','');
			
            if($("#txt_is_samity_code_need").is(':checked')){
                $('#samity_code_length').attr('disabled','');
                $('#txt_is_include_branch_code_for_samity').attr('disabled','');
                $('#samity_code_separator').attr('disabled','');
				
                var separator = "";				
				
                if($("#txt_is_include_branch_code_for_samity").is(':checked')) {
                    separator = $('#samity_code_separator').val();
					productcode = $('#product_code_for_samity').val();
					if(productcode=='1'){
							productcode = '102';
						}else{
							productcode='';
							}
					fund = $('#samity_product_fund_name').val();		
					if(fund=='1'){
							fundname = 'PKSF';
						}else{
							fundname='';
							}
					 
                    for(var i = 0; i < $('#branch_code_length').val() - 1; i++)
                    {
                        $('#display_samity_sample_code').append("0");
                    }
                    if($('#branch_code_length').val() > 0){
                        $('#display_samity_sample_code').append("1");
                        $('#display_samity_sample_code').append("" + separator);
                        $('#display_samity_sample_code').append(productcode);
                        if(productcode!=''){
							$('#display_samity_sample_code').append(separator);
						}
                    }
                }
				 $('#display_samity_sample_code').append(fundname);
				 if(fundname!=''){
							$('#display_samity_sample_code').append(separator);
						}
								
                for(var i = 0; i < $('#samity_code_length').val() - 1; i++)
                {
                    $('#display_samity_sample_code').append("0");
                }
                if($('#samity_code_length').val() > 0){
                    $('#display_samity_sample_code').append("1");
                }
            }
        });
		
        $("#samity_code_separator").change(function()
        {
           $("#display_samity_sample_code").html("");
            $('#samity_code_length').attr('disabled','');
            $('#txt_is_include_branch_code_for_samity').attr('disabled','');
            $('#samity_code_separator').attr('disabled','');
			
            if($("#txt_is_samity_code_need").is(':checked')){
                $('#samity_code_length').attr('disabled','');
                $('#txt_is_include_branch_code_for_samity').attr('disabled','');
                $('#samity_code_separator').attr('disabled','');
				
                var separator = "";				
				
                if($("#txt_is_include_branch_code_for_samity").is(':checked')) {
                    separator = $('#samity_code_separator').val();
					productcode = $('#product_code_for_samity').val();
					if(productcode=='1'){
							productcode = '102';
						}else{
							productcode='';
							}
					fund = $('#samity_product_fund_name').val();		
					if(fund=='1'){
							fundname = 'PKSF';
						}else{
							fundname='';
							}
					 
                    for(var i = 0; i < $('#branch_code_length').val() - 1; i++)
                    {
                        $('#display_samity_sample_code').append("0");
                    }
                    if($('#branch_code_length').val() > 0){
                        $('#display_samity_sample_code').append("1");
                        $('#display_samity_sample_code').append("" + separator);
                        $('#display_samity_sample_code').append(productcode);
                        if(productcode!=''){
							$('#display_samity_sample_code').append(separator);
						}
                    }
                }
				 $('#display_samity_sample_code').append(fundname);
				 if(fundname!=''){
							$('#display_samity_sample_code').append(separator);
						}
								
                for(var i = 0; i < $('#samity_code_length').val() - 1; i++)
                {
                    $('#display_samity_sample_code').append("0");
                }
                if($('#samity_code_length').val() > 0){
                    $('#display_samity_sample_code').append("1");
                }
            }
        });
        
        $("#product_code_for_samity").change(function()
        {
           $("#display_samity_sample_code").html("");
            $('#samity_code_length').attr('disabled','');
            $('#txt_is_include_branch_code_for_samity').attr('disabled','');
            $('#samity_code_separator').attr('disabled','');
			
            if($("#txt_is_samity_code_need").is(':checked')){
                $('#samity_code_length').attr('disabled','');
                $('#txt_is_include_branch_code_for_samity').attr('disabled','');
                $('#samity_code_separator').attr('disabled','');
				
                var separator = "";				
				
                if($("#txt_is_include_branch_code_for_samity").is(':checked')) {
                    separator = $('#samity_code_separator').val();
					productcode = $('#product_code_for_samity').val();
					if(productcode=='1'){
							productcode = '102';
						}else{
							productcode='';
							}
					fund = $('#samity_product_fund_name').val();		
					if(fund=='1'){
							fundname = 'PKSF';
						}else{
							fundname='';
							}
					 
                    for(var i = 0; i < $('#branch_code_length').val() - 1; i++)
                    {
                        $('#display_samity_sample_code').append("0");
                    }
                    if($('#branch_code_length').val() > 0){
                        $('#display_samity_sample_code').append("1");
                        $('#display_samity_sample_code').append("" + separator);
                        $('#display_samity_sample_code').append(productcode);
                        if(productcode!=''){
							$('#display_samity_sample_code').append(separator);
						}
                    }
                }
				 $('#display_samity_sample_code').append(fundname);
				 if(fundname!=''){
							$('#display_samity_sample_code').append(separator);
						}
								
                for(var i = 0; i < $('#samity_code_length').val() - 1; i++)
                {
                    $('#display_samity_sample_code').append("0");
                }
                if($('#samity_code_length').val() > 0){
                    $('#display_samity_sample_code').append("1");
                }
            }
        });
        //Fund Name for samity
         $("#samity_product_fund_name").change(function()
        {
          $("#display_samity_sample_code").html("");
            $('#samity_code_length').attr('disabled','');
            $('#txt_is_include_branch_code_for_samity').attr('disabled','');
            $('#samity_code_separator').attr('disabled','');
			
            if($("#txt_is_samity_code_need").is(':checked')){
                $('#samity_code_length').attr('disabled','');
                $('#txt_is_include_branch_code_for_samity').attr('disabled','');
                $('#samity_code_separator').attr('disabled','');
				
                var separator = "";				
				
                if($("#txt_is_include_branch_code_for_samity").is(':checked')) {
                    separator = $('#samity_code_separator').val();
					productcode = $('#product_code_for_samity').val();
					if(productcode=='1'){
							productcode = '102';
						}else{
							productcode='';
							}
					fund = $('#samity_product_fund_name').val();		
					if(fund=='1'){
							fundname = 'PKSF';
						}else{
							fundname='';
							}
					 
                    for(var i = 0; i < $('#branch_code_length').val() - 1; i++)
                    {
                        $('#display_samity_sample_code').append("0");
                    }
                    if($('#branch_code_length').val() > 0){
                        $('#display_samity_sample_code').append("1");
                        $('#display_samity_sample_code').append("" + separator);
                        $('#display_samity_sample_code').append(productcode);
                        if(productcode!=''){
							$('#display_samity_sample_code').append(separator);
						}
                    }
                }
				 $('#display_samity_sample_code').append(fundname);
				 if(fundname!=''){
							$('#display_samity_sample_code').append(separator);
						}
								
                for(var i = 0; i < $('#samity_code_length').val() - 1; i++)
                {
                    $('#display_samity_sample_code').append("0");
                }
                if($('#samity_code_length').val() > 0){
                    $('#display_samity_sample_code').append("1");
                }
            }
        });
		
        //End Samity
        
        //Start Member
        $("#txt_is_member_code_need").change(function()
        {
            $("#display_member_sample_code").html("");
            $('#member_code_length').attr('disabled','');
            $('#txt_is_include_branch_code_for_member').attr('disabled','');
            $('#member_code_separator').attr('disabled','');

            if($("#txt_is_member_code_need").is(':checked')){
                $('#member_code_length').attr('disabled','');
                $('#txt_is_include_branch_code_for_member').attr('disabled','');
                $('#member_code_separator').attr('disabled','');

                var separator = "";


                if($("#txt_is_include_branch_code_for_member").is(':checked')) {
                    separator = $('#member_code_separator').val();

                    for(var i = 0; i < $('#branch_code_length').val() - 1; i++)
                    {
                        $('#display_member_sample_code').append("0");
                    }
                    if($('#branch_code_length').val() > 0){
                        $('#display_member_sample_code').append("1");
                        $('#display_member_sample_code').append("" +separator);
                    }
                }

                for(var i = 0; i < $('#member_code_length').val() - 1; i++)
                {
                    $('#display_member_sample_code').append("0");
                }
                if($('#member_code_length').val() > 0){
                    $('#display_member_sample_code').append("1");
                }
            }
        });
        $("#member_code_length").click(function()
        {
            $("#display_member_sample_code").html("");
            $('#member_code_length').attr('disabled','');
            $('#txt_is_include_branch_code_for_member').attr('disabled','');
            $('#member_code_separator').attr('disabled','');

            if($("#txt_is_member_code_need").is(':checked')){
                $('#member_code_length').attr('disabled','');
                $('#txt_is_include_samity_code_for_member').attr('disabled','');
                $('#txt_is_include_branch_code_for_member').attr('disabled','');
                $('#member_code_separator').attr('disabled','');

                var separator = "";


                if($("#txt_is_include_samity_code_for_member").is(':checked')) {
                    separator = $('#member_code_separator').val();

                    if($("#txt_is_include_branch_code_for_member").is(':checked')) {

                        for(var i = 0; i < $('#branch_code_length').val() - 1; i++)
                        {
                            $('#display_member_sample_code').append("0");
                        }
                        if($('#branch_code_length').val() > 0){
                            $('#display_member_sample_code').append("1");
                            $('#display_member_sample_code').append("" +separator);
                        }
                    }

                    for(var i = 0; i < $('#samity_code_length').val() - 1; i++)
                    {
                        $('#display_member_sample_code').append("0");
                    }
                    if($('#samity_code_length').val() > 0){
                        $('#display_member_sample_code').append("1");
                        $('#display_member_sample_code').append("" +separator);
                    }



                }

                for(var i = 0; i < $('#member_code_length').val() - 1; i++)
                {
                    $('#display_member_sample_code').append("0");
                }
                if($('#member_code_length').val() > 0){
                    $('#display_member_sample_code').append("1");
                }
            }
        });
      

        //is include samity
        $("#txt_is_include_samity_code_for_member").change(function()
        {
            $("#display_member_sample_code").html("");
            $('#member_code_length').attr('disabled','');
            $('#txt_is_include_branch_code_for_member').attr('disabled','');
            $('#member_code_separator').attr('disabled','');

            if($("#txt_is_member_code_need").is(':checked')){
                $('#member_code_length').attr('disabled','');
                $('#txt_is_include_branch_code_for_member').attr('disabled','');
                $('#member_code_separator').attr('disabled','');

                var separator = "";


                if($("#txt_is_include_samity_code_for_member").is(':checked')) {
                    separator = $('#member_code_separator').val();

                    if($("#txt_is_include_branch_code_for_member").is(':checked')) {

                        for(var i = 0; i < $('#branch_code_length').val() - 1; i++)
                        {
                            $('#display_member_sample_code').append("0");
                        }
                        if($('#branch_code_length').val() > 0){
                            $('#display_member_sample_code').append("1");
                            $('#display_member_sample_code').append("" +separator);
                        }
                    }

                    for(var i = 0; i < $('#samity_code_length').val() - 1; i++)
                    {
                        $('#display_member_sample_code').append("0");
                    }
                    if($('#samity_code_length').val() > 0){
                        $('#display_member_sample_code').append("1");
                        $('#display_member_sample_code').append("" +separator);
                    }                   

                }

                for(var i = 0; i < $('#member_code_length').val() - 1; i++)
                {
                    $('#display_member_sample_code').append("0");
                }
                if($('#member_code_length').val() > 0){
                    $('#display_member_sample_code').append("1");
                }
            }
        });


        //is include branch
        $("#txt_is_include_branch_code_for_member").change(function()
        {
            $("#display_member_sample_code").html("");
            $('#member_code_length').attr('disabled','');
            //$('#txt_is_include_branch_code_for_member').attr('disabled','disabled');
            $('#member_code_separator').attr('disabled','');

            if($("#txt_is_member_code_need").is(':checked')){
                $('#member_code_length').attr('disabled','');
                $('#txt_is_include_branch_code_for_member').attr('disabled','');
                $('#member_code_separator').attr('disabled','');

                var separator = "";


                if($("#txt_is_include_branch_code_for_member").is(':checked')) {
                    separator = $('#member_code_separator').val();

                    for(var i = 0; i < $('#branch_code_length').val() - 1; i++)
                    {
                        $('#display_member_sample_code').append("0");
                    }
                    if($('#branch_code_length').val() > 0){
                        $('#display_member_sample_code').append("1");
                        $('#display_member_sample_code').append("" +separator);
                    }

                    if($("#txt_is_include_samity_code_for_member").is(':checked')) {

                        for(var i = 0; i < $('#samity_code_length').val() - 1; i++)
                        {
                            $('#display_member_sample_code').append("0");
                        }
                        if($('#samity_code_length').val() > 0){
                            $('#display_member_sample_code').append("1");
                            $('#display_member_sample_code').append("" +separator);
                        }
                    }
                }

                for(var i = 0; i < $('#member_code_length').val() - 1; i++)
                {
                    $('#display_member_sample_code').append("0");
                }
                if($('#member_code_length').val() > 0){
                    $('#display_member_sample_code').append("1");
                }
            }
        });

       

        $("#member_code_separator").change(function()
        {
            $("#display_member_sample_code").html("");
            $('#member_code_length').attr('disabled','');
            $('#txt_is_include_samity_code_for_member').attr('disabled','');
            $('#txt_is_include_branch_code_for_member').attr('disabled','');
            $('#member_code_separator').attr('disabled','');

            if($("#txt_is_samity_code_need").is(':checked')){
                $('#samity_code_length').attr('disabled','');
                $('#txt_is_include_branch_code_for_samity').attr('disabled','');
                $('#samity_code_separator').attr('disabled','');

                var separator = "";


                if($("#txt_is_include_samity_code_for_member").is(':checked')) {
                    separator = $('#member_code_separator').val();

                    if($("#txt_is_include_branch_code_for_member").is(':checked')) {

                        for(var i = 0; i < $('#branch_code_length').val() - 1; i++)
                        {
                            $('#display_member_sample_code').append("0");
                        }
                        if($('#branch_code_length').val() > 0){
                            $('#display_member_sample_code').append("1");
                            $('#display_member_sample_code').append("" +separator);
                        }
                    }

                    for(var i = 0; i < $('#samity_code_length').val() - 1; i++)
                    {
                        $('#display_member_sample_code').append("0");
                    }
                    if($('#samity_code_length').val() > 0){
                        $('#display_member_sample_code').append("1");
                        $('#display_member_sample_code').append("" +separator);
                    }



                }

                for(var i = 0; i < $('#member_code_length').val() - 1; i++)
                {
                    $('#display_member_sample_code').append("0");
                }
                if($('#member_code_length').val() > 0){
                    $('#display_member_sample_code').append("1");
                }
            }
        });

        // End Member

       
        //Start savings Id
        $("#savings_product_code_length").change(function()
        {
            $("#display_saving_id_sample_code").html('');

            var savingsid = $('#savings_product_code_length').val();
            var separator = $('#savings_code_separator').val();
            var shortname = $('#savings_product_short_name').val();
            if(savingsid=='1'){
							savingsid = '201';
						}else{
							savingsid='';
							}
			if(shortname=='1'){
							shortname = 'COM';
						}else{
							shortname='';
							} 
                     
            if($("#txt_is_include_member_code_for_savings").is(':checked')){
               
                var memberid = $('#display_member_sample_code').html();
			}
			            
			$('#display_saving_id_sample_code').append(savingsid);
			if(savingsid!=''){
				$('#display_saving_id_sample_code').append(separator);
			}
			$('#display_saving_id_sample_code').append(shortname);
			//alert(shortname);  
			if(shortname!=''){
				$('#display_saving_id_sample_code').append(separator);
			}
			$('#display_saving_id_sample_code').append(memberid);
			  
            
                      
        });
        
        $("#savings_product_short_name").change(function()
        {
            $("#display_saving_id_sample_code").html('');

            var savingsid = $('#savings_product_code_length').val();
            var separator = $('#savings_code_separator').val();
            var shortname = $('#savings_product_short_name').val();
            if(savingsid=='1'){
							savingsid = '201';
						}else{
							savingsid='';
							}
			if(shortname=='1'){
							shortname = 'COM';
						}else{
							shortname='';
							} 
                     
            if($("#txt_is_include_member_code_for_savings").is(':checked')){
               
                var memberid = $('#display_member_sample_code').html();
			}
			            
			$('#display_saving_id_sample_code').append(savingsid);
			if(savingsid!=''){
				$('#display_saving_id_sample_code').append(separator);
			}
			$('#display_saving_id_sample_code').append(shortname);
			//alert(shortname);  
			if(shortname!=''){
				$('#display_saving_id_sample_code').append(separator);
			}
			$('#display_saving_id_sample_code').append(memberid);
			  
            
                      
        });

        //Include member id
        $("#txt_is_include_member_code_for_savings").change(function()
        {
           $("#display_saving_id_sample_code").html('');

            var savingsid = $('#savings_product_code_length').val();
            var separator = $('#savings_code_separator').val();
            var shortname = $('#savings_product_short_name').val();
            if(savingsid=='1'){
							savingsid = '201';
						}else{
							savingsid='';
							}
			if(shortname=='1'){
							shortname = 'COM';
						}else{
							shortname='';
							} 
                     
            if($("#txt_is_include_member_code_for_savings").is(':checked')){
               
                var memberid = $('#display_member_sample_code').html();
			}
			            
			$('#display_saving_id_sample_code').append(savingsid);
			if(savingsid!=''){
				$('#display_saving_id_sample_code').append(separator);
			}
			$('#display_saving_id_sample_code').append(shortname);
			//alert(shortname);  
			if(shortname!=''){
				$('#display_saving_id_sample_code').append(separator);
			}
			$('#display_saving_id_sample_code').append(memberid);

        });

        //Change Separator
        $("#savings_code_separator").change(function()
        {
            $("#display_saving_id_sample_code").html('');

            var savingsid = $('#savings_product_code_length').val();
            var separator = $('#savings_code_separator').val();
            var shortname = $('#savings_product_short_name').val();
            if(savingsid=='1'){
							savingsid = '201';
						}else{
							savingsid='';
							}
			if(shortname=='1'){
							shortname = 'COM';
						}else{
							shortname='';
							} 
                     
            if($("#txt_is_include_member_code_for_savings").is(':checked')){
               
                var memberid = $('#display_member_sample_code').html();
			}
			            
			$('#display_saving_id_sample_code').append(savingsid);
			if(savingsid!=''){
				$('#display_saving_id_sample_code').append(separator);
			}
			$('#display_saving_id_sample_code').append(shortname);
			//alert(shortname);  
			if(shortname!=''){
				$('#display_saving_id_sample_code').append(separator);
			}
			$('#display_saving_id_sample_code').append(memberid);

        });
        //End Savings Id

        //Start loan Id
        $("#product_loan_code_length").change(function()
        {
            $("#display_loan_id_sample_code").html('');

            var loanid = $('#product_loan_code_length').val();
            var loanname = $('#product_loan_code_shortname').val();
			var separator = $('#loan_code_separator').val();
			var cycle = $('#cycle_code').val();
			var fund = $('#product_loan_fund_name').val();
			
			if(loanid=='1'){
							loanid = '102';
						}else{
							loanid='';
							}
			
			if(loanname=='1'){
							loanname = 'RMC';
						}else{
							loanname='';
							}		
			if(fund=='1'){
					fundname = 'PKSF';
				}else{
					fundname='';
					}
			if($("#txt_is_include_member_code_for_loan").is(':checked')){
				var memberid = $('#display_member_sample_code').html();
            }
            
			$('#display_loan_id_sample_code').append(loanid);
			if(loanid!=''){			
				$('#display_loan_id_sample_code').append(separator);
			}
			$('#display_loan_id_sample_code').append(fundname);
			if(fundname!=''){			
				$('#display_loan_id_sample_code').append(separator);
			}
			$('#display_loan_id_sample_code').append(loanname);			
			if(loanname!=''){
				$('#display_loan_id_sample_code').append(separator);
			}
			if($("#txt_is_include_member_code_for_loan").is(':checked')){
				$('#display_loan_id_sample_code').append(memberid);	
			}
			
			if(cycle!=''){
				$('#display_loan_id_sample_code').append(separator);
			}
			$('#display_loan_id_sample_code').append(cycle);
			

        });
        
          //Loan short name change
        $("#product_loan_code_shortname").change(function()
        {
             $("#display_loan_id_sample_code").html('');

            var loanid = $('#product_loan_code_length').val();
            var loanname = $('#product_loan_code_shortname').val();
			var separator = $('#loan_code_separator').val();
			var cycle = $('#cycle_code').val();
			var fund = $('#product_loan_fund_name').val();
			
			if(loanid=='1'){
							loanid = '102';
						}else{
							loanid='';
							}
			
			if(loanname=='1'){
							loanname = 'RMC';
						}else{
							loanname='';
							}		
			if(fund=='1'){
					fundname = 'PKSF';
				}else{
					fundname='';
					}
			if($("#txt_is_include_member_code_for_loan").is(':checked')){
				var memberid = $('#display_member_sample_code').html();
            }
            
			$('#display_loan_id_sample_code').append(loanid);
			if(loanid!=''){			
				$('#display_loan_id_sample_code').append(separator);
			}
			$('#display_loan_id_sample_code').append(fundname);
			if(fundname!=''){			
				$('#display_loan_id_sample_code').append(separator);
			}
			$('#display_loan_id_sample_code').append(loanname);			
			if(loanname!=''){
				$('#display_loan_id_sample_code').append(separator);
			}
			if($("#txt_is_include_member_code_for_loan").is(':checked')){
				$('#display_loan_id_sample_code').append(memberid);	
			}
			
			if(cycle!=''){
				$('#display_loan_id_sample_code').append(separator);
			}
			$('#display_loan_id_sample_code').append(cycle);

        });

        //Include member id
        $("#txt_is_include_member_code_for_loan").change(function()
        {
            $("#display_loan_id_sample_code").html('');

            var loanid = $('#product_loan_code_length').val();
            var loanname = $('#product_loan_code_shortname').val();
			var separator = $('#loan_code_separator').val();
			var cycle = $('#cycle_code').val();
			var fund = $('#product_loan_fund_name').val();
			
			if(loanid=='1'){
							loanid = '102';
						}else{
							loanid='';
							}
			
			if(loanname=='1'){
							loanname = 'RMC';
						}else{
							loanname='';
							}		
			if(fund=='1'){
					fundname = 'PKSF';
				}else{
					fundname='';
					}
			if($("#txt_is_include_member_code_for_loan").is(':checked')){
				var memberid = $('#display_member_sample_code').html();
            }
            
			$('#display_loan_id_sample_code').append(loanid);
			if(loanid!=''){			
				$('#display_loan_id_sample_code').append(separator);
			}
			$('#display_loan_id_sample_code').append(fundname);
			if(fundname!=''){			
				$('#display_loan_id_sample_code').append(separator);
			}
			$('#display_loan_id_sample_code').append(loanname);			
			if(loanname!=''){
				$('#display_loan_id_sample_code').append(separator);
			}
			if($("#txt_is_include_member_code_for_loan").is(':checked')){
				$('#display_loan_id_sample_code').append(memberid);	
			}
			
			if(cycle!=''){
				$('#display_loan_id_sample_code').append(separator);
			}
			$('#display_loan_id_sample_code').append(cycle);

        });

        //Change Separator
        $("#loan_code_separator").change(function()
        {
            $("#display_loan_id_sample_code").html('');

            var loanid = $('#product_loan_code_length').val();
            var loanname = $('#product_loan_code_shortname').val();
			var separator = $('#loan_code_separator').val();
			var cycle = $('#cycle_code').val();
			var fund = $('#product_loan_fund_name').val();
			
			if(loanid=='1'){
							loanid = '102';
						}else{
							loanid='';
							}
			
			if(loanname=='1'){
							loanname = 'RMC';
						}else{
							loanname='';
							}		
			if(fund=='1'){
					fundname = 'PKSF';
				}else{
					fundname='';
					}
			if($("#txt_is_include_member_code_for_loan").is(':checked')){
				var memberid = $('#display_member_sample_code').html();
            }
            
			$('#display_loan_id_sample_code').append(loanid);
			if(loanid!=''){			
				$('#display_loan_id_sample_code').append(separator);
			}
			$('#display_loan_id_sample_code').append(fundname);
			if(fundname!=''){			
				$('#display_loan_id_sample_code').append(separator);
			}
			$('#display_loan_id_sample_code').append(loanname);			
			if(loanname!=''){
				$('#display_loan_id_sample_code').append(separator);
			}
			if($("#txt_is_include_member_code_for_loan").is(':checked')){
				$('#display_loan_id_sample_code').append(memberid);	
			}
			
			if(cycle!=''){
				$('#display_loan_id_sample_code').append(separator);
			}
			$('#display_loan_id_sample_code').append(cycle);
            
        });

        //Change cycle_code
        $("#cycle_code").change(function()
        {
            $("#display_loan_id_sample_code").html('');

            var loanid = $('#product_loan_code_length').val();
            var loanname = $('#product_loan_code_shortname').val();
			var separator = $('#loan_code_separator').val();
			var cycle = $('#cycle_code').val();
			var fund = $('#product_loan_fund_name').val();
			
			if(loanid=='1'){
							loanid = '102';
						}else{
							loanid='';
							}
			
			if(loanname=='1'){
							loanname = 'RMC';
						}else{
							loanname='';
							}		
			if(fund=='1'){
					fundname = 'PKSF';
				}else{
					fundname='';
					}
			if($("#txt_is_include_member_code_for_loan").is(':checked')){
				var memberid = $('#display_member_sample_code').html();
            }
            
			$('#display_loan_id_sample_code').append(loanid);
			if(loanid!=''){			
				$('#display_loan_id_sample_code').append(separator);
			}
			$('#display_loan_id_sample_code').append(fundname);
			if(fundname!=''){			
				$('#display_loan_id_sample_code').append(separator);
			}
			$('#display_loan_id_sample_code').append(loanname);			
			if(loanname!=''){
				$('#display_loan_id_sample_code').append(separator);
			}
			if($("#txt_is_include_member_code_for_loan").is(':checked')){
				$('#display_loan_id_sample_code').append(memberid);	
			}
			
			if(cycle!=''){
				$('#display_loan_id_sample_code').append(separator);
			}
			$('#display_loan_id_sample_code').append(cycle);

        });
        
         //Change fundanme
        $("#product_loan_fund_name").change(function()
        {
             $("#display_loan_id_sample_code").html('');

            var loanid = $('#product_loan_code_length').val();
            var loanname = $('#product_loan_code_shortname').val();
			var separator = $('#loan_code_separator').val();
			var cycle = $('#cycle_code').val();
			var fund = $('#product_loan_fund_name').val();
			
			if(loanid=='1'){
							loanid = '102';
						}else{
							loanid='';
							}
			
			if(loanname=='1'){
							loanname = 'RMC';
						}else{
							loanname='';
							}		
			if(fund=='1'){
					fundname = 'PKSF';
				}else{
					fundname='';
					}
			if($("#txt_is_include_member_code_for_loan").is(':checked')){
				var memberid = $('#display_member_sample_code').html();
            }
            
			$('#display_loan_id_sample_code').append(loanid);
			if(loanid!=''){			
				$('#display_loan_id_sample_code').append(separator);
			}
			$('#display_loan_id_sample_code').append(fundname);
			if(fundname!=''){			
				$('#display_loan_id_sample_code').append(separator);
			}
			$('#display_loan_id_sample_code').append(loanname);			
			if(loanname!=''){
				$('#display_loan_id_sample_code').append(separator);
			}
			if($("#txt_is_include_member_code_for_loan").is(':checked')){
				$('#display_loan_id_sample_code').append(memberid);	
			}
			
			if(cycle!=''){
				$('#display_loan_id_sample_code').append(separator);
			}
			$('#display_loan_id_sample_code').append(cycle);

        });
        //End Loan Id
		
    });
	
   
</script>
<?php	
    echo form_open('config_customized_ids/'.(isset($row->id)?'edit':'add'));
    echo form_hidden('config_id',isset($row->id)?$row->id:"");
    //echo '<pre>';
    //print_r($row);
?>
<div id="status" style="position:absolute;top:50%;left:45%;"></div>
<fieldset>
    	<table class="addForm" border="0" cellspacing="0px" cellpadding="0px" width="99%">
		<tr>
			<td class="formTitleBar">
				<div class="formTitleBar_edit">
					<?php //echo img(array('src'=>base_url().'media/images/edit_big.png','border'=>'0','width'=>'24','style'=>''))?>
					<h2 style=""><?php echo $headline;?></h2>
				</div>
			</td>
			<td class="formTitleBar">
				<div style="float:right;">
					<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('config_customized_ids')."'"));?>
				</div>
			</td>
		</tr>
        </table>
	<table class="uiInfoTableConfig" width="650px" border="0" cellspacing="0px" cellpadding="0px">
		<tbody>
			<tr><th colspan="6">Branch</th></tr>
			<tr>
				<td width="16%"><label for="txt_name">Branch Need?<em></em></label></td>
				<td width="16%"><label for="cbo_samity">Length<em></em></label></td>
				<td width="16%"><label for="cbo_group">Sample Code:<em></em></label></td>
				<td width="16%"><label for="cbo_sub_group">&nbsp;<em></em></label></td>
				<td width="16%"><label for="cbo_sub_group">&nbsp;<em></em></label></td>
				<td width="16%"><label for="cbo_sub_group">&nbsp;<em></em></label></td>
			</tr>
			<tr>
				<td align="left">	
					<input id="txt_is_branch_code_need" name="txt_is_branch_code_need" type="checkbox" value="1" <?php if(isset($row->is_branch_code_need)){if($row->is_branch_code_need=='1') {echo "checked='TRUE'";}}?> style="width:20px;border:none;">
				</td>				
				<td>	
					<span>
						<?php
							$attr = 'id="branch_code_length" ';
							echo form_dropdown('branch_code_length', $config_code_length, isset($row->branch_code_length)?$row->branch_code_length:"", $attr);
						?>	
					</span>
				</td>
				<td>
					<div><span id="display_branch_sample_code">
						<?php 
						if(isset($row->branch_code_length)) {
								if($row->branch_code_length){
									for($i=0;$i<$row->branch_code_length-1;$i++){
											echo '0';
										}
									 echo '1';
									}
							}
						?>
						</span></div>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr class="spacer"><td colspan="6"></td></tr>
		</tbody>
		<tbody>
			<tr><th colspan="6">Samity</th></tr>
			<tr>
				<td width="16%"><label for="txt_name">Samity Need?:<em></em></label></td>
				<td width="16%"><label for="cbo_samity">Length:<em></em></label></td>
				<td width="16%"><label for="cbo_group" style="text-align:left;">Include Branch Code?:<em></em></label></td>
				<td width="16%"><label for="cbo_group">Product Code?:<em></em></label></td>
				<td width="16%"><label for="cbo_sub_group">Separator:<em></em></label></td>
				<td width="16%"><label for="cbo_sub_group">Sample Code:<em></em></label></td>
			</tr>
			<tr>
				<td align="left">	
					<input id="txt_is_samity_code_need" <?php  if(isset($row->is_samity_code_need) && $row->is_samity_code_need=='1') {echo "checked='TRUE'";}?> name="txt_is_samity_code_need" type="checkbox" value="1"  style="width:20px;border:none;">
				</td>				
				<td>	
					<span><?php
                                $attr = 'id="samity_code_length"  ';
                                echo form_dropdown('samity_code_length', $config_code_length, isset($row->samity_code_length)? $row->samity_code_length:"", $attr);
							?>
					</span>
				</td>
				<td>
					<span>
                        <input id="txt_is_include_branch_code_for_samity" <?php if(isset($row->is_include_branch_code_for_samity) && $row->is_include_branch_code_for_samity=='1') {echo "checked='TRUE'";}?>name="txt_is_include_branch_code_for_samity" style="width:20px;border:none;" type="checkbox" value="1">
                    </span>
				</td>
				<td align="left">	
					<span>
						<?php						
						$attr = 'id="product_code_for_samity" ';
						echo form_dropdown('txt_is_include_product_code_for_samity', $type_options_product_code,  isset($row->is_product_code_for_samity)?$row->is_product_code_for_samity:"", $attr);
						?>
					</span>
				</td>
				<td>
					<span>
						<?php
							$attr = 'id="samity_code_separator"  ';
							echo form_dropdown('samity_code_separator', $config_code_separator,  isset($row->samity_code_separator)?$row->samity_code_separator:"", $attr);
						?>	
					</span>
				</td>
				<td>
					<div>
						<span id="display_samity_sample_code">
							<?php 
								if(isset($row->samity_code_separator)) {
									if( isset($row->is_samity_code_need) && $row->is_samity_code_need=='1'){
										for($i=0;$i<$row->samity_code_length-1;$i++){
												echo '0';
										}
									 echo '1';
									}
									echo $row->samity_code_separator;
								
								if(isset($row->is_product_code_for_samity) && $row->is_product_code_for_samity=='1'){									
									 echo '102';
									 echo $row->samity_code_separator;
									}
									
								if(isset($row->is_samity_product_fundname_need) && $row->is_samity_product_fundname_need=='1'){									
									 echo 'PKSF';
									 echo $row->samity_code_separator;
									}
									
								if(isset($row->is_include_branch_code_for_samity) && $row->is_include_branch_code_for_samity=='1'){
									for($i=0;$i<$row->branch_code_length-1;$i++){
											echo '0';
										}
									 echo '1';
									}
								}
						?>
						</span>
					</div>
				</td>
			</tr>
			<tr>
				<td width="16%"><label for="txt_name">Fund Name:</label></td>
				<td colspan='5'></td>		
				
			</tr>			
			<tr>
				<td align="left">	
					<span>
						<?php
						$attr = 'id="samity_product_fund_name" ';
						echo form_dropdown('samity_product_fund_name', $type_options_loan_fund,  isset($row->is_samity_product_fundname_need)?$row->is_samity_product_fundname_need:"", $attr);
						?>
					</span>
				</td>
				<td colspan="5">&nbsp;</td>
			</tr>
			<tr class="spacer"><td colspan="6"></td></tr>
		</tbody>
		
		<tbody>
			<tr><th colspan="6">Member Code</th></tr>
			<tr>
				<td width="16%"><label for="txt_name">Member Need?:<em></em></label></td>
				<td width="16%"><label for="cbo_samity">Length:<em></em></label></td>
				<td width="16%"><label for="cbo_group" style="text-align:left;">Include Samity Code?:<em></em></label></td>
				<td width="16%"><label for="cbo_sub_group" style="text-align:left;">Include Branch Code?:<em></em></label></td>
				<td width="16%"><label for="cbo_sub_group">Separator:<em></em></label></td>
				<td width="16%"><label for="cbo_sub_group">Sample Code: <em></em></label></td>
			</tr>
			<tr>
				<td align="left">	
					<span><input id="txt_is_member_code_need" <?php if(isset($row->is_member_code_need) && $row->is_member_code_need=='1') {echo "checked='TRUE'";}?> name="txt_is_member_code_need" type="checkbox" value="1" style="width:20px;border:none;"></span>
				</td>				
				<td>	
					<span>
						<?php
						$attr = 'id="member_code_length"  ';
						echo form_dropdown('member_code_length', $config_code_length,  isset($row->member_code_length)?$row->member_code_length:"", $attr);
						?>
					</span>
				</td>
				<td>
					<span><input id="txt_is_include_samity_code_for_member" <?php if(isset($row->is_include_samity_code_for_member) && $row->is_include_samity_code_for_member=='1') {echo "checked='TRUE'";}?>name="txt_is_include_samity_code_for_member" type="checkbox" value="1" style="width:20px;border:none;"></span>
				</td>
				<td>
					<span><input id="txt_is_include_branch_code_for_member" <?php if( isset($row->is_include_branch_code_for_member) && $row->is_include_branch_code_for_member=='1') {echo "checked='TRUE'";}?>name="txt_is_include_branch_code_for_member" type="checkbox" value="1" style="width:20px;border:none;"></span>
				</td>
				<td>
					<span>
						<?php
						$attr = 'id="member_code_separator"   ';
						echo form_dropdown('member_code_separator', $config_code_separator,  isset($row->member_code_separator)?$row->member_code_separator:"", $attr);
						?>
					</span>
				</td>
				<td><div><span id="display_member_sample_code">
							<?php 
							if(isset($row->member_code_separator)) {
								if(isset($row->is_member_code_need) && $row->is_member_code_need=='1'){
									for($i=0;$i<$row->branch_code_length-1;$i++){
											echo '0';
										}
									 echo '1';
									}
									echo $row->member_code_separator;
								
								if(isset($row->is_samity_code_need) && $row->is_samity_code_need=='1'){
									for($i=0;$i<$row->samity_code_length-1;$i++){
											echo '0';
										}
									 echo '1';
									}
									echo $row->member_code_separator;									
								
								if(isset($row->is_member_code_need) && $row->is_member_code_need=='1'){
									for($i=0;$i<$row->member_code_length-1;$i++){
											echo '0';
										}
									 echo '1';
									}
								}
						?>
				
				</span></div></td>
			</tr>
			<tr class="spacer"><td colspan="6"></td></tr>
		</tbody>
		
		<tbody>
			<tr><th colspan="6">Savings Id Code</th></tr>
			<tr>
				<td width="16%"><label for="txt_name">Product Code:<em></em></label></td>
				<td width="16%"><label for="txt_name">Short Name:<em></em></label></td>				
				<td width="16%"><label for="cbo_group" style="text-align:left;">Include Member Code?:<em></em></label></td>
				<td width="16%"><label for="cbo_samity">Separator:<em></em></label></td>
				<td width="16%"><label for="cbo_sub_group">Sample Code:<em></em></label></td>
				<td width="16%"><label for="cbo_sub_group">&nbsp;<em></em></label></td>				
			</tr>
			<tr>
				<td align="left">	
					<span>
						<?php
						$attr = 'id="savings_product_code_length"  '; 
						echo form_dropdown('savings_product_code_length', $type_options_product_code,  isset($row->is_saving_code_need)?$row->is_saving_code_need:"", $attr);
						?>	
					</span>
				</td>				
				<td align="left">	
					<span>
						<?php
						$attr = 'id="savings_product_short_name"  ';
						echo form_dropdown('savings_product_short_name', $type_options_product_name,  isset($row->is_saving_product_short_name_need)?$row->is_saving_product_short_name_need:"", $attr);
						?>	
					</span>
				</td>			
				
				<td>
					<span><input id="txt_is_include_member_code_for_savings" <?php if(isset($row->is_include_member_code_for_savings) && $row->is_include_member_code_for_savings=='1') {echo "checked='TRUE'";}?> name="txt_is_include_member_code_for_savings" type="checkbox" value="1" style="width:20px;border:none;"></span>
				</td>
				<td>	
					<span>
						<?php
						$attr = 'id="savings_code_separator"  ';
						echo form_dropdown('savings_code_separator', $config_code_separator,  isset($row->savings_code_separator)?$row->savings_code_separator:"", $attr);
						?>					
					</span>
				</td>
				<td>
					<div><span id="display_saving_id_sample_code">
							<?php 
							if(isset($row->savings_code_separator)){
								if(isset($row->is_saving_code_need) && $row->is_saving_code_need=='1'){
									echo '201';
									echo $row->savings_code_separator;
								
								if(isset($row->is_saving_product_short_name_need) && $row->is_saving_product_short_name_need=='1'){
									echo 'COM';
									echo $row->savings_code_separator;
								}								
								
								if(isset($row->is_include_member_code_for_savings) && $row->is_include_member_code_for_savings=='1'){										
										
										if($row->is_member_code_need=='1'){
												for($i=0;$i<$row->branch_code_length-1;$i++){
														echo '0';
													}
												 echo '1';
												}
												echo $row->member_code_separator;
											
											if($row->is_samity_code_need=='1'){
												for($i=0;$i<$row->samity_code_length-1;$i++){
														echo '0';
													}
												 echo '1';
												}
												echo $row->member_code_separator;									
											
											if($row->is_member_code_need=='1'){
												for($i=0;$i<$row->member_code_length-1;$i++){
														echo '0';
													}
												 echo '1';
												}
									
									}
								}
						}
						?>
					
						</span></div>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr class="spacer"><td colspan="6"></td></tr>
		</tbody>
	
		<tbody>
			<tr><th colspan="6">Loan Id Code</th></tr>
			<tr>
				<td width="16%"><label for="txt_name">Product Code:<em></em></label></td>
				<td width="16%"><label for="txt_name">Short Name:<em></em></label></td>			
				<td width="16%"><label for="cbo_group" style="text-align:left;">Include Member Code?:<em></em></label></td>
				<td width="16%"><label for="cbo_samity">Cycle:<em></em></label></td>
				<td width="10%"><label for="cbo_sub_group">Separator:<em></em></label></td>
				<td width="25%"><label for="cbo_sub_group">Sample Code:<em></em></label></td>
			</tr>
			<tr>
				<td align="left">	
					<span>
						<?php
						$attr = 'id="product_loan_code_length" ';
						echo form_dropdown('product_loan_code_length', $type_options_product_code,  isset($row->is_loan_code_need)?$row->is_loan_code_need:"", $attr);
						?>
					</span>
				</td>
				<td align="left">	
					<span>
						<?php
						$attr = 'id="product_loan_code_shortname" '; 
						echo form_dropdown('product_loan_code_shortname', $type_options_product_name,  isset($row->is_loan_product_short_name_need)?$row->is_loan_product_short_name_need:"", $attr);
						?>
					</span>
				</td>
				<td>
					<span><input id="txt_is_include_member_code_for_loan"<?php if(isset($row->is_include_member_code_for_loan) && $row->is_include_member_code_for_loan=='1') {echo "checked='TRUE'";}?> name="txt_is_include_member_code_for_loan" type="checkbox" value="1" style="width:20px;border:none;"></span>
				</td>
				<td>	
					<span>
						<?php
						$attr = 'id="cycle_code"  ';
						echo form_dropdown('cycle_code', $type_options_cycle,  isset($row->is_cycle_need)?$row->is_cycle_need:"", $attr);
						?>	
					</span>
				</td>
				<td>
					<span>
						<?php
						$attr = 'id="loan_code_separator" ';
						echo form_dropdown('loan_code_separator', $config_code_separator,  isset($row->loan_code_separator)?$row->loan_code_separator:"", $attr);
						?>
					</span>
				</td>
				<td><div><span id="display_loan_id_sample_code">
						<?php 
						if(isset($row->loan_code_separator)) {
								if($row->is_loan_code_need=='1'){
									echo '101';
									echo $row->loan_code_separator;
								
								if($row->is_loan_product_fundname_need=='1'){
									echo 'PKSF';
									echo $row->loan_code_separator;
								}	
								
								if($row->is_loan_product_short_name_need=='1'){
									echo 'RMC';
									echo $row->loan_code_separator;
								}								
								
								if($row->is_include_member_code_for_loan=='1'){										
										
										if($row->is_member_code_need=='1'){
												for($i=0;$i<$row->branch_code_length-1;$i++){
														echo '0';
													}
												 echo '1';
												}
												echo $row->member_code_separator;
											
											if($row->is_samity_code_need=='1'){
												for($i=0;$i<$row->samity_code_length-1;$i++){
														echo '0';
													}
												 echo '1';
												}
												echo $row->member_code_separator;									
											
											if($row->is_member_code_need=='1'){
												for($i=0;$i<$row->member_code_length-1;$i++){
														echo '0';
													}
												 echo '1';
												}
												
											echo $row->loan_code_separator;
									
									}
									
									if($row->is_cycle_need=='1'){
											echo '1';
											
										}	
								}
					}
						?>				
				</span></div></td>
			</tr>
			<tr>
				<td width="16%"><label for="txt_name">Fund Name:</label></td>
				<td colspan='5'></td>		
				
			</tr>			
			<tr>
				<td align="left">	
					<span>
						<?php
						$attr = 'id="product_loan_fund_name" ';
						echo form_dropdown('product_loan_fund_name', $type_options_loan_fund,  isset($row->is_loan_product_fundname_need)?$row->is_loan_product_fundname_need:"", $attr);
						?>
					</span>
				</td>
				<td colspan="5">&nbsp;</td>
			</tr>
			<tr class="spacer">
				<td colspan="6">&nbsp;</td>
			</tr>
		</tbody>	
		<!--</table>
    	<table class="addForm" border="0" cellspacing="0px" cellpadding="0px" width="99%">-->
		<tbody>
			<tr class="spacer"><td colspan="6"><hr></td></tr>
			<tr>
				<td colspan="6" align="left" class="">
                    <?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('config_customized_ids')."'"));?>
				</td>
			</tr>
		</tbody>
        </table>
<?php echo form_close(); ?>
</fieldset>

