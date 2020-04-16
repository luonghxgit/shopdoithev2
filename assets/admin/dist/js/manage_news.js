(function($, win){
    var obj = new function(){
        var me = this;
		var base_url = 'http://manggiaodich.vn/';
        var _constructor = function(){
            initEvent();
			DataTable();
			date_picker();
        };
		var DataTable = function(){
			
			$('#table_indicator').DataTable({
				"lengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
				"paging": true,
				"lengthChange": true,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": true,
				"language": {
					"lengthMenu": "Hiển thị _MENU_ bản ghi trên 1 trang",
					"info": "Hiển thị trang _PAGE_ của _PAGES_",
					"search": "Tìm kiếm thiết lập",
					"paginate": {
					  "previous": "Trang trước",
					  "next": "Trang sau"
					}
				}
			});
		}
		
		var date_picker = function(){
			
			// datepicker 
            $('.datepicker').datepicker({format: 'dd-mm-yyyy', autoclose: false, language: 'vi',
			showOn: "both",
			buttonImage: "",
			buttonImageOnly: false,
			startDate: "+7d",
			}).on('changeDate', function (ev) {
				$(this).datepicker('hide');
			});
			$('#img_calendar').click(function(){
				$('.datepicker').datepicker('show');
			})
			$('.datepicker').datepicker('update', new Date());
		}
		
		var create_frequent = function(frequent){
			var frequent_html ='<select id="frequent" class="form-control" name="frequent" style=""><option value="0">Chọn tần suất gửi tin</option>';
				for(var i = 0; i < frequent.length;i++){
					frequent_html +='<option value="'+frequent[i].value+'">'+frequent[i].name+'</option>';
					
				}
				frequent_html +='</select>';
			return 	frequent_html; 
			
		}
		 
		 var create_alert = function (name_alert,title,content){
			if(!$(document).find('#'+name_alert).length){
				var html_alert = '<div id="'+name_alert+'" class="modal fade" role="dialog">';
				html_alert		   += '<div class="modal-dialog">';
				html_alert		   += '<div class="modal-content">';
				html_alert		   +='<div class="modal-header">';
				html_alert		   +='<button type="button" class="close btn-close-modal" data-dismiss="modal">&times;</button>';
				html_alert		   +='<h4 class="modal-title">'+title+'</h4>';
				html_alert		   +='</div>';
				html_alert		   +='<div class="modal-body">';
				html_alert		   +='<p><b>'+content+'</b></p>';
				html_alert		   +='</div>';
				html_alert		   +='<div class="modal-footer">';
				html_alert		   +='<button type="button" class="btn btn-primary btn-close-modal right" data-dismiss="modal">Đóng</button>';
				html_alert		   +='</div>';
				html_alert		   +='</div>';
				html_alert		   +='</div>';
				html_alert		   +='</div>';
				$('body').append(html_alert);
			}
			
			$('#'+name_alert).modal('show');
		}
		
		var initEvent = function(){
			
		$('#indicator').on('change', function(){
			 var indi_code = $(this).val();
		     console.log(indi_code);
			 var document = {indicator: indi_code};
			 $.ajax({
				type: 'POST',
				url: base_url+'manage/get_indicator_news',
				data: document,
				success: function (result) {
					if(result){
						var result = JSON.parse(result);
						var frequent = result.frequent;
						var frequent_html = create_frequent(frequent);
						console.log(frequent_html);
						$('#select_frequent').html(frequent_html);
						$('.img_intro').attr('src',result.img_intro);
					}
					
				}
			 });
		});
		   
		   
		   $('#btn_dangky').click(function () {
			
				var indicator = $('#indicator').val();
				var indicator_text = $("#indicator :selected").text();
				var expired = $('#expired').val();
				var frequent = $('#frequent').val();
				var frequent_text =  $("#frequent :selected").text();
				
				//Check kiểm tra Indicator
				
				// if(indicator == 'BAOCAOTHITRUONG'){
					// frequent = 'daucuoi';
				// }
				// if(indicator == 'TINTUCTRONGGIO'){
					// frequent = $('#frequent_news_inhour').val();
				// }
				// if(indicator == 'CAPNHATF319'){
					// frequent = $('#frequent_news_f319').val();
				// }
				// if(indicator == 'FLASHMESSAGE'){
					// frequent = $('#frequent_news_flash').val();
				// }
				// if(indicator == 'GIADAU'){
					// frequent = $('#frequent_news_inhour').val();
				// }
				
				if(indicator==0){
					create_alert('alert_indicator','[MangGiaoDich.vn] - Thiết lập cảnh báo tin tức','[MGD-WARNING] Bạn phải nhập ít nhất một Indicator cảnh báo!');
					return false;
				}
				
			
				if(!frequent || frequent==0){
					create_alert('alert_frequent','[MangGiaoDich.vn] - Thiết lập cảnh báo tin tức','[MGD-WARNING] Bạn phải nhập tần suất gửi tin');
					return false;
				}
				
				if(!expired){
					create_alert('alert_expired','[MangGiaoDich.vn] - Thiết lập cảnh báo tin tức','[MGD-WARNING] Bạn phải nhập thời gian hết hạn');
					return false;
				}
				
				var document = {indicator: indicator, frequent: frequent, expired: expired};
					$.ajax({
							type: 'POST',
							url: 'http://manggiaodich.vn/manage/save_setting_noti_news',
							data: document,
							success: function (result) {
								if(result){
							var result = JSON.parse(result);
							var status = result.status;
							console.log(result);
							if(status==1){
								var html_append = '<tr class="highlight" style=""><td>'+indicator_text+'</td><td>'+frequent_text+'</td><td>'+expired+'</td><td><a href="http://manggiaodich.vn/manage/delete_news?id='+result.doc_id+'" class="badge bg-red">Xóa</a></td></tr>';
								$('#modal_success').modal('show');
								$('#table_indicator tbody tr').eq(0).before(html_append).slideDown();
							}
							else{
								create_alert('name_warning','[MangGiaoDich.vn] - Thiết lập cảnh báo tin tức','[MGD-WARNING] '+result.message);
							}
						}
					},
					error: function (err, result) {
						alert("Error in delete" + err.responseText);
					}
				});
				return false;
			});
			
			$("#myModal").on("hidden", function () {
				$('#result').html('yes,result');
			});

        };
		
		$(document).ready(function(){
            _constructor();
        });
    };
    win.Custom = obj;
})(jQuery, window);