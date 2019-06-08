<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<title>Monthly Invoice</title>
		<style type="text/css">
			body {
			   padding-top: 0 !important;
			   padding-bottom: 0 !important;
			   padding-top: 0 !important;
			   padding-bottom: 0 !important;
			   margin:0 !important;
			   width: 100% !important;
			   -webkit-text-size-adjust: 100% !important;
			   -ms-text-size-adjust: 100% !important;
			   -webkit-font-smoothing: antialiased !important;
			 }
			 .tableContent img {
			   border: 0 !important;
			   display: block !important;
			   outline: none !important;
			 }
			 ul{
				margin:0;
			 }
			p{
			color:#000;
			font-size: 16px;
			line-height: 24px;
			margin:0;
			}
			h2,h1{
			color:#000;
			font-size:21px;
			font-weight:normal;
			margin: 0;
			}
			h1 {
				color: #000;
				font-size: 40px;
				font-weight: normal;
				margin: 0;
				text-transform: uppercase;
			}
			h2.white{
				color:#ffffff;
			}
			table.table-total th, table.table-total td {
				padding: 10px;
			}
			table.table-total tbody tr:nth-of-type(odd) {
				background: #f5f5f5;
			}
			a{
			  color:#000000;
			}

			a.link1{
			  font-size:13px;
			  color:#000;
			  font-weight:bold;
			  text-decoration:none;
			}

			.bgBody{
			background: #ffffff;
			}
			.bgItem{
			background: #ffffff;
			}

			@media only screen and (max-width:480px)
					
			{
					
			table[class="MainContainer"], td[class="cell"] 
				{
					width: 100% !important;
					height:auto !important; 
				}
			td[class="specbundle"] 
				{
					width: 100% !important;
					float:left !important;
					font-size:14px !important;
					line-height:18px !important;
					display:block !important;
					padding-bottom:15px !important;
				}
					
			td[class="spechide"] 
				{
					display:none !important;
				}
					img[class="banner"] 
				{
						  width: 100% !important;
						  height: auto !important;
				}
					 
			}
				
			@media only screen and (max-width:540px) 

			{
					
			table[class="MainContainer"], td[class="cell"] 
				{
					width: 100% !important;
					height:auto !important; 
				}
			td[class="specbundle"] 
				{
					width: 100% !important;
					float:left !important;
					font-size:14px !important;
					line-height:18px !important;
					display:block !important;
					padding-bottom:15px !important;
				}
					
			td[class="spechide"] 
				{
					display:none !important;
				}
					img[class="banner"] 
				{
						  width: 100% !important;
						  height: auto !important;
				}
					
			}
	</style>

	<script type="colorScheme" class="swatch active">
	  {
		"name":"Default",
		"bgBody":"#f1f1f1",
		"link":"52999E",
		"color":"999999",
		"bgItem":"ffffff",
		"title":"555555"
	  }
	</script>
	</head>
	<body class='bgBody' leftpadding="0" offset="0" paddingheight="0" paddingwidth="0" style="padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;" toppadding="0">
		<table align="center" border="0" cellpadding="0" cellspacing="0" class="tableContent" width="100%">
		  <tbody>
			  <tr>
				  <td>
					  <table align="center" border="0" cellspacing="0" style="font-family:helvetica, sans-serif; background: #fbfbfb" width="600" class="MainContainer">
						  <tbody>
							  <tr>
								  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
									  <tbody>
										<tr>
										  <td valign="top" width="20">&nbsp;</td>
										  <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										  <!--  =========================== The header ===========================  -->
											  <tbody>
												 <tr>
												  <!--  =========================== The body ===========================  -->
												  <td class="movableContentContainer">
													 <div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
														<table border="0" cellpadding="0" cellspacing="0" width="100%">
															<tr>
																<td height="25">
																</td>
															</tr>
															<tr>
																<td>
																	<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
																		<tbody>
																			<tr>
																				<td align="left" valign="middle">
																					<div class="contentEditableContainer contentImageEditable">
																						<div class="contentEditable">
																						  <h1>Invoice</h1>
																						 </div>
																					</div>
																				</td>
																				<td align="right" valign="top">
																					<div class="contentEditableContainer contentImageEditable" style="display:inline-block;">
																						<div class="contentEditable">
																						   <p>Date: <?php echo date('d/m/Y',time());?></p>
																							</div>
																					</div>
																				</td>
																			
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</table>
													</div>
													<div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
														<table border="0" cellpadding="0" cellspacing="0" width="100%">
															<tr>
																<td height="25">
																</td>
															</tr>
															<tr>
																<td><p style="    font-size: 20px;">Invoice Number: {{$data->id}}</p></td>
															</tr>
														</table>
													</div>
												   <div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
														<table border="0" cellpadding="0" cellspacing="0" width="100%">
															<tbody>
																<tr>
																	<td height="25">
																	</td>
																</tr>
																<tr>
																	<td>
																		<table align="left" border="0" cellpadding="0" cellspacing="0" valign="top" width="100%">
																			<tbody>
																				<tr>
																					<td width="269" class="specbundle">
																						<table align="left" border="0" cellpadding="0" cellspacing="0" valign="top" width="100%">
																							<tbody>
																					
																								<tr>
																									
																									<td width="251" align="left" valign="middle">
																										<div class="contentEditableContainer contentImageEditable">
																											<div class="contentEditable">
																												<img src="https://satoshisolutions.online/public/images/logo.png" style="max-width: 200px;"/></div>
																										</div>
																									</td>
																									
																								</tr>
																								
																							</tbody>
																						</table>
																					</td>
																					<td width="18" class="specbundle">&nbsp;</td>
																					<td width="269"  class="specbundle">
																						<table align="left" border="0" cellpadding="0" cellspacing="0" valign="top" width="100%">
																							<tbody>
																								<tr>
																									<td width="9">
																									</td>
																									<td width="251" align="left" valign="middle">
																										<div class="contentEditableContainer contentImageEditable">
																											<div class="contentEditable">
																											  <ul style="margin: 0; padding: 0; list-style: none;">
																												 <li style="font-size: 18px; line-height: 24px; padding: 4px 0;">To: {{$data->name}}</li>
																												 <li  style="font-size: 18px; line-height: 24px; padding: 4px 0;">Email: {{$data->email}}</li>
																											  </ul>
																											</div>
																										</div>
																									</td>
																									<td width="9">
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																			</tbody>
																		</table>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
													<div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
														<table class="table-total" border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align: left; margin-top: 20px;">
														  <thead>
															  <tr>
																<th>Service</th>
																<th>Quantity</th>
																<th>SATC </th>
																<th>USD</th>
																<th>GBP</th>
															  </tr>
														  </thead>	
														   <tbody>
															  <tr>
																<td>Masternodes Hosting</td>
																<td>{{$data->frequency}}</td>
																<td>{{round($data->amount, 2)}}</td>
																<td>{{$data->usd}}</td>
																<td>{{$data->gbp}}</td>
															  </tr>
															 
															</tbody>	
															<tfoot>
															   <tr>
																   <th>
																   </th>
																   <th>
																   </th>
																   <th>
																   </th>
																   <th>
																	 Total 
																   </th>
																   <th>
																	  £{{$data->gbp}}
																   </th>
															  </tr>
															   <tr>
																   <th>
																   </th>
																   <th>
																   </th>
																   <th>
																   </th>
																   <th>
																	 Paid 
																   </th>
																   <th>
																	  £{{$data->gbp}} <br> <span style="font-size: 12px;">(Tax Incl.)</span>
																   </th>
															  </tr>
															</tfoot>						
													  </table>
													</div>
													<div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
														<table border="0" cellpadding="0" cellspacing="0" width="100%">
															<tbody>
																<tr>
																	<td height="25">
																	</td>
																</tr>
																<tr>
																	<td>
																		<table align="left" border="0" cellpadding="0" cellspacing="0" valign="top" width="100%">
																			<tbody>
																				<tr>
																					<td width="269" class="specbundle">
																						<table align="left" border="0" cellpadding="0" cellspacing="0" valign="top" width="100%">
																							<tbody>
																								<tr>
																									<td width="" align="left" valign="middle">
																										<p>Satoshi World Ltd. Reg. Nr 893453569</p>
																									</td>
																									<td width="" align="left" valign="middle">
																										<p>Email: admin@satoshicoin.world</p>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																			</tbody>
																		</table>
																	</td>
																</tr>
															</tbody>
														</table>
													  </div>
													  <div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
														<table border="0" cellpadding="0" cellspacing="0" width="100%">
															<tbody>
																<tr>
																	<td height="10">
																	</td>
																</tr>
																<tr>
																	<td>
																		<table align="center" border="0" cellpadding="0" cellspacing="0" valign="top" width="100%">
																			<tbody>
																				<tr>
																					<td width="269" class="specbundle">
																						<table align="center" border="0" cellpadding="0" cellspacing="0" valign="top" width="100%">
																							<tbody>
																								<tr>
																									<td width="" align="center" valign="middle">
																										<p>{{url('/')}}</p>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																			</tbody>
																		</table>
																	</td>
																</tr>
															</tbody>
														</table> 
													  </div>
												  </td>
												</tr>
											  </tbody>
												</table>
									      </td>
										  <td valign="top" width="20">&nbsp;</td>
										</tr>
									  </tbody>
							     </table>
							  </td>
							</tr>
						  </tbody>
				     </table>
			     </td>
			  </tr>
		  </tbody>
     </table>
   </body>
</html>
