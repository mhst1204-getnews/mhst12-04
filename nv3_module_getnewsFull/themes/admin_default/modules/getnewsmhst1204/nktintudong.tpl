<!-- BEGIN: main -->
<!-- BEGIN: chuyenmuc -->
<form name="block_list" action="" method="post">
	<table summary="" class="tab1">
        <caption>{LANG.danhsachcm}</caption>
		<thead>
			<tr>
				<td align="center"><input name="check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" /></td>
				<td><a href="{base_url_name}">{LANG.chuyenmuc}</a></td>
                <td>{LANG.trangweb}</td>
				<td align="center"><a href="{base_url_publtime}">{LANG.tgbd}</a></td>
                <td align="center">{LANG.tgtt}</td>
				<td align="center">{LANG.tglap}</td>
                <td align="center">{LANG.sotinmoi}</td>
                <td align="center">{LANG.trangthai}</td>
				<td align="center">{LANG.save}</td>
			</tr>
		</thead>
		<!-- BEGIN: loop -->
		<tbody {ROW.class}>
			<tr align="center">
				<td align="center"><input type="checkbox" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" value="{rowcontent.idcm}" name="idcheck[]" /></td>
				<td align="left"><a target="_blank" href="">{rowcontent.tencm}</a></td>
                <td align="center">{rowcontent.tenhost}</td>
				<td>{rowcontent.lasttime}</td>
				<td>{rowcontent.nexttime}</td>
				<td>
                        {rowcontent.type}
                </td>
                <td>{rowcontent.news}</td>
                <td>
                    
                        {rowcontent.auto}
                </td>
				<td>
					{rowcontent.feature}
				</td>
			</tr>
		</tbody>
		<!-- END: loop -->
		<tbody>
			<tr align="left" class="tfoot_box">
				<td colspan="9">
					<select name="action" id="action">
						<!-- BEGIN: action -->
						<option value="{ACTION.value}">{ACTION.title}</option>
						<!-- END: action -->
					</select>
					<input type="button" onclick="nv_main_action2(this.form, '{SITEKEY}', '{LANG.msgnocheck}')" value="{LANG.action}" />
				</td>
			</tr>
		</tbody>
	</table>
</form>
<!-- END: chuyenmuc -->
<form action="" id="website" method="post">
    <p>{LANG.chonsite}</p>
   
    <select name="web" id="web">
        {website}
    </select>
</form>
<form name="block_list" action="" method="post" id="form2">
	<table summary="" class="tab1">
        <caption>{LANG.danhsachtin}</caption>
		<thead>
			<tr>
				<td align="center"><input name="check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" /></td>
				<td width="90%">{LANG.name}</td>
				<td >{LANG.chuyenmuc}</td>
                <td >{LANG.trangweb}</td>
			</tr>
		</thead>
		<!-- BEGIN: loop -->
		<tbody {ROW.class}>
			<tr align="center">
				<td align="center"><input type="checkbox" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" value="{rowcontent1.id}" name="idcheck[]" /></td>
				<td align="left" ><a href="{rowcontent1.linksite}" target="_blank">{rowcontent1.tieude}</a></td>
				<td >{rowcontent1.chuyenmuc}</td>
				<td >{rowcontent1.host}</td>
			</tr>
		</tbody>
		<!-- END: loop -->
		<tbody>
			<tr align="left" class="tfoot_box">
				<td colspan="4">
					<select name="action1" id="action1">
						<!-- BEGIN: action -->
						<option value="{ACTION1.value}">{ACTION1.title}</option>
						<!-- END: action -->
					</select>
                    <select name="catid" id="catid">
                		<!-- BEGIN: cat_content -->
                		<option value="{CAT_CONTENT.value}" {CAT_CONTENT.selected} >{CAT_CONTENT.title}</option>
                		<!-- END: cat_content -->
                	</select>
					<input type="button" onclick="nv_main_action_auto(this.form, '{SITEKEY}', '{LANG.msgnocheck}')" value="{LANG.action}" />
                    <center><div id="thongbao" style="color:red;"></div></center>
				</td>
			</tr>
		</tbody>
	</table>
</form>
<!-- BEGIN: generate_page -->
<br />
<p align="center">{GENERATE_PAGE}</p>
<!-- END: generate_page -->
<script type="text/javascript">
    $(document).ready(function(){
        $("#catid").hide('fast');
        $("#action1").change(function(){
            var a=$("#action1").val();
            if(a=="publtime")$("#catid").show('fast');
            else $("#catid").hide('fast');
        })
        $("#web").change(function(){
           $("#website").submit();
        })
    })
</script>
 <!--END: main -->
 