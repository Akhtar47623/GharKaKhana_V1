
<style>
table, td, th {
  border: 1px solid black;
}

table {
  width:100%;
  border-collapse: collapse;

}
td{
	padding: 10px;
}

</style>

<h1>{{__('mexico-contract.title')}}</h1>
<p>{{__('mexico-contract.first-line-one')}} <b>{{__('mexico-contract.first-line-two')}}</b> {{__('mexico-contract.first-line-three')}} <b>{{__('mexico-contract.first-line-four')}}</b> {{__('mexico-contract.first-line-five')}} {{!empty($display_name)?strtoupper($display_name):'____________________'}}{{__('mexico-contract.first-line-six')}}</p>

<h3><u>{{__('mexico-contract.declaration')}}</u></h3>
<ol class="roman">
	<li>{{__('mexico-contract.declaration-one-1')}} <b>{{__('mexico-contract.first-line-four')}}</b>
		{{__('mexico-contract.declaration-one-2')}} <b>
		{{!empty($display_name)?__('mexico-contract.declaration-one-3'):'____________________'}}</b> 
		{{__('mexico-contract.declaration-one-4')}} <b>
		{{!empty($display_name)?__('mexico-contract.declaration-one-5'):'____________________'}}</b> 
		{{__('mexico-contract.declaration-one-6')}} <b>
		{{!empty($display_name)?__('mexico-contract.declaration-one-7'):'____________________'}}</b>
		{{__('mexico-contract.declaration-one-8')}} <b>
		{{!empty($display_name)?__('mexico-contract.declaration-one-9'):'____________________'}}</b>
		{{__('mexico-contract.declaration-one-10')}}</li>


	<li>{{__('mexico-contract.declaration-two')}}</li>

	<li>{{__('mexico-contract.declaration-three')}}</li>

	<li>{{__('mexico-contract.declaration-four')}}</li>

	<li>{{__('mexico-contract.declaration-five')}}</li>

	<li>{{__('mexico-contract.declaration-six-1')}} {{!empty($display_name)?strtoupper($display_name):'____________________'}} {{__('mexico-contract.declaration-six-2')}} {{!empty($address)?strtoupper($address):'__________________________________'}}{{__('mexico-contract.declaration-six-3')}}</li>

	<li>{{__('mexico-contract.declaration-seven')}}</li>

	<li>{{__('mexico-contract.declaration-eight')}}</li>

	<li>{{__('mexico-contract.declaration-nine')}}</li>

	<li>{{__('mexico-contract.declaration-ten')}}</li>
</ol>

<p>{{__('mexico-contract.declaration-last')}}</p>

<h3><u>{{__('mexico-contract.clauses')}}</u></h3>

<p>{{__('mexico-contract.clauses-one')}}</p>

<p>{{__('mexico-contract.clauses-two')}}</p>

<p>{{__('mexico-contract.clauses-three')}}</p>

<p>{{__('mexico-contract.clauses-four')}}</p>

<p>{{__('mexico-contract.clauses-five')}}</p>

<ol type='a'>
	<li>{{__('mexico-contract.clauses-five-1')}}</li>
	<li>{{__('mexico-contract.clauses-five-2')}}</li>
	<li>{{__('mexico-contract.clauses-five-3')}}</li>
</ol>

<h3>{{__('mexico-contract.desc-chef')}}</h3>
<p>{{__('mexico-contract.desc-chef-one')}}</p>

<p>{{__('mexico-contract.chef-res')}}</p>

<p>{{__('mexico-contract.chef-res-one')}}</p>

<p>{{__('mexico-contract.chef-res-two')}}</p>

<p>{{__('mexico-contract.chef-reg-req')}}</p>

<p>{{__('mexico-contract.chef-reg-one')}}</p>

<p>{{__('mexico-contract.chef-reg-two')}}</p>

<p>{{__('mexico-contract.chef-accepts')}}</p>
<ol type='a'>
	<li>{{__('mexico-contract.chef-accepts-one')}}</li>
	<li>{{__('mexico-contract.chef-accepts-two')}}</li>
</ol>

<p>{{__('mexico-contract.modi-ser')}}</p>

<p>{{__('mexico-contract.modi-ser-desc')}}</p>

<p>{{__('mexico-contract.inactive-acc')}}</p>

