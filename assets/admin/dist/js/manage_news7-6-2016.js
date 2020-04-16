(function($, win){
    var obj = new function(){
        var me = this;
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
		
		var initEvent = function(){
			
		$('#indicator').on('change', function(){
				
		   var indi_code = $(this).val();
			   if(indi_code == 'BAOCAOTHITRUONG' || indi_code == 'TINDAUNGAY'){
					$('#tonghopthitruong').css('display','');
					$('#giadau').css('display','none');
					$('#capnhatf319').css('display','none');
					$('#tintuctronggio').css('display','none');
					$('#flashmessage').css('display','none');
					//Css options
					$('#frequent').css('display','');
					$('#frequent_news_inhour').css('display','none');
					$('#frequent_news_f319').css('display','none');
					$('#frequent_news_flash').css('display','none');
			   }
			   if(indi_code == 'TINTUCTRONGGIO'){
					$('#tintuctronggio').css('display','');
					$('#capnhatf319').css('display','none');
					$('#giadau').css('display','none');
					$('#tonghopthitruong').css('display','none');
					$('#flashmessage').css('display','none');
					//Css options
					$('#frequent').css('display','none');
					$('#frequent_news_inhour').css('display','');
					$('#frequent_news_f319').css('display','none');
					$('#frequent_news_flash').css('display','none');
			   }
			   if(indi_code == 'CAPNHATF319'){
					$('#capnhatf319').css('display','');
					$('#giadau').css('display','none');
					$('#tintuctronggio').css('display','none');
					$('#tonghopthitruong').css('display','none');
					$('#flashmessage').css('display','none');
					//Css options
					$('#frequent').css('display','none');
					$('#frequent_news_inhour').css('display','none');
					$('#frequent_news_f319').css('display','');
					$('#frequent_news_flash').css('display','none');
			   }
			   if(indi_code == 'GIADAU'){
					$('#giadau').css('display','');
					$('#capnhatf319').css('display','none');
					$('#tintuctronggio').css('display','none');
					$('#tonghopthitruong').css('display','none');
					$('#flashmessage').css('display','none');
					//Css options
					$('#frequent').css('display','none');
					$('#frequent_news_inhour').css('display','');
					$('#frequent_news_f319').css('display','none');
					$('#frequent_news_flash').css('display','none');
			   }
			   if(indi_code == 'FLASHMESSAGE'){
					$('#flashmessage').css('display','');
					$('#giadau').css('display','none');
					$('#capnhatf319').css('display','none');
					$('#tintuctronggio').css('display','none');
					$('#tonghopthitruong').css('display','none');
					//Css options
					$('#frequent').css('display','none');
					$('#frequent_news_inhour').css('display','none');
					$('#frequent_news_f319').css('display','none');
					$('#frequent_news_flash').css('display','');
			   }
		   });
		   
		   
		   $('#btn_dangky').click(function () {
			
				var indicator = $('#indicator').val();
				var expired = $('#expired').val();
				var frequent;
				//Check kiểm tra Indicator
				
				if(indicator == 'BAOCAOTHITRUONG'){
					frequent = 'daucuoi';
				}
				if(indicator == 'TINTUCTRONGGIO'){
					frequent = $('#frequent_news_inhour').val();
				}
				if(indicator == 'CAPNHATF319'){
					frequent = $('#frequent_news_f319').val();
				}
				if(indicator == 'FLASHMESSAGE'){
					frequent = $('#frequent_news_flash').val();
				}
				if(indicator == 'GIADAU'){
					frequent = $('#frequent_news_inhour').val();
				}
				
				if(indicator==0){
					create_alert('alert_indicator','[MangGiaoDich.vn] - Thiết lập cảnh báo tin tức','[MGD-WARNING] Bạn phải nhập ít nhất một Indicator cảnh báo!');
					return false;
				}
				
				
				console.log('frequent',frequent);
				
				return false;
				
				if(!frequent){
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
								var indicator_html = '';
								if(indicator == 'BAOCAOTHITRUONG'){
									indicator_html = "Tổng hợp thị trường";
								}
								if(indicator == 'TINTUCTRONGGIO'){
									indicator_html = "Cập nhật cảnh báo tin trong giờ";
								}
								if(indicator == 'CAPNHATF319'){
									indicator_html = "15 phút qua F319 có gì";
								}
								if(indicator == 'FLASHMESSAGE'){
									indicator_html = "Cập nhật tin tức tức thì";
								}
								if(indicator == 'GIADAU'){
									indicator_html = "Báo cáo giá dầu và diễn biến các mã ngành dầu khí";
								}
								var str_frequent;
								if(frequent != 'daucuoi'){
									str_frequent = frequent+' Phút 1 lần trong phiên';
								}else{
									str_frequent = "Gửi đầu phiên và cuối phiên giao dịch";
								}
								var html_append = '<tr style=""><td>'+indicator_html+'</td><td>'+str_frequent+'</td><td>'+expired+'</td><td><a href="http://manggiaodich.vn/manage/delete?id='+result.indicator_id+'" class="badge bg-red">Xóa</a></td></tr>';
								$('#table_indicator tr').eq(0).after(html_append).slideDown();
								$('#modal_success').modal('show');
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
		
		
		$(document).ready(function(){
            _constructor();
        });
    };
    win.Custom = obj;
})(jQuery, window);