<section class="content-header"></section>
<div class="col-12">
	<div class="card">
		<div class="easyui-panel" style="position:relative;overflow:auto;">
			<div class="card-body">
				<div class="easyui-layout">
					<table id="dgGrid" title="<?= $title; ?>"
						toolbar="#toolbar"
						class="easyui-datagrid"
						rowNumbers="true"
						pagination="true"
						url="<?= base_url('admin/getstock') ?>"
						pageSize="20"
						pageList="[10,20,50,75,100,125,150,200]"
						nowrap="true"
						singleSelect="true">
						<thead>
							<tr>
								<th field="kode_barang" width="10%">Kode Item</th>
								<th field="category" width="10%">Category</th>
								<th field="Level_1" width="10%">Level 1</th>
								<th field="level_2" width="10%">Level 2</th>
								<th field="level_3" width="10%">Level 3</th>
								<th field="level_4" width="10%">Level 4</th>
								<th field="total_quantity" width="10%">Quantity</th>
								<th field="inisial_kuantitas" width="10%">Qty</th>
								<th field="remark" width="10%">Remark</th>
								<th field="link_barang" width="10%" formatter="formatLink">Detail Stock</th>
								<th field="link_set" width="10%" formatter="formatLinkset">Detail Set</th>
								<th field="path_foto" width="10%" formatter="formatAction">Foto</th>
							</tr>
						</thead>
					</table>

					<div id="toolbar" style="padding: 10px">
						<div class="row ml-1">
							<div class="col-sm-6">
								<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-add" plain="false" onclick="newForm()">Add</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="false" onclick="editForm()">Edit</a>
								<!-- <a href="javascript:void(0)" class="easyui-linkbutton" plain="false" onclick="hakakses()"><i class="fas fa-users-cog"></i> Hak Akses</a> -->
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="false" onclick="delete_item()">Delete</a>

							</div>

							<div class="col-sm-6 pull-right">
								<input id="search" placeholder="Please Enter Search a Level" style="width:60%;" align="right">
								<a href="javascript:void(0);" id="btn_serach" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Search</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.card-header -->
		<!-- Dialog -->
		<div id="dialog-form" class="easyui-window" title="Add New Menu" data-options="modal:true,closed:true,iconCls:'icon-save',inline:false,onResize:function(){
    						$(this).window('hcenter');}" style="width:100%;max-width:500px;padding:30px 60px;max-height:500px;overflow-y:auto;">
			<form id="ff" class="easyui-form" method="post" data-options="novalidate:false" enctype="multipart/form-data">
				<div style="margin-bottom:20px">
					<input class="easyui-textbox" id="kode_barang" editable="false" name="kode_barang" style="width:100%" data-options="label:'Kode Barang:',required:true">
				</div>
				<div style="margin-bottom:20px">
					<input class="easyui-combobox" name="category" style="width:100%"
						data-options="label:'Category:',required:true,valueField:'param_name',textField:'param_name',url:'<?= base_url('admin/getCategoryParams') ?>'">
				</div>

				<div style="margin-bottom:20px">
					<input class="easyui-combobox" id="level_1" name="level_1" style="width:100%"
						data-options="label:'Level 1:',required:true,valueField:'param_name',textField:'param_name',url:'<?= base_url('admin/getLevel1Params') ?>',
   								">
				</div>
				<div style="margin-bottom:20px">
					<input class="easyui-combobox" id="level_2" name="level_2" style="width:100%"
						data-options="label:'Level 2:',required:true,valueField:'param_name',textField:'param_name',url:'<?= base_url('admin/getLevel2Params') ?>'">
				</div>
				<div style="margin-bottom:20px">
					<input class="easyui-combobox" id="level_3" name="level_3" style="width:100%"
						data-options="label:'Level 3:',required:true,valueField:'param_name',textField:'param_name',url:'<?= base_url('admin/getLevel3Params') ?>'">
				</div>

				<div style="margin-bottom:20px">
					<input class="easyui-combobox" id="level_4" name="level_4" style="width:100%"
						data-options="label:'Level 4:',required:true,valueField:'param_name',textField:'param_name',url:'<?= base_url('admin/getLevel4Params') ?>'">
				</div>

				<div style="margin-bottom:20px">
					<input class="easyui-textbox" name="remark" style="width:100%" data-options="label:'Remark:'">
				</div>
				<div style="margin-bottom:20px">
					<input class="easyui-combobox" name="inisial_kuantitas" style="width:100%"
						data-options="label:'Inisial Kuantitas:',required:true,valueField:'param_name',textField:'param_name',url:'<?= base_url('admin/getInisialKuantitasParams') ?>'">
				</div>
				<div style="margin-bottom:20px">
					<label for="foto">Upload Foto:</label>
					<input id="foto" name="foto" type="file" style="width:100%" data-options="label:'Upload Foto:',required:true">
					<small style="display:block; color:#666;">Hanya file foto Maks 200kb (jpg, jpeg, png)</small>
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
	$(document).ready(function() {
		$('#dgGrid').datagrid({
			minHeight: 410,
			maxHeight: 520,
		});
		$('#search').keyup(function(event) {
			if (event.keyCode == 13) {
				$('#btn_serach').click();
			}
		});
	});

	function doSearch() {
		$('#dgGrid').datagrid('load', {
			search_data: $('#search').val()
		});
	}

	function formatLink(value, row, index) {
		return '<a href="<?= base_url('admin/stock_details/') ?>' + row.id + '">Detail Stock</a>';
	}


	// function formatLinkset(value, row, index){
	//     return '<a href="<?= base_url('admin/setitem/') ?>' + row.id + '">Detail Set</a>';
	// }


	function formatLinkset(value, row, index) {
		// Ganti 'your-url-here' dengan URL yang diinginkan
		return '<a href="<?= base_url('admin/setitem2') ?>">Detail Set</a>';
	}


	// function submitForm(){
	// 	var string = $("#ff").serialize();
	// 	$('#ff').form('submit',{
	// 		url: url,
	// 		onSubmit: function(){
	// 			return $(this).form('validate');
	// 		},
	// 		success: function(result){
	// 			var result = eval('('+result+')');
	// 			if (result.errorMsg){
	// 				Toast.fire({
	// 	              type: 'error',
	// 	              title: ''+result.errorMsg+'.'
	// 	              })
	// 			} else {
	// 				Toast.fire({
	//                   type: 'success',
	//                   title: ''+result.message+'.'
	//                 })
	// 				$('#dialog-form').dialog('close');		// close the dialog
	// 				$('#dgGrid').datagrid('reload');	// reload the user data
	// 			}
	// 		}
	// 	});
	// }

	function submitForm() {
		var fileInput = document.getElementById('foto');
		if (fileInput.files.length > 0) {
			var fileSize = fileInput.files[0].size; // ukuran file dalam byte
			var maxSize = 200 * 1024; // 200 KB dalam byte

			if (fileSize > maxSize) {
				alert('Ukuran file tidak boleh lebih dari 200KB');
				return false; // menghentikan submit form jika ukuran file terlalu besar
			}
		}

		$('#ff').form('submit', {
			url: url,
			onSubmit: function() {
				return $(this).form('validate');
			},
			success: function(result) {
				var result = eval('(' + result + ')');
				if (result.errorMsg) {
					Toast.fire({
						type: 'error',
						title: '' + result.errorMsg + '.'
					});
				} else {
					Toast.fire({
						type: 'success',
						title: '' + result.message + '.'
					});
					$('#dialog-form').dialog('close'); // close the dialog
					$('#dgGrid').datagrid('reload'); // reload the user data
				}
			}
		});
	}

	function newForm() {
		$('#dialog-form').dialog('open').dialog('setTitle', 'Add New Item');
		$('#ff').form('clear');

		url = 'saveItemSet';
	}

	// function editForm(){
	// 	var row = $('#dgGrid').datagrid('getSelected');
	// 		if (row){
	// 			$('#dialog-form').dialog('open').dialog('setTitle','Edit Item ' + row.kode_barang);
	// 			$('#ff').form('load',row);
	// 			url = 'updateParams?id='+row.id;
	// 		}
	// }

	function delete_item() {
		var row = $('#dgGrid').datagrid('getSelected');
		if (row) {
			$.messager.confirm('Confirm', 'Are you sure you want to delete ? ' + row.kode_barang, function(r) {
				if (r) {
					$.post('delete_item', {
						id: row.id
					}, function(result) {
						if (result.errorMsg) {
							Toast.fire({
								type: 'error',
								title: '' + result.errorMsg + '.'
							})
						} else {
							Toast.fire({
								type: 'success',
								title: '' + result.message + '.'
							})
							$('#dgGrid').datagrid('reload');
						}
					}, 'json');
				}
			});
		}
	}

	function editForm() {
		var row = $('#dgGrid').datagrid('getSelected');
		if (row) {
			$('#dialog-form').dialog('open').dialog('setTitle', 'Edit Item ' + row.kode_barang);
			$('#ff').form('load', row);

			// Set combobox level_1 dengan nilai yang sesuai dari data row
			$('#level_1').combobox('setValue', row.Level_1);

			// Untuk level_2, lakukan reload berdasarkan level_1 yang terpilih
			$('#level_2').combobox('reload', '<?= base_url('admin/getLevel2Params') ?>?level_1=' + row.Level_1);

			// Disable kode_barang saat mode edit


			// URL untuk submit form update
			url = 'updateItem?id=' + row.id;
		}

	}



	// Variabel global untuk menyimpan status level 1, 2, 3, dan 4
	var statusLevel1 = '';
	var statusLevel2 = '';
	var statusLevel3 = '';
	var statusLevel4 = '';

	$('#level_1').combobox({
		onSelect: function(record) {

			var paramName = record.param_name;
			var paramst = record.status;
			var row = $('#dgGrid').datagrid('getSelected');

			// Simpan status level 1 ke variabel global
			statusLevel1 = paramst;

			// Set nilai kode_barang jika tidak sedang dalam mode edit
			if (!row) {
				$('#kode_barang').textbox('setValue', statusLevel1);
			}

			// Jika update item, tetap pertahankan nilai kode_barang dari row yang dipilih
			if (url === 'updateItem?id=' + row?.id) {
				$('#kode_barang').textbox('setValue', row.kode_barang);
			}

			// Reload level_2 berdasarkan level 1 yang dipilih
			$('#level_2').combobox('reload', '<?= base_url('admin/getLevel2shared') ?>?level_1=' + paramName);
		}
	});

	$('#level_2').combobox({
		onSelect: function(record) {
			var paramName = record.param_name;
			var paramst = record.status;
			var row = $('#dgGrid').datagrid('getSelected');

			// Simpan status level 2 ke variabel global
			statusLevel2 = paramst;

			// Gabungkan status level 1 dan level 2 untuk menghasilkan kode_barang
			var combinedStatus = statusLevel1 + '-' + statusLevel2;

			// Set nilai kode_barang dengan gabungan status level 1 dan 2
			if (!row) {
				$('#kode_barang').textbox('setValue', combinedStatus);
			}

			// Jika update item, tetap pertahankan nilai kode_barang dari row yang dipilih
			if (url === 'updateItem?id=' + row?.id) {
				$('#kode_barang').textbox('setValue', row.kode_barang);
			}

			// Reload level_3 berdasarkan level 2 yang dipilih
			$('#level_3').combobox('reload', '<?= base_url('admin/getLevel3Params') ?>?level_2=' + paramName);
		}
	});

	$('#level_3').combobox({
		onSelect: function(record) {
			var paramName = record.param_name;
			var paramst = record.status;
			var row = $('#dgGrid').datagrid('getSelected');

			// Simpan status level 3 ke variabel global
			statusLevel3 = paramst;

			// Gabungkan status level 1, 2, dan 3 untuk menghasilkan kode_barang
			var combinedStatus = statusLevel1 + '-' + statusLevel2 + '-' + statusLevel3;

			// Set nilai kode_barang dengan gabungan status level 1, 2, dan 3
			if (!row) {
				$('#kode_barang').textbox('setValue', combinedStatus);
			}

			// Jika update item, tetap pertahankan nilai kode_barang dari row yang dipilih
			if (url === 'updateItem?id=' + row?.id) {
				$('#kode_barang').textbox('setValue', row.kode_barang);
			}

			// Reload level_4 berdasarkan level 3 yang dipilih
			$('#level_4').combobox('reload', '<?= base_url('admin/getLevel4Params') ?>?level_3=' + paramName);
		}
	});

	$('#level_4').combobox({
		onSelect: function(record) {
			var paramName = record.param_name;
			var paramst = record.status;
			var row = $('#dgGrid').datagrid('getSelected');

			// Simpan status level 4 ke variabel global
			statusLevel4 = paramst;

			// Gabungkan status level 1, 2, 3, dan 4 untuk menghasilkan kode_barang
			var combinedStatus = statusLevel1 + '-' + statusLevel2 + '-' + statusLevel3 + '-' + statusLevel4;

			// Set nilai kode_barang dengan gabungan status level 1, 2, 3, dan 4
			if (!row) {
				$('#kode_barang').textbox('setValue', combinedStatus);
			}

			// Jika update item, tetap pertahankan nilai kode_barang dari row yang dipilih
			if (url === 'updateItem?id=' + row?.id) {
				$('#kode_barang').textbox('setValue', row.kode_barang);
			}
		}
	});






	function formatFoto(value, row, index) {
		if (value) {
			return '<img src="' + value + '" style="width:50px;height:50px;">'; // Thumbnail foto
		} else {
			return 'No Image'; // Jika tidak ada gambar
		}
	}

	function formatAction(value, row, index) {
		if (row.path_foto) {
			return '<a href="javascript:void(0);" onclick="showPhoto(\'' + row.path_foto + '\')">Tampilkan</a>';
		} else {
			return 'No Image';
		}
	}

	function showPhoto(photoUrl) {
		if (photoUrl) {
			var photoWindow = $('<div/>').window({
				title: 'Foto Item',
				width: 500,
				height: 400,
				modal: true,
				closed: false,
				content: '<img src="' + photoUrl + '" style="width:100%; height:auto;">',
				onClose: function() {
					$(this).window('destroy');
				}
			});
		} else {
			alert('Gambar tidak tersedia.');
		}
	}
</script>