<p>{{__('mexico-contract.inactive-acc-desc')}}</p>

<p>{{__('mexico-contract.service')}}</p>

<p>{{__('mexico-contract.service-one')}}</p>
<ol type='a'>
	<li>{{__('mexico-contract.service-one-1')}}</li>
	<li>{{__('mexico-contract.service-one-2')}}</li>
	<li>{{__('mexico-contract.service-one-3')}}</li>
</ol>

<p>{{__('mexico-contract.service-one-desc')}}</p>

<p>{{__('mexico-contract.contact')}}</p>

<p>{{__('mexico-contract.contact-one')}}</p>

<p>{{__('mexico-contract.contact-two')}}</p>

<P>{{__('mexico-contract.contact-three')}}</P>

<p>{{__('mexico-contract.contact-four')}}</p>

<p>{{__('mexico-contract.contact-five')}}</p>

<p>{{__('mexico-contract.del-one')}}</p>

<ol type='a'>
	<li>{{__('mexico-contract.del-one-1')}}</li>

	<li>{{__('mexico-contract.del-one-2')}}</li>
</ol>

<p>{{__('mexico-contract.del-two')}}</p>

<ol type='a' start=3>
	<li>{{__('mexico-contract.del-two-1')}}</li>

	<li>{{__('mexico-contract.del-two-2')}}</li>

	<li>{{__('mexico-contract.del-two-3')}}</li>
</ol>

<p>{{__('mexico-contract.ser-com')}}</p>

<ol type='a'>
	<li>{{__('mexico-contract.ser-com-one')}}</li>

	<li>{{__('mexico-contract.ser-com-two')}}
		<ol type='i'>
			<li>{{__('mexico-contract.ser-com-two-1')}}</li>
			<li>{{__('mexico-contract.ser-com-two-2')}}</li>
		</ol>
	</li>
</ol>

<p>{{__('mexico-contract.exp')}}</p>

<p>{{__('mexico-contract.rev-audit')}}</p>

<p>{{__('mexico-contract.labour')}}</p>

<p>{{__('mexico-contract.publicity')}}</p>

<p>{{__('mexico-contract.term-con')}}</p>

<p>{{__('mexico-contract.term-con-one')}}</p>

<p>{{__('mexico-contract.term-con-two')}}</p>


<ol class='decimal'>
	<li>{{__('mexico-contract.info')}}</li>
	<ol type='a'>

		<li>{{__('mexico-contract.info-one')}}</li>
		<li>{{__('mexico-contract.info-two')}}</li>
		<li>{{__('mexico-contract.info-three')}}</li>	
		<li>{{__('mexico-contract.info-four')}}</li>
		<li>{{__('mexico-contract.info-five')}}</li>
		<li>{{__('mexico-contract.info-six')}}</li>
		
		<ol class="roman">	
			<li>{{__('mexico-contract.info-six-1')}}</li>
			<li>{{__('mexico-contract.info-six-2')}}</li>
			<li>{{__('mexico-contract.info-six-3')}}</li>
			<li>{{__('mexico-contract.info-six-4')}}</li>
			<li>{{__('mexico-contract.info-six-5')}}</li>
			<li>{{__('mexico-contract.info-six-6')}}</li>		
			<li>{{__('mexico-contract.info-six-7')}}</li>
			<li>{{__('mexico-contract.info-six-8')}}</li>		
			<li>{{__('mexico-contract.info-six-9')}}</li>
			<li>{{__('mexico-contract.info-six-10')}}</li>
			<li>{{__('mexico-contract.info-six-11')}}</li>
		</ol>
	</ol>
</ol>

<p>{{__('mexico-contract.dec-guarantee')}}</p>
<ul type='disc'>
	<li>{{__('mexico-contract.dec-guarantee-1')}}</li>
	<li>{{__('mexico-contract.dec-guarantee-2')}}</li>
	<li>{{__('mexico-contract.dec-guarantee-3')}}</li>
	<li>{{__('mexico-contract.dec-guarantee-4')}}</li>
	<li>{{__('mexico-contract.dec-guarantee-5')}}</li>
	<li>{{__('mexico-contract.dec-guarantee-6')}}</li>
	<li>{{__('mexico-contract.dec-guarantee-7')}}</li>
	<li>{{__('mexico-contract.dec-guarantee-8')}}</li>
	<li>{{__('mexico-contract.dec-guarantee-9')}}</li>

