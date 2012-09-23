<!-- BEGIN: main -->
<!-- BEGIN: quantri -->
<h3>{LANG.quantricm}</h3>
<form action="" id="website" method="post">
    <p>{LANG.chonsite}</p>
    <input  type="hidden" value="w" name="we"/>
    <select name="web" id="web">
        {website}
    </select>
</form>
<form name="block_list" action="">
	<table summary="" class="tab1">
       
		<thead>
			<tr>
				<td align="center"><input name="check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" /></td>
				<td align="center">{LANG.chuyenmuc}</td>
				<td align="center">{LANG.linkchuyenmuc}</td>
				<td align="center">{LANG.linksite}</td>
				<td></td>
			</tr>
		</thead>
		<!-- BEGIN: loop -->
		<tbody>
			<tr align="center">
				<td align="center"><input type="checkbox" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" value="{ROW.id}" name="idcheck[]" /></td>
				<td align="left">{ROW.chuyenmuc}</td>
				<td>{ROW.linkchuyenmuc}</td>
				<td>{ROW.linksite}</td>
				<td>
					{ROW.feature}
				</td>
			</tr>
		</tbody>
		<!-- END: loop -->
		<tbody>
			<tr align="left" class="tfoot_box">
				<td colspan="7">
					<select name="action" id="action">
						<!-- BEGIN: action -->
						<option value="{ACTION.value}">{ACTION.title}</option>
						<!-- END: action -->
					</select>
					<input type="button" onclick="nv_main_action1(this.form, '{SITEKEY}', '{LANG.msgnocheck}')" value="{LANG.action}" />
				</td>
			</tr>
		</tbody>
	</table>
</form>
<!-- END: quantri -->
<script type="text/javascript">
    $(document).ready(function(){
        $("#web").change(function(){
           $("#website").submit();
        })
    })
</script>
<!-- END: main -->