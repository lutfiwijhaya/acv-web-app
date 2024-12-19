<section class="content-header"></section>
<div class="col-12">
	<div class="card">
	  <div class="easyui-panel" style="position:relative;overflow:auto;">
	    <div class="card-body">
	      <div class="easyui-layout">
	          <table id="dgGrid" title="<?= $title;?>" 
					toolbar="#toolbar" 
					class="easyui-datagrid" 
					rowNumbers="true" 
					pagination="true" 
					url="<?= base_url('admin/getstock_details/' . $item_id) ?>" 
					pageSize="20" 
					pageList="[10,20,50,75,100,125,150,200]" 
					nowrap="true" 
					singleSelect="true">
					<thead>
						<tr>
							<th field="kode_barang" width="10%">Kode Item</th>
							<!-- <th field="category" width="10%">Category</th> -->
							<th field="Level_1" width="10%">Level 1</th>
							<th field="level_2" width="10%">Level 2</th>
							<th field="level_3" width="10%">Level 3</th>
							<th field="level_4" width="10%">Level 4</th>
							<th field="wh_name" width="20%">In Warehouse</th>
							<th field="nama" width="20%">In Employee</th>
							<th field="quantity" width="10%">Quantity</th>
							<th field="inisial_kuantitas" width="10%">Qty</th>
							<th field="status" width="10%">Status</th>
							<th field="remark" width="10%">Remark</th>
						
						</tr>
					</thead>
				</table>

	          <div id="toolbar" style="padding: 10px">
	              <div class="row ml-1">
	                  <!-- <div class="col-sm-6">
	                  	<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-add" plain="false" onclick="newForm()">Add</a>
	                  	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="false" onclick="editForm()">Edit</a>
	                  	
	                  	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="false" onclick="destroy()">Delete</a>
	                  	
	                  </div> -->
	                  
	                  
					    <div class="col-sm-6 pull-right">
            <input id="search" placeholder="Please Enter Search a Level" style="width:60%;" align="right">
            <a href="javascript:void(0);" id="btn_search" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Search</a>
            <a href="javascript:void(0);" id="btn_back" class="easyui-linkbutton" iconCls="icon-back" plain="false" onclick="goBack()" style="margin-left: 90px;">Back</a>
        </div>
	              </div>
	          </div>
	        </div>
	    </div>
	  </div>
	  <!-- /.card-header -->
	  <!-- Dialog -->
	  <div id="dialog-form" class="easyui-window" title="Add New Menu" data-options="modal:true,closed:true,iconCls:'icon-save',inline:true,onResize:function(){
	          $(this).window('hcenter');
	      }" style="width:100%;max-width:500px;padding:30px 60px;">
	      	<form id="ff" class="easyui-form" method="post" data-options="novalidate:false" enctype="multipart/form-data">
	      		<div style="margin-bottom:20px">
					<input class="easyui-textbox" name="posisi" style="width:100%" data-options="label:'Posisi Pegawai:',required:true">
				</div>
				</form>
				<div id="dialog-buttons">
					<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="submitForm()">Simpan</a>
					<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
				</div>
	   </div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#dgGrid').datagrid({
        minHeight:410,
        maxHeight:520,
    });
    $('#search').keyup(function(event){
        if(event.keyCode == 13){
        $('#btn_serach').click();
        }
    });
});

function doSearch(){
	$('#dgGrid').datagrid('load',{
		search_data: $('#search').val()
	});
}

function formatLink(value, row, index){
    // Membuat link yang mengarahkan ke halaman admin/barang dengan parameter id
    return '<a href="<?= base_url('admin/barang/') ?>' + row.id + '">Detail Stock</a>';
}

function submitForm(){
	var string = $("#ff").serialize();
	$('#ff').form('submit',{
		url: url,
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(result){
			var result = eval('('+result+')');
			if (result.errorMsg){
				Toast.fire({
	              type: 'error',
	              title: ''+result.errorMsg+'.'
	              })
			} else {
				Toast.fire({
                  type: 'success',
                  title: ''+result.message+'.'
                })
				$('#dialog-form').dialog('close');		// close the dialog
				$('#dgGrid').datagrid('reload');	// reload the user data
			}
		}
	});
}

function newForm(){
	$('#dialog-form').dialog('open').dialog('setTitle','Add New Position');
	$('#ff').form('clear');
	url = 'savePosisi';
}

function editForm(){
	var row = $('#dgGrid').datagrid('getSelected');
		if (row){
			$('#dialog-form').dialog('open').dialog('setTitle','Edit Posisi' + row.posisi);
			$('#ff').form('load',row);
			url = 'updatePosisi?id='+row._id;
		}
}

function goBack() {
    // Fungsi ini akan kembali ke halaman sebelumnya
    window.history.back();
}

function hakakses(){
	var row = $('#dgGrid').datagrid('getSelected');
		if (row){
			window.location.replace("akses/"+row._id);
		}
}



</script>