</ul>


<p>{{__('mexico-contract.chef-guarantee')}}</p>
<ul type='disc'>
	<li>{{__('mexico-contract.chef-guarantee-1')}}</li>
	<li>{{__('mexico-contract.chef-guarantee-2')}}</li>
	<li>{{__('mexico-contract.chef-guarantee-3')}}</li>
	<li>{{__('mexico-contract.chef-guarantee-4')}}</li>
	<li>{{__('mexico-contract.chef-guarantee-5')}}</li>
	<li>{{__('mexico-contract.chef-guarantee-6')}}</li>
	<li>{{__('mexico-contract.chef-guarantee-7')}}</li>
	<li>{{__('mexico-contract.chef-guarantee-8')}}</li>
	<li>{{__('mexico-contract.chef-guarantee-9')}}</li>
	<li>{{__('mexico-contract.chef-guarantee-10')}}</li>
	<li>{{__('mexico-contract.chef-guarantee-11')}}</li>
	<li>{{__('mexico-contract.chef-guarantee-12')}}</li>
</ul>

<p>{{__('mexico-contract.chef-guarantee-res')}}</p>

<ul type='disc'>
	<li>{{__('mexico-contract.chef-guarantee-res-one')}}</li>

	<li>{{__('mexico-contract.chef-guarantee-res-two')}}
		<ul type='circle'>
			<li>{{__('mexico-contract.chef-guarantee-res-two-1')}}</li>
			<li>{{__('mexico-contract.chef-guarantee-res-two-2')}}</li>
			<li>{{__('mexico-contract.chef-guarantee-res-two-3')}}</li>
			<li>{{__('mexico-contract.chef-guarantee-res-two-4')}}</li>
			<li>{{__('mexico-contract.chef-guarantee-res-two-5')}}</li>
		</ul>
	</li>
</ul>

<p>{{__('mexico-contract.ser-cmpny1')}}</p>

<p>{{__('mexico-contract.ser-cmpny2')}}</p>

<p>{{__('mexico-contract.cust-rev')}}</p>

<p>{{__('mexico-contract.cust-rev-desc')}}</p>

	<ol class='decimal'>
		<li>{{__('mexico-contract.cust-rev-rl1')}}</li>
		<li>{{__('mexico-contract.cust-rev-rl2')}}</li>
		<li>{{__('mexico-contract.cust-rev-rl3')}}</li>
		<li>{{__('mexico-contract.cust-rev-rl4')}}</li>
		<li>{{__('mexico-contract.cust-rev-rl5')}}
			<ol type='a'>
				<li>{{__('mexico-contract.cust-rev-rl1-1')}}</li>
				<li>{{__('mexico-contract.cust-rev-rl1-2')}}</li>
				<li>{{__('mexico-contract.cust-rev-rl1-3')}}</li>
			</ol>
		</li>
	</ol>

<p>{{__('mexico-contract.chef-agrees')}}</p>
	<ol class='decimal'>
		<li>{{__('mexico-contract.chef-agrees-1')}}</li>
		<li>{{__('mexico-contract.chef-agrees-2')}}</li>
		<li>{{__('mexico-contract.chef-agrees-3')}}</li>
		<li>{{__('mexico-contract.chef-agrees-4')}}</li>
		<li>{{__('mexico-contract.chef-agrees-5')}}</li>
		<li>{{__('mexico-contract.chef-agrees-6')}}</li>
	</ol>

<p>{{__('mexico-contract.service-cmpny')}}</p>

<p>{{__('mexico-contract.spe-notice')}}</p>

<p>{{__('mexico-contract.comm-use')}}</p>

<p>{{__('mexico-contract.fees-one')}} <a href='https://prepbychef.com/mexico-fee-policy'><b>https://prepbychef.com/mexico-fee-policy</b></a>{{__('mexico-contract.fees-two')}}</p>

<p>{{__('mexico-contract.taxes')}}</p>

<p>{{__('mexico-contract.cust-respo')}}</p>

<p>{{__('mexico-contract.meal')}}</p>

<p>{{__('mexico-contract.chef-respo')}}</p>

<p>{{__('mexico-contract.promotions')}}</p>
<p>{{__('mexico-contract.the-service-cmpny')}}</p>

<p>{{__('mexico-contract.identity')}}</p>

<p>{{__('mexico-contract.in-some-place')}}</p>

<p>{{__('mexico-contract.the-service-offer')}}</p>

<p>{{__('mexico-contract.tenth')}}</p>

<p>{{__('mexico-contract.the-service-assumes')}}</p>

<p>{{__('mexico-contract.in-this-sense')}}</p>

<p>{{__('mexico-contract.eleventh')}}</p>

<p>{{__('mexico-contract.twelth')}}</p>

<p>{{__('mexico-contract.in-addition')}}</p>

<p>{{__('mexico-contract.thirteenth')}}</p>

<p>{{__('mexico-contract.fourteenth')}}</p>
	<ul type='disc'>
		<li>{{__('mexico-contract.fourteenth-one')}}</li>
		<li>{{__('mexico-contract.fourteenth-two')}}</li>
		<li>{{__('mexico-contract.fourteenth-three')}}</li>
		<li>{{__('mexico-contract.fourteenth-four')}}</li>
	</ul>

<p>{{__('mexico-contract.all-these')}}</p>
	<ol class='decimal'>
		<li>{{__('mexico-contract.all-these-one')}}</li>
		<li>{{__('mexico-contract.all-these-two')}}</li>
		<li>{{__('mexico-contract.all-these-three')}}</li>
	</ol>

<p>{{__('mexico-contract.fifteen')}}</p>

<p>{{__('mexico-contract.separability')}}</p>

<p>{{__('mexico-contract.integrity')}}</p>

<p>{{__('mexico-contract.modification')}}</p>

<p>{{__('mexico-contract.relation')}}</p>

<p>{{__('mexico-contract.nullity')}}</p>

<p>{{__('mexico-contract.interpretation')}}</p>

<p>{{__('mexico-contract.force-majeure')}}</p>

<p>{{__('mexico-contract.sixteenth')}}</p>

<p>{{__('mexico-contract.seventeenth')}}</p>

<p>{{__('mexico-contract.the ser-cmpny-gurantee')}}</p>

<p>{{__('mexico-contract.second-obligation')}}</p>
	<ol type='a'>
		<li>{{__('mexico-contract.second-obligation-one')}}</li>

		<li>{{__('mexico-contract.second-obligation-two')}}</li>

		<li>{{__('mexico-contract.second-obligation-three')}}</li>

		<li>{{__('mexico-contract.second-obligation-four')}}</li>

		<li>{{__('mexico-contract.second-obligation-five')}}</li>
	</ol>

<p>{{__('mexico-contract.eighteenth')}}</p>

<p>{{__('mexico-contract.signature-sheet-one')}} {{!empty($display_name)?strtoupper($display_name):'____________________'}} {{__('mexico-contract.signature-sheet-two')}}</p>

<table align='center' cellspacing=5>
	<tr>
		<td >{{__('mexico-contract.place-and-date')}}</td>
		<td>{{__('mexico-contract.this-contract')}} {{!empty($city)?$city:'____________'}} {{__('mexico-contract.on')}}
			 <?php $mytime = Carbon\Carbon::now(); echo !empty($city)?$mytime->toDateTimeString():'__________' ?></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center;">{{__('mexico-contract.the-chef')}}<br><br>
			<p style="font-family: 'Brittany Signature', sans-serif;">{{!empty($display_name)?strtoupper($display_name):''}}</p><br><br>{{__('mexico-contract.name-and-sign')}}</td>
	</tr>
	<tr>
		<td colspan='2' style="text-align:center;">{{__('mexico-contract.the-ser-cm')}}<br><br>
			<p style="font-family: 'Brittany Signature', sans-serif;">{{!empty($display_name)?'SRITA ANA CRISTINA RAMIREZ CANTORIO':''}}</p><br><br>{{__('mexico-contract.signature')}}</td>
	</tr>
	<tr>
		<td>{{__('mexico-contract.name')}}</td>
		<td>MAKEM INDUSTRIES TECH MEXICO</td>		
	</tr>
	<tr>
		<td>{{__('mexico-contract.representative')}}</td>
		<td>{{!empty($display_name)?'SRITA ANA CRISTINA RAMIREZ CANTORIO':''}}</td>
	</tr>
</table>
<br>
<br>














	









